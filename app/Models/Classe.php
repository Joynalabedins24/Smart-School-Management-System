<?php

namespace App\Models;

use App\Models\Exam;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;


    protected $table = 'classes';

    protected $fillable = [
        'name',
        'numeric_value',
        'class_teacher_id',
    ];


    public function classTeacher()
    {
        return $this->belongsTo(Teacher::class, 'class_teacher_id');
    }
    public function sections()
    {
        return $this->hasMany(Section::class);
    }
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }


}
