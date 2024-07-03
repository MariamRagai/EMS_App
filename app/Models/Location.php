<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $table ="default_location";
    protected $fillable = [
        'Latitude',
        'Longitude'
    ];
}
