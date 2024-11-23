<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorizationRequest extends FormRequest
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
        $rules = [
            'role' => ['required', 'min:2', 'max:60'],
            'permessions' => ['required', 'array', 'min:1'],
        ];

        if ($this->isMethod('post')) {
            $rules['role'][] = 'unique:authorizations,role';
        }

        if ($this->isMethod('put')) {
            $rules['role'][] = 'unique:authorizations,role,' . $this->route('authorization');
        }

        return $rules;
    }
}
