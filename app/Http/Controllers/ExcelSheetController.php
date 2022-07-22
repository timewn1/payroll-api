<?php

namespace App\Http\Controllers;

use App\Exports\ExcelSheetExport;
use App\Http\Requests\ExcelSheetUploadRequest;
use App\Imports\ExcelSheetImport;
use App\Models\Calendar;
use App\Models\ExcelSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExcelSheetController extends Controller
{
    public function upload(ExcelSheetUploadRequest $request)
    {
        set_time_limit(0);
        ExcelSheet::query()->update(['added_new' => 0]);
        Excel::import(new ExcelSheetImport(), $request->file);
        return response(['success' => true, 'msg' => "Uploaded successfully!", 'data' => ExcelSheet::limit(10)->orderBy('employee_id', 'asc')->where('added_new', 1)->get(), 'total' => ExcelSheet::where('added_new', 1)->count()]);
    }

    public function uploaded($page)
    {
        return response(['data' => ExcelSheet::where('added_new', 1)->orderBy('employee_id', 'asc')->paginate(10, ['*'], 'page', $page)], 200);
    }

    public function all()
    {
        return response(['data' => ExcelSheet::limit(10)->orderBy('employee_id', 'asc')->get(), 'total' => ExcelSheet::count()], 200);
    }

    public function columnUpdate(Request $request)
    {
        $id = $request->id;
        $column = $request->name;
        $value = $request->value;

        $excel = ExcelSheet::find($id);
        $excel->$column = $value;
        $excel->is_edited = 1;

        ExcelSheet::updatedColumns($id, $column);

        if ($excel->save()) return response(['message' => 'updated'], 200);
        return response(['message' => 'something went wrong'], 500);
    }

    public function status($status, $id)
    {
        if ($status === "ignore") ExcelSheet::ignore($id);
        else if ($status === "noPay") ExcelSheet::noPay($id);
        else ExcelSheet::defaultOption($id);
    }

    public function set($date)
    {

        if ($date !== "default") {
            return response(['data' => ExcelSheet::where(DB::raw("DATE_FORMAT(date, '%M-%Y')"), $date)->select(DB::raw("DATE_FORMAT(date, '%M-%Y') as month_year"))
                ->groupBy('month_year')
                ->get(),
                'total' => ExcelSheet::where(DB::raw("DATE_FORMAT(date, '%M-%Y')"), $date)->select(DB::raw("DATE_FORMAT(date, '%M-%Y') as month_year"))
                    ->groupBy('month_year')
                    ->get()->count()], 200);
        } else {
            return response(['data' => ExcelSheet::select(DB::raw("DATE_FORMAT(date, '%M-%Y') as month_year"))
                ->groupBy('month_year')
                ->limit(10)
                // ->orderBy('date', 'asc')
                ->get(),
                'total' => ExcelSheet::select(DB::raw("DATE_FORMAT(date, '%M-%Y') as month_year"))
                    ->groupBy('month_year')
                    ->get()->count()], 200);
        }
    }

    public function perPage($page)
    {
        return response(['data' => ExcelSheet::select(DB::raw("DATE_FORMAT(date, '%M-%Y') as month_year"))
            ->groupBy('month_year')->orderBy('date', 'asc')->paginate(10, ['*'], 'page', $page)], 200);
    }

    public function get($page, $month, $date)
    {

        if ($month == "default" && $date == "default")
            return response(['data' => ExcelSheet::orderBy('name', 'asc')->paginate(10, ['*'], 'page', $page)], 200);
        else if ($month !== "default" && $date == "default")
            return response(['data' => ExcelSheet::where(DB::raw("DATE_FORMAT(date, '%M-%Y')"), $month)->orderBy('name', 'asc')->paginate(10, ['*'], 'page', $page)], 200);
        else if ($month == "default" && $date !== "default")
            return response(['data' => ExcelSheet::where(DB::raw("DATE_FORMAT(date, '%d-%M-%Y')"), $date)->orderBy('name', 'asc')->paginate(10, ['*'], 'page', $page)], 200);
    }

    public function date($date)
    {
        return response(['data' => ExcelSheet::where(DB::raw("DATE_FORMAT(date, '%d-%M-%Y')"), $date)->get(),
            'total' => ExcelSheet::where(DB::raw("DATE_FORMAT(date, '%d-%M-%Y')"), $date)->get()->count()], 200);
    }

    public function month($month)
    {
        return response(['data' => ExcelSheet::where(DB::raw("DATE_FORMAT(date, '%M-%Y')"), $month)->limit(10)->get(),
            'total' => ExcelSheet::where(DB::raw("DATE_FORMAT(date, '%M-%Y')"), $month)->get()->count()], 200);
    }

    public function search($word)
    {
        return response(['data' => ExcelSheet::where('name', 'like', '%' . $word . '%')->orWhere('employee_id', 'like', '%' . $word . '%')->limit(10)->orderBy('name', 'asc')->get(), 'total' => ExcelSheet::where('name', 'like', '%' . $word . '%')->orWhere('employee_id', 'like', '%' . $word . '%')->get()->count()], 200);
    }

    public function getEmployee($employee_id, $date)
    {
        return response(['data' => ExcelSheet::where('employee_id', $employee_id)->where('is_ignored', '!=', 2)->where(DB::raw("DATE_FORMAT(date, '%M-%Y')"), $date)->orderBy('date', 'asc')->get(), 'approvedDates' => Calendar::where(DB::raw("DATE_FORMAT(date, '%M-%Y')"), $date)->get()], 200);
    }

    public function download($data)
    {
        $file_name = 'Excel-' . $data . '.xlsx';
        return (new ExcelSheetExport($data))->download($file_name, \Maatwebsite\Excel\Excel::XLSX);
    }

    public function getAll()
    {
        return response(['data' => ExcelSheet::get()->all()]);
    }
}
