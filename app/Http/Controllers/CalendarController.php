<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalendarPostRequest;
use App\Models\Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    public function create(CalendarPostRequest $request)
    {
        if (Calendar::add($request->all())) return response(['success' => true, 'msg' => 'Added!'], 200);
        return response(['error' => true], 500);
    }

    public function all($date)
    {
        if ($date == "default") return response(['data' => Calendar::get()->all()]);
        else return response(['data' => Calendar::where(DB::raw("DATE_FORMAT(date, '%M-%Y')"), $date)->get()]);
    }

    public function delete(Request $request)
    {
        Calendar::find($request->id)->delete();
    }

}
