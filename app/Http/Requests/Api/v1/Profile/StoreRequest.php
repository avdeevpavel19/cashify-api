<?php

namespace App\Http\Requests\Api\v1\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
            'first_name' => ['sometimes', 'string', 'max:255'],
            'last_name' => ['sometimes', 'string', 'max:255'],
            'birthday' => ['sometimes', 'date', 'before_or_equal:today'],
            'gender' => ['sometimes', Rule::in(['male', 'female', 'not specified'])],
            'country' => ['sometimes', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'first_name.string' => 'Имя должно быть строкой.',
            'first_name.max' => 'Имя не должно превышать 255 символов.',
            'last_name.string' => 'Фамилия должна быть строкой.',
            'last_name.max' => 'Фамилия не должна превышать 255 символов.',
            'birthday.date' => 'Дата рождения должна быть в корректном формате.',
            'birthday.before_or_equal' => 'Дата рождения не может быть в будущем.',
            'gender.in' => 'Недопустимое значение для поля пол.',
            'country.string' => 'Страна должна быть строкой.',
            'country.max' => 'Страна не должна превышать 255 символов.',
        ];
    }
}
