<?php

namespace App\Http\Requests\Api\v1\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UploadAvatarRequest extends FormRequest
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
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:20480']
        ];
    }

    public function messages(): array
    {
        return [
            'avatar.required' => 'Загрузка аватара обязательна.',
            'avatar.image'    => 'Аватар должен быть изображением.',
            'avatar.mimes'    => 'Аватар должен быть в формате jpeg, png, jpg, gif.',
            'avatar.max'      => 'Аватар не должен превышать размер 20 МБ.',
        ];
    }
}
