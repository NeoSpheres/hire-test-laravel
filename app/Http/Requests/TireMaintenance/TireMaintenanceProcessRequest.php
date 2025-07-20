<?php

declare(strict_types=1);

namespace App\Http\Requests\TireMaintenance;

use App\Enums\TireMaintenance\TireMaintenanceRequestStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class TireMaintenanceProcessRequest extends FormRequest
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
            'status' => ['required', 'string', new Enum(TireMaintenanceRequestStatusEnum::class)],
        ];
    }
}
