<?php

namespace App\Models;

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
        return $this->belongsTo(Classe::class);
    }

}
