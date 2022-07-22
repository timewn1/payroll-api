<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeUpdateRequest extends FormRequest
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
        $uniqueRule = Rule::unique('employees')->ignore($this->id);

        return [
            'employee_id' => 'required|' . $uniqueRule,
            'uname' => 'required|' . $uniqueRule,
            'nic' => 'required|' . $uniqueRule,
            'email' => 'required|' . $uniqueRule,
            'fname' => 'required',
            'age' => 'required',
            'user_role' => 'required',
            'phone' => 'required|' . $uniqueRule,
            'emergency_contact' => 'required|' . $uniqueRule,
            'education' => 'required',
            'experience' => 'required',
            'skill' => 'required',
            'address' => 'required',
            'dob' => 'required',
        ];
    }
}
