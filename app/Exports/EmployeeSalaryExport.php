<?php

namespace App\Exports;

use App\Models\ExcelDownload;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeSalaryExport implements FromQuery, WithHeadings
{
    use Exportable;


    public function __construct()
    {

    }

    public function query()
    {
        return ExcelDownload::orderBy('date', 'asc')->select('date as Date', 'dept as Department', 'employee_id as Employee ID', 'time_in as Time in', 'lunch_time_in as Lunch Time In', 'lunch_time_out as Lunch Time Out', 'time_out as Time Out', 'dinner_time_in as Dinner Time In', 'dinner_time_out as Dinner Time Out', 'ot_time_out as OT time our', 'working_hours as Working hours', 'regular as Regular', 'ot as OT', 'early_out as Early Out', 'lunch_duration as Lunch Duration', 'dinner_duration as Dinner duration', 'half_day as Half Day');
    }

    public function headings(): array
    {

        return array_keys($this->query()->first()->toArray());
    }
}
