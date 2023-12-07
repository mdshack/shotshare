<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
    protected array $allowedTypes = [
        'jpg',
        'png',
        'svg',
        'webp',
        'gif',
    ];

    // /**
    //  * Determine if the user is authorized to make this request.
    //  */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'images'   => ['array', 'min:1', 'max:1'],
            'images.*' => ['mimes:'. implode(',', $this->allowedTypes)]
        ];
    }

    public function messages() : array
    {
        return [
            'images'   => 'You must upload no more than 1 image at a time.',
            'images.*' => "You may only upload one of the following types: " . implode(', ', $this->allowedTypes)
        ];
    }
}
