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
        Schema::create('student_sessions', function (Blueprint $table) {

        $table->id();

        $table->unsignedBigInteger('student_id');

        $table->unsignedBigInteger('class_id');

        $table->unsignedBigInteger('academic_session_id');

        $table->integer('roll_no')->nullable();

    	$table->enum('status', [
        	        'active',
        	        'transferred',
        	        'graduated'
    		        ])->default('active');

    	$table->text('remarks')->nullable();

        $table->timestamps();

        $table->foreign('student_id')
                ->references('id')
                ->on('students')
                ->onDelete('cascade');

        $table->foreign('class_id')
                ->references('id')
                ->on('classes')
                ->onDelete('cascade');

        $table->foreign('academic_session_id')
                ->references('id')
                ->on('academic_sessions')
                ->onDelete('cascade');

        $table->unique(['student_id','academic_session_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_sessions');
    }
};
