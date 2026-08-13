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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            // Teacher + Class + Section + Subject + Session
            $table->foreignId('teacher_assignment_id')
                ->constrained('teacher_assignments')
                ->cascadeOnDelete();
            // Classroom
            $table->foreignId('classroom_id')
                ->constrained('classrooms')
                ->cascadeOnDelete();
            // Schedule Day
            $table->enum('day', [
                'Saturday',
                'Sunday',
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday'
                ]);
            // Class Time
            $table->time('start_time');
            $table->time('end_time');
            // Schedule Status
            $table->enum('status', [
                'active',
                'inactive'
                ])->default('active');
            $table->timestamps();
            // Faster filtering
            $table->index([
                'classroom_id',
                'day',
                'start_time'
                ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
