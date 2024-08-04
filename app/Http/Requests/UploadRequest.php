<?php

namespace App\Http\Requests;

use App\Enums\ShotType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UploadRequest extends FormRequest
{
    protected array $allowedTypes = [
        'jpg',
        'png',
        'svg',
        'webp',
        'gif',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'images' => ['array', 'min:1'],
            'images.*' => ['mimes:'.implode(',', $this->allowedTypes)],

            'name' => ['string', 'sometimes', 'nullable'],
            'type' => [Rule::enum(ShotType::class), 'sometimes', 'nullable'],
            'require_logged_in' => ['boolean', 'sometimes', 'nullable'],
            'anonymize' => ['boolean', 'sometimes', 'nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'images' => 'You must upload no more than 1 image at a time.',
            'images.*' => 'You may only upload one of the following types: '.implode(', ', $this->allowedTypes),
        ];
    }
}
