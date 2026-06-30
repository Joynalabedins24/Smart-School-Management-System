<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_name',
        'department_code',
        'description',
        'status',
    ];

    /**
     * A department has many classrooms.
     */
    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }
}
