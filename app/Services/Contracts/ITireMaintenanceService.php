<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use App\DTO\TireMaintenance\TireMaintenanceRequestDto;
use App\Enums\TireMaintenance\TireMaintenanceRequestStatusEnum;
use App\Http\Resources\TireMaintenanceRequestResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

interface ITireMaintenanceService
{
    /**
     * @param array $filters
     * @return ResourceCollection
     */
    public function index(array $filters = []): ResourceCollection;

    /**
     * @param TireMaintenanceRequestDto $dto
     * @return TireMaintenanceRequestResource
     */
    public function store(TireMaintenanceRequestDto $dto): TireMaintenanceRequestResource;

    /**
     * @param int $requestId
     * @param TireMaintenanceRequestStatusEnum $status
     * @return ResourceCollection
     */
    public function process(int $requestId, TireMaintenanceRequestStatusEnum $status): TireMaintenanceRequestResource;
}
