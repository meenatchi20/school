<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreTempStudentdata extends FormRequest
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
        
            $id = $this->route('id'); 
            return [
                'email' => [
                    'required',
                    'email',
                    Rule::unique('student_temp_data', 'email')->ignore($id),
                ],
                'phone_no' => [
                    'required',
                    'numeric',
                    Rule::unique('student_temp_data', 'phone_no')->ignore($id),
                ],
                'first_name' => 'required',
                'last_name' => 'required',
                'age' => 'required|integer',
                'department_id' => 'required|string|max:255',
                'subject_name.*' => 'required',
                
        ];

    }
}
