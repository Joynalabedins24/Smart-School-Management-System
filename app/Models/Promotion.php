<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'from_session_id',
        'to_session_id',
        'from_class_id',
        'to_class_id',
        'action',
        'remarks',
    ];
}
