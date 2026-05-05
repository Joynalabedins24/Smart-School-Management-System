<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    // যদি চাই কোন কোন ফিল্ড mass assign করা যাবে
    protected $fillable = [
        'user_id',
        'employee_id',
        'qualification',
        'subject_specialization',
        'hire_date',
    ];
    // যদি user এর সাথে relation থাকে
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
