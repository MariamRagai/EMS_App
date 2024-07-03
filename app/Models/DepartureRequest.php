<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartureRequest extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "departure_request";
    protected $fillable = [
         'user_id',
         'reason',
         'Departure_time'
    ];

}
