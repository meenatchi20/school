<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentAuthRequest extends FormRequest
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
        $id = $this->route('id') ?? null; 
         //signup validation
            return [
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users', 'email')->ignore($id),
                ],
                'mobileNo' => [
                    'required',
                    'numeric',
                    Rule::unique('users', 'mobileNo')->ignore($id),
                ],
                 'name' => 'required',
                 'password' => 'required|confirmed',
                 'password_confirmation' => 'required',
                 // 'role' => 'required|string',
                 'role_id' => 'required|integer|exists:role,id'
            ];

            
    }
}
