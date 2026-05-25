<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendances extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_session_id',
        'date',
        'status',
        'remarks',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function studentSession()
    {
        return $this->belongsTo(StudentSession::class,'student_session_id');
    }
}
