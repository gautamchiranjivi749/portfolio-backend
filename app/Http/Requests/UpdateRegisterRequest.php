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
        $user = $this->route('user');

        return [
            'name' => 'required|string|max:255',

            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($user),
            ],

            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user),
            ],
        ];
    }
}