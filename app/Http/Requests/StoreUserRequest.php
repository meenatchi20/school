<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\validation\Rule;
class StoreUserRequest extends FormRequest
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
         //         $id = $this->route('id');
    //         return [
    //             'email'=> ['required',
    //                        'email',
    //                        Rule::unique('student_data','email')->ignore($id)],

    //             'phone_no'=> 'required|unique:student_data,phone_no|numeric',
    //             'first_name'=>'required',
    //             'last_name'=>'required',
    //             'age'=>'required',
    //         ];
    //     }

    //     public function messages(): array
    //     {
    //         return [
    //             'email.unique' => 'Emails is already exists',
    //             'phone_no.unique' => 'Phone Number is already exists'
    //         ];

    // }


            $id = $this->route('id'); // Gets the ID from the route (works for update)

            return [
                'email' => [
                    'required',
                    'email',
                    Rule::unique('student', 'email')->ignore($id),
                ],
                'phone_no' => [
                    'required',
                    'numeric',
                    Rule::unique('student', 'phone_no')->ignore($id),
                ],
                'first_name' => 'required',
                'last_name' => 'required',
                'age' => 'required|integer',
                'department_name' => 'required|string|max:255',
                //'subject_name' => 'required|string|max:255',
];

}
    }

