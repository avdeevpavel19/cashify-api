<?php

namespace App\Http\Requests\Api\v1\Transaction;

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
            'amount'      => ['sometimes', 'numeric', 'between:0,999999.99'],
            'category_id' => ['sometimes', 'integer'],
            'date'        => ['sometimes', 'date'],
            'description' => ['sometimes', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'amount.numeric'      => 'Сумма должна быть числом.',
            'amount.between'      => 'Сумма должна быть между 0 и 999999.',
            'category_id.integer' => 'Категория должна быть целым числом.',
            'date.date'           => 'Дата должна быть действительной датой.',
            'description.string'  => 'Описание должно быть строкой.',
            'description.max'     => 'Описание не должно превышать 1000 символов.',
        ];
    }
}
