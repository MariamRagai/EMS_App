<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = "department_list";

    protected $fillable = [
        'id',
        'name',
        'description',
        'date_created',
        'date_updated',
    ];

    /**
     * Get the users that belong to the department.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
