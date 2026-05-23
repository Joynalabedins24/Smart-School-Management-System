<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSession extends Model
{
    use HasFactory;

    protected $fillable = [
    'student_id',
    'class_id',
    'section_id',
    'academic_session_id'

    ];

    public function Student()
    {
        return $this->belongsTo(Student::class);
    }


    public function class()
    {
        return $this->belongsTo(Classe::class, 'class_id');
    }


    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class,'academic_session_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }


}
