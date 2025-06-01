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
        Schema::create('project_timelines', function (Blueprint $table) {
            $table->id();
            $table->string('milestone_code', 50)->nullable();
            $table->string('title', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('project_type', 255)->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->date('planned_start_date')->nullable();
            $table->date('planned_end_date')->nullable();
            $table->date('actual_start_date')->nullable();
            $table->date('actual_end_date')->nullable();
            $table->integer('planned_duration')->nullable();
            $table->integer('actual_duration')->nullable();
            $table->integer('variance_days')->nullable();
            $table->string('status', 50)->nullable();
            $table->integer('completion_percentage')->nullable();
            $table->string('priority', 50)->nullable();
            $table->string('milestone_type', 100)->nullable();
            $table->boolean('is_critical_path')->nullable()->default(false);
            $table->text('dependencies')->nullable();
            $table->text('required_resources')->nullable();
            $table->text('deliverables')->nullable();
            $table->decimal('budgeted_cost', 15, 2)->nullable();
            $table->decimal('actual_cost', 15, 2)->nullable();
            $table->decimal('cost_variance', 15, 2)->nullable();
            $table->text('notes')->nullable();
            $table->text('risks_issues')->nullable();
            $table->unsignedBigInteger('assigned_to_id')->nullable();
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->timestamps();

            $table->index(['milestone_code', 'project_type']);
            $table->index(['project_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_timelines');
    }
};
