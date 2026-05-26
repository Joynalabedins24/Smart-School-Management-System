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
        Schema::table('results', function (Blueprint $table) {

            // remove old foreign
            $table->dropForeign([
                'student_id'
            ]);

            // remove old column
            $table->dropColumn(
                'student_id'
            );

            // add new column
            $table->unsignedBigInteger(
                'student_session_id'
            )->after('id');

            // foreign key
            $table->foreign(
                'student_session_id'
            )->references('id')
             ->on('student_sessions')
             ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('results', function (Blueprint $table) {

            // remove foreign
            $table->dropForeign([
                'student_session_id'
            ]);

            // remove column
            $table->dropColumn(
                'student_session_id'
            );

            // restore old column
            $table->unsignedBigInteger(
                'student_id'
            );

            // restore foreign
            $table->foreign(
                'student_id'
            )->references('id')
             ->on('students')
             ->onDelete('cascade');

        });
    }
};
