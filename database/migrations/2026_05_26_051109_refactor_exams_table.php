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
        Schema::table('exams', function (Blueprint $table) {

            // add session
            $table  ->unsignedBigInteger('academic_session_id')
                    ->after('class_id');

            // foreign key
            $table  ->foreign('academic_session_id')
                    ->references('id')
                    ->on('academic_sessions')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {

            // drop foreign
            $table->dropForeign(['academic_session_id']);

            // drop column
            $table->dropColumn('academic_session_id');

        });
    }
};
