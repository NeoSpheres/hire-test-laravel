<?php

declare(strict_types=1);

namespace App\DTO\TireMaintenance;

use App\Enums\TireMaintenance\TirePositionEnum;

readonly final class TireMaintenanceTireDto
{
    /**
     * @param int $tireId
     * @param TirePositionEnum $position
     */
    public function __construct(
        public int              $tireId,
        public TirePositionEnum $position,
    ) {}
}
