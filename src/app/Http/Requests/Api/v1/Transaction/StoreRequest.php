<?php

namespace App\Http\Requests\Api\v1\Transaction;

use Illuminate\Foundation\Http\FormRequest;

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
            'amount'      => ['required', 'numeric', 'between:0,9999999999.99'],
            'category_id' => ['required', 'integer'],
            'date'        => ['required', 'date'],
            'description' => ['string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required'      => 'Сумма обязательна для заполнения.',
            'amount.numeric'       => 'Сумма должна быть числом.',
            'amount.between'       => 'Сумма должна быть между 0 и 9999999999.',
            'category_id.required' => 'Поле "Категория" обязательно для заполнения.',
            'category_id.integer'  => 'Категория должна быть целым числом.',
            'date.required'        => 'Дата обязательна для заполнения.',
            'date.date'            => 'Дата должна быть действительной датой.',
            'description.string'   => 'Описание должно быть строкой.',
            'description.max'      => 'Описание не должно превышать 1000 символов.',
        ];
    }
}
