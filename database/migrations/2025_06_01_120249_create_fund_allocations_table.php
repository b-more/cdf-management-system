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
        Schema::create('fund_allocations', function (Blueprint $table) {
            $table->id();
            $table->string('allocation_code', 50)->nullable();
            $table->string('financial_year', 4)->nullable();
            $table->string('title', 255)->nullable();
            $table->text('description')->nullable();
            $table->decimal('total_amount', 15, 2)->nullable();
            $table->decimal('allocated_amount', 15, 2)->nullable();
            $table->decimal('disbursed_amount', 15, 2)->nullable();
            $table->string('fund_type', 50)->nullable();
            $table->string('status', 50)->nullable();
            $table->unsignedBigInteger('ward_id')->nullable();
            $table->date('allocation_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedBigInteger('allocated_by_id')->nullable();
            $table->unsignedBigInteger('approved_by_id')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->index(['allocation_code', 'financial_year']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fund_allocations');
    }
};
