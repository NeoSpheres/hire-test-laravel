<?php

namespace App\Http\Requests;

use App\Rules\MatriculeFrance;
use Illuminate\Foundation\Http\FormRequest;

class ModeleStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'idBrand' => 'required|exists:brands,id',
            'color'=>'required',
            'matricule'=>['required|unique:modeles',new MatriculeFrance],
            'engine'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'matricule.required' => 'La plaque d\'immatriculation est requise.',
        ];
    }
}
