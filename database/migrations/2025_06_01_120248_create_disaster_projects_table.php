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
        Schema::create('disaster_projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_code', 50)->nullable();
            $table->string('disaster_type', 100)->nullable();
            $table->string('title', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('severity', 50)->nullable();
            $table->string('status', 50)->nullable();
            $table->boolean('is_emergency')->nullable()->default(false);
            $table->unsignedBigInteger('ward_id')->nullable();
            $table->string('location', 255)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->integer('affected_people')->nullable();
            $table->integer('affected_households')->nullable();
            $table->decimal('estimated_cost', 15, 2)->nullable();
            $table->decimal('requested_amount', 15, 2)->nullable();
            $table->decimal('approved_amount', 15, 2)->nullable();
            $table->datetime('occurred_at')->nullable();
            $table->datetime('reported_at')->nullable();
            $table->date('response_deadline')->nullable();
            $table->date('completion_date')->nullable();
            $table->unsignedBigInteger('reported_by_id')->nullable();
            $table->unsignedBigInteger('assigned_officer_id')->nullable();
            $table->text('response_plan')->nullable();
            $table->text('assessment_notes')->nullable();
            $table->timestamps();

            $table->index(['project_code', 'disaster_type']);
            $table->index(['status', 'severity']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disaster_projects');
    }
};
