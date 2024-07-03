<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory , Notifiable;
    protected $table ="users";
    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'username',
        'password',
    ];
     public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }
}
