<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;

    protected $fillable = [
    'student_session_id',
    'fee_type',
    'month',
    'year',
    'total_amount',
    'due_date',
    'status',
    ];

    public function studentSession()
    {
        return $this->belongsTo(StudentSession::class);
    }

    public function payments()
    {
        return $this->hasMany(FeePayment::class);
    }
}
