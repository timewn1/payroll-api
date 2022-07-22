<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeExport;
use App\Exports\EmployeeSalaryExport;
use App\Http\Requests\EmployeePostRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Models\Employee;
use App\Models\ExcelDownload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function create(EmployeePostRequest $request)
    {
        if (Employee::create($request->all())) return response(['success' => true, 'msg' => 'Added'], 200);
        return response(['error' => true], 500);
    }

    public function get($id)
    {
        return response(['data' => Employee::find($id)], 200);
    }

    public function all($date)
    {
        if ($date == "default")
            return response(['data' => Employee::where('is_deleted', 0)->orderBy('employee_id', 'asc')->get()->all()], 200);
        else if ($date == "resigned")
            return response(['data' => Employee::where('is_deleted', 1)->orderBy('employee_id', 'asc')->get()->all()], 200);
        else
            return response(['data' => Employee::where('is_deleted', 0)->where(DB::raw("DATE_FORMAT(created_at, '%M-%Y')"), $date)->orderby('employee_id', 'asc')->get()], 200);
    }

    public function update(EmployeeUpdateRequest $request)
    {
        if (Employee::edit($request->all())) return response(['success' => true, 'msg' => 'Updated'], 200);
        return response(['error' => true], 500);
    }

    public function delete(Request $request)
    {
        if (Employee::remove($request->id)) return response(['success' => true, 'msg' => 'Deleted'], 200);
        return response(['error' => true], 500);
    }

    public function download($data)
    {
        $file_name = 'salary-' . $data . '.xlsx';
        return (new EmployeeExport($data))->download($file_name, \Maatwebsite\Excel\Excel::XLSX);
    }

    public function prepareDownload(Request $request)
    {
        $data = $request->data;
        ExcelDownload::truncate();
        ExcelDownload::insert($data);
    }

    public function salaryDownload($name, $month)
    {
        $file_name = $name . '-' . $month . '.xlsx';
        return (new EmployeeSalaryExport())->download($file_name, \Maatwebsite\Excel\Excel::XLSX);
    }
}
