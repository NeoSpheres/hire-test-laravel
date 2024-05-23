<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('post')) {
            return $this->getPostRules();
        } elseif ($this->isMethod('patch')) {
            return $this->getPutRules();
        }

        return [];
    }

    private function getPostRules(): array
    {
        return [
            'model_id' => 'required|exists:modeles,id',
            'user_id' => 'nullable|exists:users,id',
            'color' => 'required|string|max:25',
            'front_tire_id' => 'required|exists:tires,id',
            'rear_tire_id' => 'required|exists:tires,id',
        ];
    }

    private function getPutRules(): array
    {
        return [
            'user_id' => 'nullable|exists:users,id',
            'color' => 'required|string|max:25',
            'front_tire_id' => 'required|exists:tires,id',
            'rear_tire_id' => 'required|exists:tires,id',
        ];
    }

}
