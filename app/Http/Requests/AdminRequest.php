<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
        $admin_id = $this->route('admin');
        $isUpdate = in_array($this->method(), ['PUT', 'PATCH']);

        return [
            'name' => ['required', 'min:2', 'max:60'],
            'username' => ['required', 'min:6', 'max:100', 'unique:admins,username,' . $admin_id],
            'email' => ['required', 'email', 'unique:admins,email,' . $admin_id],
            'status' => ['required', 'in:0,1'],
            'role_id' => ['required', 'exists:authorizations,id'], // Role ID Validation

            // Conditional Password Validation
            'password' => [$isUpdate ? 'nullable' : 'required', 'confirmed', 'min:8', 'max:100'],
            'password_confirmation' => [$isUpdate ? 'nullable' : 'required'],
        ];
    }

    /**
     * Custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // Error message for role_id field
            'role_id.required' => 'Please select a role for the admin.',
            'role_id.exists' => 'The selected role is invalid.',
        ];
    }
}
