<?php

namespace App\Http\Requests\Api\v1\Goal;

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
            'title'    => ['sometimes', 'string', 'max:255'],
            'amount'   => ['sometimes', 'numeric', 'min:0'],
            'deadline' => ['sometimes', 'date', 'after:today'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.string'   => 'Название должно быть строкой.',
            'title.max'      => 'Название не должно превышать 255 символов.',
            'amount.numeric' => 'Сумма должна быть числом.',
            'amount.min'     => 'Сумма должна быть не менее :min символов.',
            'deadline.date'  => 'Срок должен быть датой.',
            'deadline.after' => 'Срок должен быть после сегодняшней даты.',
        ];
    }
}
