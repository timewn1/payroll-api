<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExcelDownload extends Model
{
    use HasFactory;

    protected $table = 'excel_download';

    protected $fillable = [
        'date',
        'day',
        'dept',
        'employee_id',
        'name',
        'time_in',
        'lunch_time_in',
        'lunch_time_out',
        'time_out',
        'dinner_time_in',
        'dinner_time_out',
        'ot_time_out',
        'working_hours',
        'regular',
        'ot',
        'early_out',
        'lunch_duration',
        'dinner_duration',
        'half_day',
    ];
}
