<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules for employee data.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "fname"=>"required",
            "lname"=>"required",
            "email"=>"email|unique:employees,email",
            "phone"=>"required|min:10|numeric",
            "company_id"=>"required"
        ];
    }

    public function messages()
{
    return [
        'fname.required' => 'The First name field is required.',
        'lname.required' => 'The Last name field is required.',
        'email.email' => 'The email must be a valid email address.',
    ];
}
}
