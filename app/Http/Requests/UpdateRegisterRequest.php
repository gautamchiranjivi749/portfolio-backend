<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',

            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($this->user),
            ],

            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->user),
            ],

            'password' => 'nullable|string|min:6|confirmed',
        ];
    }
}