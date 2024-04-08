<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class   UserStore extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = Route::input('user');

        $emailRule='required|email|unique:users,email';

        // Validation d'unicité en ignorant l'ID de l'utilisateur en cours de modification
        if($this->method() == 'PATCH'){
            $emailRule .= ','.$userId;
        }

        return [
            'name' => 'required',
            'email' => $emailRule,
            'password' => 'required|min:8',
        ];

    }
}
