<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Salary extends Model
{
    use HasFactory;

    public static function getAll($date)
    {
        $arr = [];
        $employees = DB::table('employees')->join('excel_sheets', 'excel_sheets.employee_id', 'employees.employee_id')
            ->where('excel_sheets.is_ignored', '!=', 2)
            ->where(DB::raw("DATE_FORMAT(excel_sheets.date, '%M-%Y')"), $date)->select('employees.*')->orderBy('employees.id', 'asc')
            ->groupBy('employees.employee_id')->get();

        foreach ($employees as $employee) {
            $arr[] = [
                'id' => $employee->id,
                'employee_id' => $employee->employee_id,
                'uname' => $employee->uname,
                'nic' => $employee->nic,
                'email' => $employee->email,
                'fname' => $employee->fname,
                'lname' => $employee->lname,
                'user_role' => $employee->user_role,
                'phone' => $employee->phone,
                'address' => $employee->address,
                'basic_salary' => $employee->basic_salary,
                'data' => ExcelSheet::where('employee_id', $employee->employee_id)->where('is_ignored', '!=', 2)->select('date', 'time_in', 'time_out', 'time_in_lunch', 'time_out_lunch', 'dinner_time_in', 'dinner_time_out', 'ot_time_out', 'is_ignored')->where(DB::raw("DATE_FORMAT(date, '%M-%Y')"), $date)->orderBy('date', 'asc')->get()
            ];
        }

        return $arr;
    }
}
