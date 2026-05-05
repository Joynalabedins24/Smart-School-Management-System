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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            // কোন ক্লাসের অধীনে এই সেকশন, ক্লাস ডিলিট হলে সেকশনও ডিলিট হবে
            $table->string('name'); // শাখার নাম, যেমন: A, B, C
            $table->integer('capacity')->default(0); // আসন সংখ্যা বা ধারণ ক্ষমতা
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
