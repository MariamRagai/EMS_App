<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table ="attendance";
    protected $fillable = [
        'id',
        'Attendance_time',
        'Departure_time',
        'user_id',
        'Day_date'
    ];
    protected $dates = [
        'Attendance_time',
        'Departure_time',
        'Day_date'
    ];
    public function employee()
    {
        return $this->belongsTo(User::class);
    }

}
