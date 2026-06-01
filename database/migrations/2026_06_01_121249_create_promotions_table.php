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
        Schema::create('promotions', function (Blueprint $table) {

        $table->id();
        $table  ->foreignId('student_id')
                ->constrained()
                ->onDelete('cascade');

        $table->foreignId('from_session_id')
                ->constrained('academic_sessions')
                ->onDelete('cascade');

        $table->foreignId('to_session_id')
              ->constrained('academic_sessions')
              ->onDelete('cascade');

        $table->foreignId('from_class_id')
              ->constrained('classes')
              ->onDelete('cascade');

        $table->foreignId('to_class_id')
              ->constrained('classes')
              ->onDelete('cascade');

        $table->enum('action',[
                    'promote',
                    'repeat',
                    'hold'
                    ]);

        $table->text('remarks')->nullable();

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
