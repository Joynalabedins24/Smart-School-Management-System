<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'class_id',
        'teacher_id',
    ];


    // Relationships (optional)
    public function class()
    {
        return $this->belongsTo(Classe::class); // Update ClassModel if your model name is different
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
