<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\TireMaintenance\TireMaintenanceRequestDto;
use App\Enums\TireMaintenance\TireMaintenanceRequestStatusEnum;
use App\Events\TireMaintenance\TireMaintenanceRequestCancelledEvent;
use App\Events\TireMaintenance\TireMaintenanceRequestCompletedEvent;
use App\Events\TireMaintenance\TireMaintenanceRequestInProgressEvent;
use App\Events\TireMaintenance\TireMaintenanceRequestSubmittedEvent;
use App\Exceptions\StateConflictException;
use App\Http\Resources\TireMaintenanceRequestResource;
use App\Models\Car;
use App\Models\Tire;
use App\Models\TireMaintenance\TireMaintenanceRequest;
use App\Models\User;
use App\Services\Contracts\ITireMaintenanceService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 *        /\     /\
 *       {  `---'  }
 *       {  O   O  }
 *       ~~>  V  <~~
 *        \  \|/  /
 *         `-----'____
 *         /     \    \_
 *        {       }\  )_\_   This is the service cat. It handles... stuff.
 *        |  \_/  |/ /  \\
 *         \__/  /(_/    \\
 *           (__/
 */
class TireMaintenanceService implements ITireMaintenanceService
{
    /**
     * @param array $filters
     * @return ResourceCollection
     */
    public function index(array $filters = []): ResourceCollection
    {
        // For the proof of concept I'm not gonna limit what we select, but I'm considering it for production :P
        $query = TireMaintenanceRequest::with([
            'car',
            'user',
            'tires'
        ]);

        // Simple filtering. Better use a package for the purpose. https://github.com/abbasudo/laravel-purity
        if (Arr::has($filters, 'car_model')) {
            $query->whereHas('car.modele', function ($q) use ($filters) {
                $q->whereRaw('LOWER(modeles."nomModel") LIKE ?', ['%' . Str::lower($filters['car_model']) . '%']);
            });
        }

        if (Arr::has($filters, 'car_brand')) {
            $query->whereHas('car.modele.brand', function ($q) use ($filters) {
                $q->whereRaw('LOWER(brands."name") LIKE ?', ['%' . Str::lower($filters['car_brand']) . '%']);
            });
        }

        if (Arr::has($filters, 'plate_number')) {
            $query->whereHas('car', function ($q) use ($filters) {
                $q->whereRaw('LOWER(cars."matricule") LIKE ?', ['%' . Str::lower($filters['plate_number']) . '%']);
            });
        }

        if (Arr::has($filters, 'username')) {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->whereRaw('LOWER(users."name") LIKE ?', ['%' . Str::lower($filters['username']) . '%']);
            });
        }

        return TireMaintenanceRequestResource::collection($query->orderBy('created_at')->paginate());
    }

    /**
     * @param TireMaintenanceRequestDto $dto
     * @return TireMaintenanceRequestResource
     * @throws StateConflictException
     */
    public function store(TireMaintenanceRequestDto $dto): TireMaintenanceRequestResource
    {
        $car = Car::findOrFail($dto->carId);

        if (!is_null($dto->userId)) {
            $user = User::findOrFail($dto->userId);

            if ($car->user_id !== $user->id) {
                throw new StateConflictException(__('The user does not own the car.'));
            }
        } else {
            $user = $car->user;
        }

        $tireRequestQty = collect($dto->tires)
            ->groupBy(fn($tireDto) => $tireDto->tireId)
            ->map(fn($group) => $group->count());

        $tires = Tire::whereIn('id', $tireRequestQty->keys())->get()->keyBy('id');

        foreach ($tireRequestQty as $tireId => $qty) {
            $tire = $tires->get($tireId);

            if (!$tire) {
                throw new ModelNotFoundException(__('Tire not found: :tireId', ['tireId' => $tireId]));
            }

            if ($tire->quantity < $qty) {
                throw new StateConflictException(__('Not enough tires in stock for tire ID: :tireId', ['tireId' => $tireId]));
            }
        }

        // Check for conflicting requests
        $tireIds = collect($dto->tires)->map(fn($tireDto) => $tireDto->tireId)->unique()->values();

        $conflictingRequest = TireMaintenanceRequest::where('car_id', $car->id)
            ->where('user_id', $user->id)
            ->whereIn('status', [
                TireMaintenanceRequestStatusEnum::PENDING,
                TireMaintenanceRequestStatusEnum::IN_PROGRESS,
            ])
            ->whereHas('tires', function ($query) use ($tireIds) {
                $query->whereIn('tire_id', $tireIds);
            })
            ->exists();

        if ($conflictingRequest) {
            throw new \App\Exceptions\StateConflictException(__('There is already a pending or in-progress maintenance request for this car, user, and at least one of the selected tires.'));
        }

        $tireMaintenanceRequest = new TireMaintenanceRequest();
        $tireMaintenanceRequest->car_id = $car->id;
        $tireMaintenanceRequest->user_id = $user->id;
        $tireMaintenanceRequest->status = TireMaintenanceRequestStatusEnum::PENDING;
        $tireMaintenanceRequest->maintenance_scheduled_at = Carbon::parse($dto->maintenanceScheduledAt)->toDateString();
        $tireMaintenanceRequest->save();

        $tireMaintenanceRequest->tires()->createMany(collect($dto->tires)->map(fn ($tireDto) => [
            'tire_maintenance_request_id' => $tireMaintenanceRequest->id,
            'tire_id' => $tireDto->tireId,
            'position' => $tireDto->position->value,
        ]));

        event(new TireMaintenanceRequestSubmittedEvent($tireMaintenanceRequest));

        return new TireMaintenanceRequestResource($tireMaintenanceRequest->loadMissing(['tires', 'car', 'user']));
    }

    /**
     * @param int $requestId
     * @param TireMaintenanceRequestStatusEnum $status
     * @return TireMaintenanceRequestResource
     * @throws StateConflictException
     */
    public function process(int $requestId, TireMaintenanceRequestStatusEnum $status): TireMaintenanceRequestResource
    {
        $tireMaintenanceRequest = TireMaintenanceRequest::findOrFail($requestId);

        $this->validateStatusTransition($tireMaintenanceRequest, $status);

        switch ($status) {
            case TireMaintenanceRequestStatusEnum::IN_PROGRESS:
                $tireMaintenanceRequest->status = $status;

                event(new TireMaintenanceRequestInProgressEvent($tireMaintenanceRequest));
                break;
            case TireMaintenanceRequestStatusEnum::COMPLETED:
                $tireMaintenanceRequest->status = $status;

                event(new TireMaintenanceRequestCompletedEvent($tireMaintenanceRequest));
                break;
            case TireMaintenanceRequestStatusEnum::CANCELLED:
                // Re-stock tires
                $tireCounts = $tireMaintenanceRequest->tires
                    ->groupBy('tire_id')
                    ->map(fn ($items) => $items->count());

                $tires = Tire::whereIn('id', $tireCounts->keys())->get()->keyBy('id');

                foreach ($tireCounts as $tireId => $qty) {
                    if (! $tires->has($tireId)) {
                        throw new ModelNotFoundException(__('Tire ID :tireId not found.', ['tireId' => $tireId]));
                    }

                    $tires[$tireId]->increment('quantity', $qty);
                }

                $tireMaintenanceRequest->status = $status;

                event(new TireMaintenanceRequestCancelledEvent($tireMaintenanceRequest));
                break;
            default:
                throw new StateConflictException(__('Invalid status transition.'));
        }

        $tireMaintenanceRequest->save();

        return new TireMaintenanceRequestResource($tireMaintenanceRequest);
    }

    /**
     * @param TireMaintenanceRequest $tireMaintenanceRequest
     * @param TireMaintenanceRequestStatusEnum $newStatus
     * @return void
     * @throws StateConflictException
     */
    protected function validateStatusTransition(
        TireMaintenanceRequest $tireMaintenanceRequest, TireMaintenanceRequestStatusEnum
        $newStatus
    ): void
    {
        if ($newStatus === TireMaintenanceRequestStatusEnum::PENDING) {
            throw new StateConflictException(__('Initial status was PENDING, so the request cannot be set to PENDING again.'));
        }

        if (
            $newStatus === TireMaintenanceRequestStatusEnum::IN_PROGRESS &&
            $tireMaintenanceRequest->status !== TireMaintenanceRequestStatusEnum::PENDING
        ) {
            throw new StateConflictException(__('Cannot set status to IN_PROGRESS. The request is not in PENDING state.'));
        }

        if (
            $newStatus === TireMaintenanceRequestStatusEnum::COMPLETED &&
            $tireMaintenanceRequest->status !== TireMaintenanceRequestStatusEnum::IN_PROGRESS
        ) {
            throw new StateConflictException(__('Cannot set status to COMPLETED. The request is not in IN_PROGRESS state.'));
        }

        if (
            $newStatus === TireMaintenanceRequestStatusEnum::CANCELLED &&
            $tireMaintenanceRequest->status === TireMaintenanceRequestStatusEnum::COMPLETED
        ) {
            throw new StateConflictException(__('Cannot cancel a completed request.'));
        }
    }
}

