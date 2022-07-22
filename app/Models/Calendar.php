<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;

    protected $table = 'calendar';

    protected $fillable = [
        'date',
        'reason',
    ];

    public static function add($data)
    {
        $calendar = new Calendar();
        $calendar->date = $data['date'];
        $calendar->reason = $data['reason'];
        $add = $calendar->save();

        if ($add) return true;
        return false;
    }
}
