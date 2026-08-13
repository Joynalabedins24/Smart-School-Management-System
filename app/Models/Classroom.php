<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_id',
        'department_id',
        'room_no',
        'room_name',
        'room_type',
        'capacity',
        'room_width',
        'room_length',
        'floor_no',
        'thumbnail',
        'vr_model_path',
        'description',
        'status'
    ];


    public function building()
    {
        return $this->belongsTo(Building::class);
    }


    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class,'classroom_id');
    }
}
