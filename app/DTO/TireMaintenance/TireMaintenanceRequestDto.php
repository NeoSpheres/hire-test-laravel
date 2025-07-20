<?php

declare(strict_types=1);

namespace App\DTO\TireMaintenance;

use App\Enums\TireMaintenance\TirePositionEnum;

final class TireMaintenanceRequestDto
{
    /**
     * @param int $carId
     * @param int|null $userId
     * @param array $tires
     */
    public function __construct(
        public int $carId,
        public string $maintenanceScheduledAt,
        public array $tires,
        public ?int $userId,
    ) {
        $this->tires = collect($tires)->map(function (array $item) {
            return new TireMaintenanceTireDto(
                tireId: (int) $item['tire_id'],
                position: TirePositionEnum::from($item['position']),
            );
        })->all();
    }
}
