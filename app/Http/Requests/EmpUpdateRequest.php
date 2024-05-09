<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpUpdateRequest extends FormRequest
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
        return [
            "fname"=>"required",
            "lname"=>"required",
            "email"=>"email",
            "phone"=>"required|min:10|numeric"
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
