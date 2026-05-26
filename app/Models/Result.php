<?php

namespace App\Models;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;


    protected $fillable = [
    'student_id',
    'exam_id',
    'subject_id',
    'marks',
    'grade',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function studentSession()
    {
        return $this->belongsTo(StudentSession::class,'student_session_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
