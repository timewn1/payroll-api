<?php

namespace App\Imports;

use App\Models\ExcelSheet;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExcelSheetImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $user_id = $row['user_id'];
        if (gettype($row['date']) === 'integer') $row['date'] = gmdate('Y-m-d', ($row['date'] - 25569) * 86400);
        $date = date('Y-m-d', strtotime($row['date']));

        if ($row['user_id'] === null) return;

        ExcelSheet::where('employee_id', $user_id)->where('date', $date)->delete();

        return new ExcelSheet([
            'dept' => $row['dept'],
            'name' => $row['name'],
            'employee_id' => $user_id,
            'enroll_id' => $row['enroll_id'],
            'date' => $date,
            'time_in' => $row['1'],
            'time_in_lunch' => $row['2'],
            'time_out_lunch' => $row['3'] == "" ? static::add($row['2']) : $row['3'],
            'time_out' => $row['4'],
            'dinner_time_in' => !isset($row['5']) ? "" : $row['5'],
            'dinner_time_out' => !isset($row['6']) ? "" : $row['6'] == "" && $row['5'] != "" ? static::add($row['5']) : isset($row['6']) ? $row[6] : "",
            'ot_time_out' => !isset($row['7']) ? "" : $row['7'],
            'is_edited' => $row['3'] == "" || (isset($row[5]) && $row[5] == '') ? 2 : 0
        ]);
    }

    public static function add($string, $minutes = '1800000')
    {
        if ($string == "") return "";

        $time = explode(":", $string);

        $hour = $time[0] * 60 * 60 * 1000;
        $minute = $time[1] * 60 * 1000;
        $second = $time[2] * 1000;

        $result = $hour + $minute + $second + $minutes;

//        echo $result . "\n";
//        echo $minute;
//        echo $second;

        return static::actualTime($result);
    }

    public static function actualTime($ms)
    {
        $seconds = floor($ms / 1000);
        $minutes = floor($seconds / 60);
        $hours = floor($minutes / 60);

        $milliseconds = $ms % 1000;
        $seconds = $seconds % 60;
        $minutes = $minutes % 60;

        $format = '%u:%02u:%02u';
        $time = sprintf($format, $hours, $minutes, $seconds);
        return rtrim($time, '0');
    }
}
