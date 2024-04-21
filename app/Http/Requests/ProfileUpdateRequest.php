<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\ValidateHandle;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'handle' => ['sometimes', 'string', new ValidateHandle, Rule::unique(User::class)->ignore($this->user()->id)],
            'email' => ['sometimes', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'bio' => ['sometimes', 'nullable', 'string', 'max:500'],
        ];
    }
}
