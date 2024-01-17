<?php

namespace App\Http\Requests\Api\v1\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ChangeCurrencyRequest extends FormRequest
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
            'currency_id' => ['required', 'numeric', 'exists:currencies,id']
        ];
    }

    public function messages()
    {
        return [
            'currency_id.required' => 'currency_id является обязательным.',
            'currency_id.numeric' => 'currency_id должно быть числовым.',
            'currency_id.exists' => 'Указанной валюты не существует.'
        ];
    }
}
