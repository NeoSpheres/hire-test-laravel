<?php

declare(strict_types=1);

namespace App\Http\Requests\TireMaintenance;

use App\Enums\TireMaintenance\TirePositionEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules\Enum;

class TireMaintenanceRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function expectsJson(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_id' => ['integer'],
            'car_id' => ['required', 'integer'],
            'maintenance_scheduled_at' => ['required', 'date', 'after:' . Carbon::now()->addDay()->toDateTimeString()],
            'tires' => ['required', 'array'],
            'tires.*.tire_id' => ['required', 'integer'],
            'tires.*.position' => ['required', 'string', new Enum(TirePositionEnum::class)],
        ];
    }
}
