<?php

namespace App\Models;

use App\Models\Result;
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
    'admission_date',
    'guardian_name',
    'guardian_phone',
    'address',
    'profile_photo',
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
        return $this->belongsTo(Classe::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendances::class);
    }

    public function result()
    {
        return $this->hasMany(Result::class);
    }

    public function studentSessions()
    {
        return $this->hasMany(StudentSession::class);
    }

    public function currentSession()
    {
        return $this->hasOne(StudentSession::class)
                    ->where('academic_session_id', activeSession()->id);
    }

    // Accessor Example: Full student ID with prefix
    //public function getFullStudentIdAttribute()
    //{
    //    return 'STD-' . $this->student_id;
    //}
}
