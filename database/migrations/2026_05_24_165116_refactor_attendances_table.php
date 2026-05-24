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
        Schema::table('attendances', function (Blueprint $table) {

            // Remove old foreign
            $table->dropForeign(['student_id']);

            // Remove old column
            $table->dropColumn('student_id');

            // Add new column
            $table->unsignedBigInteger('student_session_id')->after('id');

            // Foreign Key
            $table  ->foreign('student_session_id')
                    ->references('id')
                    ->on('student_sessions')
                    ->onDelete('cascade');

            // Add late status
            $table  ->enum('status', ['present','absent','late'])
                    ->change();

            // Unique attendance
            $table->unique(['student_session_id','date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {

            $table->dropForeign(['student_session_id']);

            $table->dropUnique(['student_session_id','date']);

            $table->dropColumn('student_session_id');

            $table->unsignedBigInteger('student_id');

            $table  ->foreign('student_id')
                    ->references('id')
                    ->on('students')
                    ->onDelete('cascade');
        });
    }
};
