<?php

namespace App\Http\Requests\Api\v1\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'belongs_to' => ['sometimes', 'string', 'max:255'],
            'name' => ['sometimes', 'string', 'max:255']
        ];
    }

    public function messages()
    {
        return [
            'belongs_to.string' => 'Поле "belongs_to" должно быть строкой.',
            'belongs_to.max' => 'Поле "belongs_to" не должно превышать 255 символов.',
            'name.string' => 'Название должно быть строкой.',
            'name.max' => 'Название не должно превышать 255 символов.',
        ];
    }
}
