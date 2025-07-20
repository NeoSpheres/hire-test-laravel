<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use App\DTO\TireMaintenance\TireMaintenanceRequestDto;
use App\Enums\TireMaintenance\TireMaintenanceRequestStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\TireMaintenance\TireMaintenanceProcessRequest;
use App\Http\Requests\TireMaintenance\TireMaintenanceRequest;
use App\Services\Contracts\ITireMaintenanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Tag(
 *     name="Tire Maintenance",
 *     description="Tire maintenance request management"
 * )
 *
 * @OA\Schema(
 *     schema="TireMaintenanceRequest",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="car_id", type="integer", example=10),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="status", type="string", enum={"pending", "in_progress", "completed", "cancelled"}, example="pending"),
 *     @OA\Property(property="maintenance_scheduled_at", type="string", format="date-time", example="2024-07-20T10:00:00Z"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(property="car", type="object", nullable=true),
 *     @OA\Property(property="user", type="object", nullable=true),
 *     @OA\Property(
 *         property="tires",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/TireMaintenanceTire")
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="TireMaintenanceTire",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="position", type="string", enum={"front_left", "front_right", "rear_left", "rear_right"}, example="front_left"),
 *     @OA\Property(property="tire_id", type="integer", example=5)
 * )
 */
class TireMaintenanceController extends Controller
{
    /**
     * @param ITireMaintenanceService $service
     */
    public function __construct(protected ITireMaintenanceService $service)
    {

    }

    /**
     * @OA\Get(
     *     path="/api/tire-maintenance",
     *     tags={"Tire Maintenance"},
     *     summary="List tire maintenance requests",
     *     @OA\Parameter(
     *         name="filters",
     *         in="query",
     *         required=false,
     *         description="Filter parameters",
     *         @OA\Schema(type="object")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of tire maintenance requests",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/TireMaintenanceRequest"))
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        return $this->callService(
            fn() => $this->service->index($request->get('filters', []))
        );
    }

    /**
     * @OA\Post(
     *     path="/api/tire-maintenance",
     *     tags={"Tire Maintenance"},
     *     summary="Create a new tire maintenance request",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"car_id", "maintenance_scheduled_at", "tires"},
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="car_id", type="integer", example=10),
     *             @OA\Property(property="maintenance_scheduled_at", type="string", format="date-time", example="2024-07-20T10:00:00Z"),
     *             @OA\Property(
     *                 property="tires",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     required={"tire_id", "position"},
     *                     @OA\Property(property="tire_id", type="integer", example=5),
     *                     @OA\Property(
     *                         property="position",
     *                         type="string",
     *                         enum={"front_left", "front_right", "rear_left", "rear_right"},
     *                         example="front_left"
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tire maintenance request created",
     *         @OA\JsonContent(ref="#/components/schemas/TireMaintenanceRequest")
     *     )
     * )
     */
    public function store(TireMaintenanceRequest $request)
    {
        return $this->callService(
            fn() => $this->service->store(
                new TireMaintenanceRequestDto(
                    carId: $request->input('car_id'),
                    maintenanceScheduledAt: $request->input('maintenance_scheduled_at'),
                    tires: $request->input('tires'),
                    userId: $request->input('user_id'),
                )
            )
        );
    }

    /**
     * @OA\Put(
     *     path="/api/tire-maintenance/process/{request_id}",
     *     tags={"Tire Maintenance"},
     *     summary="Process a tire maintenance request",
     *     @OA\Parameter(
     *         name="request_id",
     *         in="path",
     *         required=true,
     *         description="ID of the tire maintenance request",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"status"},
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 enum={"pending", "in_progress", "completed", "cancelled"},
     *                 example="completed"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tire maintenance request processed",
     *         @OA\JsonContent(ref="#/components/schemas/TireMaintenanceRequest")
     *     )
     * )
     */
    public function process(int $requestId, TireMaintenanceProcessRequest $request): JsonResponse
    {
        return $this->callService(
            fn() => $this->service->process(
                $requestId,
                TireMaintenanceRequestStatusEnum::from($request->input('status'))
            )
        );
    }
}
