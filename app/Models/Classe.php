<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;

class Classe extends Model
{
    use HasFactory;


    protected $table = 'classes'; // টেবিলের নাম স্পষ্টভাবে উল্লেখ করা হলো

    protected $fillable = [
        'name',
        'numeric_value',
        'class_teacher_id',
    ];

    // শ্রেণি শিক্ষকের রিলেশন (একজন শিক্ষক এই ক্লাসের দায়িত্বে)
    public function classTeacher()
    {
        return $this->belongsTo(Teacher::class, 'class_teacher_id');
    }
    public function sections() 
    { 
        return $this->hasMany(Section::class); 
    } 

    // ভবিষ্যতে যদি এই ক্লাসের স্টুডেন্ট বা সেকশন যুক্ত করতে চাও, তাহলে রিলেশন আরও যোগ করা যাবে
}
