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
        Schema::create('project_sustainability_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('community_project_id');

            // Sustainability Strategy
            $table->text('sustainability_strategy')->nullable();
            $table->text('maintenance_plan')->nullable();
            $table->text('maintenance_schedule')->nullable();
            $table->string('maintenance_responsibility')->nullable();
            $table->decimal('maintenance_budget', 15, 2)->default(0);
            $table->text('funding_sources')->nullable();

            // Community Ownership
            $table->text('community_ownership_plan')->nullable();
            $table->text('capacity_building_needs')->nullable();
            $table->text('training_requirements')->nullable();
            $table->text('technical_support_needs')->nullable();

            // Institutional Arrangements
            $table->text('institutional_arrangements')->nullable();
            $table->text('governance_structure')->nullable();
            $table->text('monitoring_arrangements')->nullable();
            $table->text('evaluation_framework')->nullable();

            // Risk Management
            $table->text('risk_mitigation_plan')->nullable();
            $table->text('contingency_plans')->nullable();
            $table->text('sustainability_indicators')->nullable();
            $table->string('review_schedule')->nullable();
            $table->text('reporting_mechanism')->nullable();

            // Community Commitment
            $table->text('community_commitment')->nullable();
            $table->text('stakeholder_roles')->nullable();
            $table->text('resource_mobilization_plan')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('community_project_id');

            // Foreign Keys
            $table->foreign('community_project_id')->references('id')->on('community_projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_sustainability_plans');
    }
};
