<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_assignment_id',
        'classroom_id',
        'day',
        'start_time',
        'end_time',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time'   => 'datetime:H:i',
    ];

    /**
     * Teacher Assignment
     */
    public function teacherAssignment()
    {
        return $this->belongsTo(
            TeacherAssignment::class,
            'teacher_assignment_id'
        );
    }

    /**
     * Classroom
     */
    public function classroom()
    {
        return $this->belongsTo(
            Classroom::class,
            'classroom_id'
        );
    }
}
