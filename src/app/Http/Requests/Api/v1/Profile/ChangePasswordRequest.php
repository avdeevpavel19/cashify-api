<?php

namespace App\Http\Requests\Api\v1\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'current_password' => ['required'],
            'new_password'     => ['required', 'string', 'min:5'],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'Текущий пароль обязателен к заполнению.',
            'new_password.required'     => 'Новый пароль обязателен к заполнению.',
            'new_password.string'       => 'Новый пароль должен быть строкой.',
            'new_password.min'          => 'Новый пароль должен содержать не менее 5 символов.',
        ];
    }
}
