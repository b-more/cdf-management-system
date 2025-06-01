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
        Schema::create('grant_repayments', function (Blueprint $table) {
            $table->id();
            $table->string('repayment_code', 50)->nullable();
            $table->unsignedBigInteger('empowerment_grant_id')->nullable();
            $table->text('description')->nullable();
            $table->decimal('scheduled_amount', 15, 2)->nullable();
            $table->decimal('paid_amount', 15, 2)->nullable();
            $table->decimal('outstanding_amount', 15, 2)->nullable();
            $table->decimal('penalty_amount', 15, 2)->nullable();
            $table->decimal('interest_amount', 15, 2)->nullable();
            $table->decimal('total_due', 15, 2)->nullable();
            $table->date('due_date')->nullable();
            $table->date('paid_date')->nullable();
            $table->integer('installment_number')->nullable();
            $table->string('status', 50)->nullable();
            $table->string('payment_method', 50)->nullable();
            $table->string('transaction_reference', 100)->nullable();
            $table->string('receipt_number', 100)->nullable();
            $table->text('payment_notes')->nullable();
            $table->integer('grace_period_days')->nullable();
            $table->date('extended_due_date')->nullable();
            $table->decimal('penalty_rate', 5, 2)->nullable();
            $table->text('extension_reason')->nullable();
            $table->unsignedBigInteger('recorded_by_id')->nullable();
            $table->unsignedBigInteger('approved_by_id')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->index(['repayment_code', 'empowerment_grant_id']);
            $table->index(['status', 'due_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grant_repayments');
    }
};
