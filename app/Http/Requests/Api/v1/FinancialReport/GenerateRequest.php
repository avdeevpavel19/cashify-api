<?php

namespace App\Http\Requests\Api\v1\FinancialReport;

use Illuminate\Foundation\Http\FormRequest;

class GenerateRequest extends FormRequest
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
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date', 'after_or_equal:start_date']
        ];
    }

    public function messages(): array
    {
        return [
            'start_date.required'                => 'Дата начала обязательна для заполнения.',
            'start_date.date'                    => 'Дата начала должно быть корректной датой.',
            'end_date.required'                  => 'Дата окончания обязательна для заполнения.',
            'end_date.date'                      => 'Дата окончания должно быть корректной датой.',
            'end_date.after_or_equal:start_date' => 'Дата окончания должна быть датой после или равной даты начала.',
        ];
    }

}
