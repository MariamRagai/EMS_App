<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;
    protected $table = "leave_applications";
    protected $fillable = [
         'id',
         'user_id',
         'leave_type_id',
         'date_start',
         'date_end',
         'reason',

    ];
    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }

}
