<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_name',
        'building_code',
        'total_floors',
        'description',
        'status',
    ];

    /**
     * A building has many classrooms.
     */
    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }
}
