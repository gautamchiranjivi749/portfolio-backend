<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCertificateRequest extends FormRequest
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
        'title' => 'required|string|max:255',
        'organization' => 'required|string|max:255',
        'issue_date' => 'nullable|date',
        'credential_url' => 'nullable|url',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'sort_order' => 'nullable|integer',
        'status' => 'nullable|boolean',
        ];
    }
}
