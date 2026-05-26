<?php

namespace App\Models;

use App\Models\Classe;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'class_id',
    ];

    protected $casts = [
    'start_date' => 'date',
    'end_date' => 'date',
    ];

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'class_id');
    }

    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class,'academic_session_id');
    }

}
