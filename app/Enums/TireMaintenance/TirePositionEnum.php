<?php

declare(strict_types=1);

namespace App\Enums\TireMaintenance;

enum TirePositionEnum: string
{
    case FRONT_LEFT = 'front_left';
    case FRONT_RIGHT = 'front_right';
    case REAR_LEFT = 'rear_left';
    case REAR_RIGHT = 'rear_right';

    public function label(): string
    {
        return match ($this) {
            self::FRONT_LEFT => 'Front Left',
            self::FRONT_RIGHT => 'Front Right',
            self::REAR_LEFT => 'Rear Left',
            self::REAR_RIGHT => 'Rear Right',
        };
    }
}
