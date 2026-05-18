<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;

    protected $fillable = [
    'student_id',
    'fee_type',
    'month',
    'year',
    'total_amount',
    'due_date',
    'status',
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function payments()
    {
        return $this->hasMany(FeePayment::class);
    }
}
