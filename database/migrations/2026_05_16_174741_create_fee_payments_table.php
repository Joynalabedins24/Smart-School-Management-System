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
        Schema::create('fee_payments', function (Blueprint $table) {

        $table->id();

        $table->string('receipt_no')->nullable();

        $table->unsignedBigInteger('fee_id');

        $table->decimal('amount', 10, 2);

        $table->date('payment_date');

        $table->string('payment_method')->nullable();

        $table->string('transaction_id')->nullable();

        $table->unsignedBigInteger('received_by')->nullable();

        $table->text('note')->nullable();

        $table->timestamps();

        $table->foreign('fee_id')
            ->references('id')
            ->on('fees')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_payments');
    }
};
