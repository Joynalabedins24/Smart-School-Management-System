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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            // ইউজার টেবিলের সাথে যুক্ত, ইউজার ডিলিট হলে শিক্ষক ডেটাও ডিলিট হবে

            $table->string('employee_id')->unique(); 
            // প্রতিটি শিক্ষককে ইউনিক আইডি

            $table->string('qualification')->nullable(); 
            // শিক্ষাগত যোগ্যতা, খালি রাখা যাবে

            $table->string('subject_specialization')->nullable(); 
            // কোন বিষয়ে দক্ষতা, খালি রাখা যাবে

            $table->date('hire_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
