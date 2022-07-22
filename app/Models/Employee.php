<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nic',
        'employee_id',
        'uname',
        'email',
        'fname',
        'mname',
        'lname',
        'age',
        'user_role',
        'phone',
        'address',
        'dob',
        'is_deleted',
        'basic_salary',
    ];

    public static function create($data)
    {
        $employee = new Employee();
        $employee->employee_id = $data['employee_id'];
        $employee->uname = $data['uname'];
        $employee->nic = $data['nic'];
        $employee->email = $data['email'];
        $employee->fname = $data['fname'];
        $employee->mname = $data['mname'];
        $employee->lname = $data['lname'];
        $employee->age = $data['age'];
        $employee->user_role = $data['user_role'];
        $employee->phone = $data['phone'];
        $employee->emergency_contact = $data['emergency_contact'];
        $employee->education = $data['education'];
        $employee->experience = $data['experience'];
        $employee->skill = $data['skill'];
        $employee->address = $data['address'];
        $employee->dob = $data['dob'];
        $employee->basic_salary = $data['basic_salary'];

        $add = $employee->save();
        if ($add) return true;
        return false;
    }

    public static function edit($data)
    {
        $employee = Employee::find($data['id']);
        $employee->employee_id = $data['employee_id'];
        $employee->uname = $data['uname'];
        $employee->nic = $data['nic'];
        $employee->email = $data['email'];
        $employee->fname = $data['fname'];
        $employee->mname = $data['mname'];
        $employee->lname = $data['lname'];
        $employee->age = $data['age'];
        $employee->user_role = $data['user_role'];
        $employee->phone = $data['phone'];
        $employee->emergency_contact = $data['emergency_contact'];
        $employee->education = $data['education'];
        $employee->experience = $data['experience'];
        $employee->skill = $data['skill'];
        $employee->address = $data['address'];
        $employee->dob = $data['dob'];
        $employee->basic_salary = $data['basic_salary'];

        $update = $employee->save();
        if ($update) return true;
        return false;
    }

    public static function remove($id)
    {
        Employee::find($id)->update(['is_deleted' => 1]);
        return true;
    }
}
