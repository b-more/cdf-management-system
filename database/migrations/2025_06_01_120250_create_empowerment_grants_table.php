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
        Schema::create('empowerment_grants', function (Blueprint $table) {
            $table->id();
            $table->string('grant_code', 50)->nullable();
            $table->string('grant_type', 100)->nullable();
            $table->string('title', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('status', 50)->nullable();
            $table->string('priority', 50)->nullable();
            $table->boolean('requires_repayment')->nullable()->default(false);
            $table->unsignedBigInteger('beneficiary_id')->nullable();
            $table->unsignedBigInteger('ward_id')->nullable();
            $table->integer('beneficiary_age')->nullable();
            $table->string('beneficiary_gender', 20)->nullable();
            $table->decimal('requested_amount', 15, 2)->nullable();
            $table->decimal('approved_amount', 15, 2)->nullable();
            $table->decimal('disbursed_amount', 15, 2)->nullable();
            $table->decimal('interest_rate', 5, 2)->nullable();
            $table->integer('repayment_period')->nullable();
            $table->decimal('total_repayment', 15, 2)->nullable();
            $table->date('application_date')->nullable();
            $table->date('approval_date')->nullable();
            $table->date('disbursement_date')->nullable();
            $table->date('repayment_start_date')->nullable();
            $table->unsignedBigInteger('processed_by_id')->nullable();
            $table->unsignedBigInteger('approved_by_id')->nullable();
            $table->text('assessment_notes')->nullable();
            $table->text('conditions')->nullable();
            $table->timestamps();

            $table->index(['grant_code', 'grant_type']);
            $table->index(['status', 'beneficiary_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empowerment_grants');
    }
};
