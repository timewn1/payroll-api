<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'employee_id' => 'required|unique:employees',
            'uname' => 'required|unique:employees',
            'nic' => 'required|unique:employees',
            'email' => 'required|unique:employees',
            'fname' => 'required',
            'age' => 'required',
            'user_role' => 'required',
            'phone' => 'required',
            'emergency_contact' => 'required',
            'education' => 'required',
            'experience' => 'required',
            'skill' => 'required',
            'address' => 'required',
            'dob' => 'required',
        ];
    }
}
