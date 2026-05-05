<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_id',
        'dob',
        'gender',
        'class_id',
        'section_id',
        'admission_date',
        'guardian_name',
    ];

    protected $casts = [
        'dob' => 'date',
        'admission_date' => 'date',
    ];


    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function class()
    {
        return $this->belongsTo(Classe::class, 'class_id'); // Assuming model name is SchoolClass
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendances::class);
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    // Accessor Example: Full student ID with prefix
    //public function getFullStudentIdAttribute()
    //{
    //    return 'STD-' . $this->student_id;
    //}

}
