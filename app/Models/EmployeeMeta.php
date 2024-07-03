<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeMeta extends Model
{
    use HasFactory;
    protected $table ="employee_meta";
    protected $fillable = [
        'user_id',
        'meta_field',
        'meta_value'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
