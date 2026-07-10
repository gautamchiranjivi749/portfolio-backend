<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEducationRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'institution' => 'required|string|max:255',
        'degree' => 'required|string|max:255',
        'field_of_study' => 'nullable|string|max:255',
        'start_year' => 'required|digits:4',
        'end_year' => 'nullable|digits:4',
        'description' => 'nullable|string',
        'sort_order' => 'nullable|integer',
        'status' => 'nullable|boolean',
        ];
    }
}
