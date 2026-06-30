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
        Schema::create('classrooms', function (Blueprint $table) {

            $table->id();

            $table->foreignId('building_id')->nullable()->constrained()->nullOnDelete();

            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();

            $table->string('room_no')->unique();

            $table->string('room_name');

            $table->enum('room_type', ['theory', 'lab', 'auditorium', 'conference']);

            $table->integer('capacity');

            $table->integer('floor_no')->nullable();

            $table->float('room_length')->nullable();

            $table->float('room_width')->nullable();

            $table->string('thumbnail')->nullable();

            $table->string('vr_model_path')->nullable();

            $table->text('description')->nullable();

            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
