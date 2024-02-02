<?php

namespace App\Http\Requests\Api\v1\Auth;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'     => 'Адрес электронной почты обязателен к заполнению.',
            'email.string'       => 'Адрес электронной почты должен быть строкой.',
            'email.email'        => 'Адрес электронной почты должен быть действительным электронным адресом.',
            'email.max'          => 'Адрес электронной почты не должен быть длиннее 255 символов.',
            'email.unique'       => 'Адрес электронной почты уже занят.',
            'password.required'  => 'Пароль обязателен к заполнению.',
            'password.string'    => 'Пароль должен быть строкой.',
            'password.min'       => 'Пароль должен содержать не менее 5 символов.',
            'password.confirmed' => 'Пароли не совпадают.',
        ];
    }
}
