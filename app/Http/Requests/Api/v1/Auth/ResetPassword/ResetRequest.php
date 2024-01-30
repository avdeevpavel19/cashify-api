<?php

namespace App\Http\Requests\Api\v1\Auth\ResetPassword;

use Illuminate\Foundation\Http\FormRequest;

class ResetRequest extends FormRequest
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
        return [
            'password' => ['required', 'string', 'confirmed', 'min:5'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.required'  => 'Пароль обязателен к заполнению.',
            'password.string'    => 'Пароль должен быть строкой.',
            'password.confirmed' => 'Пароли не совпадают.',
            'password.min'       => 'Пароль должен содержать не менее 5 символов.',
        ];
    }
}
