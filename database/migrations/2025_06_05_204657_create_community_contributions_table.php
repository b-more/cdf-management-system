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
        Schema::create('community_contributions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('community_project_id');

            // Contribution Details
            $table->enum('contribution_type', [
                'labor', 'materials', 'maintenance_fees', 'water_supply',
                'cash_contribution', 'equipment', 'land', 'transport', 'other'
            ]);
            $table->text('description');
            $table->decimal('estimated_value', 15, 2)->default(0);
            $table->decimal('actual_value', 15, 2)->default(0);
            $table->decimal('quantity', 10, 2)->default(0);
            $table->string('unit_of_measure')->nullable(); // hours, bags, meters, etc.

            // Contributor Information
            $table->enum('contributor_type', ['individual', 'group', 'organization', 'community'])->default('community');
            $table->string('contributor_name')->nullable();
            $table->date('contribution_date')->nullable();

            // Status Tracking
            $table->boolean('is_completed')->default(false);
            $table->date('completion_date')->nullable();
            $table->enum('verification_status', ['pending', 'verified', 'rejected', 'partial'])->default('pending');
            $table->string('verified_by')->nullable();
            $table->date('verification_date')->nullable();
            $table->text('verification_notes')->nullable();

            // Documentation
            $table->string('receipt_number')->nullable();
            $table->string('documentation_path')->nullable(); // Path to supporting documents

            $table->timestamps();

            // Indexes
            // $table->index('community_project_id');
            // $table->index(['contribution_type', 'verification_status']);
            // $table->index('contribution_date');

            // Foreign Keys
            $table->foreign('community_project_id')->references('id')->on('community_projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_contributions');
    }
};
