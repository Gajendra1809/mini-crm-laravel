<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules for company data.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|min:5|unique:companies,name",
            "email" => "required|email|unique:companies,email",
            "logo" => "image|dimensions:min_width=100,min_height=100",
            "website" => "required|url"
        ];
    }

    public function messages()
{
    return [
        'name.required' => 'The name field is required.',
        'name.min' => 'The name must be at least 5 characters.',
        'email.email' => 'The email must be a valid email address.',
        'logo.image' => 'The logo must be an image file.',
        'logo.dimensions' => 'The logo dimensions must be at least 100x100 pixels.',
        'website.required' => 'The website field is required.'
    ];
}
}
