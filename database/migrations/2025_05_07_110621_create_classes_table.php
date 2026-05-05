<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id(); // প্রাইমারি কী
            $table->string('name'); // ক্লাসের নাম (যেমন: "Class One")
            $table->integer('numeric_value'); // ক্লাসের সংখ্যা মান (যেমন: 1, 2, 3...)
            $table->foreignId('class_teacher_id')->nullable()->constrained('teachers')->onDelete('set null'); 
            // যেই শিক্ষক এই ক্লাসের শ্রেণি শিক্ষক, সেটা optional
            // teachers টেবিলের সাথে সম্পর্কিত, ডিলিট হলে null হবে
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
