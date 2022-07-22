<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\Salary;
use Illuminate\Support\Facades\DB;

class SalaryController extends Controller
{
    public function all($date)
    {
        return response(['data' => Salary::getAll($date), 'approvedDates' => Calendar::where(DB::raw("DATE_FORMAT(date, '%M-%Y')"), $date)->get()], 200);
    }
}
