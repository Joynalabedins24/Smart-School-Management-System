<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSession extends Model
{
    use HasFactory;


    public function Student()
    {
        return $this->belongsTo(Student::class);
    }


    public function class()
    {
        return $this->belongsTo(Classe::class);
    }


    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class);
    }



}
