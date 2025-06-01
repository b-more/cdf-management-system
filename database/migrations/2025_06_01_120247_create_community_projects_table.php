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
        Schema::create('community_projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_code', 50)->nullable();
            $table->string('title', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('category', 100)->nullable();
            $table->string('priority', 50)->nullable();
            $table->string('status', 50)->nullable();
            $table->unsignedBigInteger('ward_id')->nullable();
            $table->string('location', 255)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->integer('beneficiaries_count')->nullable();
            $table->integer('households_count')->nullable();
            $table->decimal('estimated_cost', 15, 2)->nullable();
            $table->decimal('requested_amount', 15, 2)->nullable();
            $table->decimal('approved_amount', 15, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('wdc_review_date')->nullable();
            $table->date('cdfc_approval_date')->nullable();
            $table->unsignedBigInteger('applicant_id')->nullable();
            $table->unsignedBigInteger('assigned_officer_id')->nullable();
            $table->text('wdc_remarks')->nullable();
            $table->text('cdfc_remarks')->nullable();
            $table->timestamps();

            $table->index(['project_code', 'status']);
            $table->index(['ward_id', 'category']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_projects');
    }
};
