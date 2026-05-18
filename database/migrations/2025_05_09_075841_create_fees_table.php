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
            Schema::create('fees', function (Blueprint $table) {

            $table->id();

            $table->foreignId('student_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->string('fee_type');

            $table->string('month')->nullable();

            $table->year('year');

            $table->decimal('total_amount', 10, 2);

            $table->date('due_date');

            $table->decimal('late_fee', 10, 2);

            $table->enum('status', [
                    'paid',
                    'partial',
                    'unpaid'
                ])->default('unpaid');

            $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};
