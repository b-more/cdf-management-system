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
        Schema::create('budget_lines', function (Blueprint $table) {
            $table->id();
            $table->string('budget_code', 50)->nullable();
            $table->string('line_item', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('category', 100)->nullable();
            $table->string('priority', 50)->nullable();
            $table->string('status', 50)->nullable();
            $table->unsignedBigInteger('fund_allocation_id')->nullable();
            $table->string('budgetable_type', 255)->nullable();
            $table->unsignedBigInteger('budgetable_id')->nullable();
            $table->decimal('budgeted_amount', 15, 2)->nullable();
            $table->decimal('allocated_amount', 15, 2)->nullable();
            $table->decimal('spent_amount', 15, 2)->nullable();
            $table->decimal('committed_amount', 15, 2)->nullable();
            $table->decimal('available_amount', 15, 2)->nullable();
            $table->decimal('variance_amount', 15, 2)->nullable();
            $table->decimal('unit_cost', 15, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('budget_percentage', 5, 2)->nullable();
            $table->decimal('utilization_rate', 5, 2)->nullable();
            $table->string('variance_type', 50)->nullable();
            $table->date('budget_period_start')->nullable();
            $table->date('budget_period_end')->nullable();
            $table->date('approval_date')->nullable();
            $table->date('first_expenditure_date')->nullable();
            $table->date('last_expenditure_date')->nullable();
            $table->unsignedBigInteger('prepared_by_id')->nullable();
            $table->unsignedBigInteger('approved_by_id')->nullable();
            $table->text('approval_notes')->nullable();
            $table->text('revision_notes')->nullable();
            $table->timestamps();

            $table->index(['budget_code', 'category']);
            $table->index(['budgetable_type', 'budgetable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_lines');
    }
};
