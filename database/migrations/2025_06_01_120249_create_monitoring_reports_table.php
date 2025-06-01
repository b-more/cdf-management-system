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
         Schema::create('monitoring_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_code', 50)->nullable();
            $table->string('report_type', 100)->nullable();
            $table->string('title', 255)->nullable();
            $table->text('executive_summary')->nullable();
            $table->longText('content')->nullable();
            $table->string('reportable_type', 255)->nullable();
            $table->unsignedBigInteger('reportable_id')->nullable();
            $table->unsignedBigInteger('ward_id')->nullable();
            $table->string('contractor_name', 255)->nullable();
            $table->integer('progress_percentage')->nullable();
            $table->integer('physical_progress')->nullable();
            $table->integer('financial_progress')->nullable();
            $table->string('status', 50)->nullable();
            $table->string('overall_rating', 50)->nullable();
            $table->string('quality_rating', 10)->nullable();
            $table->string('safety_rating', 10)->nullable();
            $table->string('environmental_compliance', 50)->nullable();
            $table->string('community_satisfaction', 50)->nullable();
            $table->text('quality_notes')->nullable();
            $table->decimal('budget_allocated', 15, 2)->nullable();
            $table->decimal('amount_spent', 15, 2)->nullable();
            $table->decimal('remaining_budget', 15, 2)->nullable();
            $table->decimal('budget_variance', 15, 2)->nullable();
            $table->string('budget_status', 50)->nullable();
            $table->date('reporting_period_start')->nullable();
            $table->date('reporting_period_end')->nullable();
            $table->date('visit_date')->nullable();
            $table->date('expected_completion')->nullable();
            $table->date('revised_completion')->nullable();
            $table->integer('delay_days')->nullable();
            $table->text('issues_identified')->nullable();
            $table->text('challenges_faced')->nullable();
            $table->string('risk_level', 50)->nullable();
            $table->text('recommendations')->nullable();
            $table->text('next_steps')->nullable();
            $table->text('corrective_actions')->nullable();
            $table->unsignedBigInteger('prepared_by_id')->nullable();
            $table->unsignedBigInteger('reviewed_by_id')->nullable();
            $table->date('submission_deadline')->nullable();
            $table->date('review_deadline')->nullable();
            $table->text('lessons_learned')->nullable();
            $table->text('best_practices')->nullable();
            $table->text('stakeholder_feedback')->nullable();
            $table->timestamps();

            $table->index(['report_code', 'report_type']);
            $table->index(['reportable_type', 'reportable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_reports');
    }
};
