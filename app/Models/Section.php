<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'name',
        'capacity',
    ];

    // প্রতিটি section একটি class এর অন্তর্গত
    public function class()
    {
        return $this->belongsTo(Classe::class, 'class_id');
    }
}
