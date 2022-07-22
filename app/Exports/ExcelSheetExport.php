<?php

namespace App\Exports;

use App\Models\ExcelSheet;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExcelSheetExport implements FromQuery, WithHeadings
{
    use Exportable;

    public function __construct($data)
    {
        $this->date = $data;
    }

    public function query()
    {
        if ($this->date !== "default") {
            return ExcelSheet::where(DB::raw("DATE_FORMAT(date, '%M-%Y')"), $this->date)->orderBy('employee_id', 'asc')->select('dept as Dept', 'employee_id as Employee ID', 'name as Name', 'enroll_id as Enroll ID', 'date as Date', 'time_in as Time In', 'time_in_lunch as Time In Lunch', 'time_out_lunch as Time Out Lunch', 'time_out as Time Out', 'dinner_time_in as Dinner time in', 'dinner_time_out as Dinner time out');
        } else {
            return ExcelSheet::where('added_new', 1)->orderBy('employee_id', 'asc')->select('dept as Dept', 'employee_id as Employee ID', 'name as Name', 'enroll_id as Enroll ID', 'date as Date', 'time_in as Time In', 'time_in_lunch as Time In Lunch', 'time_out_lunch as Time Out Lunch', 'time_out as Time Out', 'dinner_time_in as Dinner time in', 'dinner_time_out as Dinner time out');
        }
    }

    public function headings(): array
    {
        return array_keys($this->query()->first()->toArray());
    }
}
