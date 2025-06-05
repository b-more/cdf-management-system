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
        Schema::create('project_problem_analyses', function (Blueprint $table) {
             $table->id();
            $table->unsignedBigInteger('community_project_id');

            // Problem Analysis
            $table->text('main_problems')->nullable();
            $table->text('priority_ranking')->nullable();
            $table->text('target_problem')->nullable();
            $table->text('proposed_solution')->nullable();
            $table->text('alternative_solutions')->nullable();

            // Previous Attempts
            $table->text('previous_attempts')->nullable();
            $table->boolean('previous_attempts_success')->default(false);
            $table->text('previous_attempts_details')->nullable();

            // Analysis Framework
            $table->text('root_cause_analysis')->nullable();
            $table->text('stakeholder_analysis')->nullable();
            $table->text('risk_assessment')->nullable();
            $table->text('mitigation_strategies')->nullable();
            $table->text('success_indicators')->nullable();
            $table->text('monitoring_plan')->nullable();

            // Community Consultation
            $table->text('community_consultation_process')->nullable();
            $table->date('consultation_date')->nullable();
            $table->integer('consultation_participants')->default(0);
            $table->text('consultation_outcomes')->nullable();
            $table->string('consensus_level')->nullable();
            $table->text('dissenting_opinions')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('community_project_id');
            $table->index('consultation_date');

            // Foreign Keys
            $table->foreign('community_project_id')->references('id')->on('community_projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_problem_analyses');
    }
};
