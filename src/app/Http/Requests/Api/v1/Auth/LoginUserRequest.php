<?php

namespace App\Http\Requests\Api\v1\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
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
            'email'    => ['required', 'email', 'exists:users,email'],
            'password' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'Адрес электронной почты обязателен к заполнению.',
            'email.email'       => 'Адрес электронной почты должен быть действительным электронным адресом.',
            'email.exists'      => 'Указанный адрес электронной почты не найден.',
            'password.required' => 'Пароль обязателен к заполнению.',
        ];
    }
}
