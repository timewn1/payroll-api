<?php

namespace App\Exports;

use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExport implements FromQuery, WithHeadings
{
    use Exportable;

    public function __construct($data)
    {
        $this->date = $data;
    }

    public function query()
    {
        if ($this->date !== "default") {
            return Employee::where(DB::raw("DATE_FORMAT(created_at, '%M-%Y')"), $this->date)->orderBy('employee_id', 'asc')->select('employee_id', 'uname as username', 'nic', 'email', 'fname', 'lname', 'user_role', 'phone', 'address', 'basic_salary as monthly salary');
        } else {
            return Employee::where('is_deleted', 0)->orderBy('employee_id', 'asc')->select('employee_id', 'uname as username', 'nic', 'email', 'fname', 'lname', 'user_role', 'phone', 'address', 'basic_salary as monthly salary');
        }
    }

    public function headings(): array
    {
        return array_keys($this->query()->first()->toArray());
    }
}
