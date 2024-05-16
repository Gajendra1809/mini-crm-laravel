<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateRequest extends FormRequest
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
        $companyId = $this->route('company');
    
        return [
            "name" => "required|min:5|unique:companies,name," . $companyId,
            "email" => "required|email|unique:companies,email," . $companyId,
            "logo" => "image|dimensions:min_width=100,min_height=100",
            "website" => "required|url"
        ];
    }
}
