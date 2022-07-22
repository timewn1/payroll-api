<?php

namespace App\Models;

use File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExcelSheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'dept',
        'employee_id',
        'name',
        'enroll_id',
        'date',
        'time_in',
        'time_in_lunch',
        'time_out_lunch',
        'time_out',
        'dinner_time_in',
        'dinner_time_out',
        'ot_time_out',
        'added_new',
        'edited_columns',
        'is_ignored',
        'is_edited',
    ];

    protected $dates = ['date'];

    public static $ignored = 1;
    public static $noPay = 2;

    public static function updatedColumns($id, $column)
    {
        $row = ExcelSheet::find($id);
        $columns = $row['edited_columns'];
        $array = explode(',', $columns);
        if (!in_array($column, $array, true)) {
            $row->edited_columns = $columns == "" ? $column : $columns . "," . $column;
            $row->save();
        }
    }

    public static function ignore($id)
    {
        $excel = ExcelSheet::find($id);
        $excel->is_ignored = static::$ignored;
        $excel->save();
    }

    public static function noPay($id)
    {
        $excel = ExcelSheet::find($id);
        $excel->is_ignored = static::$noPay;
        $excel->save();
    }

    public static function defaultOption($id)
    {
        $excel = ExcelSheet::find($id);
        $excel->is_ignored = 0;
        $excel->save();
    }
}
