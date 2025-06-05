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
        Schema::create('educational_bursaries', function (Blueprint $table) {
            $table->id();
             $table->string('bursary_code', 50)->unique();
            $table->enum('bursary_type', ['skills_development', 'secondary_boarding']);
            $table->enum('status', ['submitted', 'wdc_review', 'wdc_approved', 'cdfc_review', 'cdfc_approved', 'rejected', 'completed'])->default('submitted');

            // Applicant Personal Information
            $table->string('applicant_surname');
            $table->string('applicant_other_names');
            $table->enum('gender', ['male', 'female']);
            $table->string('nationality')->default('Zambian');
            $table->string('nrc_number', 50)->nullable();
            $table->date('date_of_birth');
            $table->string('place_of_birth')->nullable();

            // Location Information
            $table->unsignedBigInteger('ward_id');
            $table->string('district');
            $table->string('constituency');
            $table->string('zone')->nullable();
            $table->text('postal_address')->nullable();
            $table->string('mobile_phone', 20);
            $table->string('email')->nullable();

            // Vulnerability Status
            $table->enum('orphan_status', ['single_orphan', 'double_orphan', 'not_orphan', 'other'])->nullable();
            $table->boolean('is_disabled')->default(false);
            $table->text('disability_nature')->nullable();
            $table->text('financial_challenges')->nullable();

            // School/Course Details
            $table->boolean('is_school_leaver')->default(true);
            $table->string('last_grade_attended')->nullable();
            $table->string('last_school_attended')->nullable();
            $table->string('last_school_district')->nullable();
            $table->date('school_from_date')->nullable();
            $table->date('school_to_date')->nullable();
            $table->string('highest_certificate')->nullable();

            // Course/Institution Details
            $table->boolean('has_acceptance_letter')->default(false);
            $table->string('institution_name')->nullable();
            $table->string('programme_of_study')->nullable();
            $table->string('programme_duration')->nullable();

            // Previous Support
            $table->boolean('received_previous_scholarship')->default(false);
            $table->text('previous_scholarship_details')->nullable();
            $table->boolean('received_previous_cdf_bursary')->default(false);
            $table->text('previous_cdf_details')->nullable();

            // Processing Information
            $table->timestamp('submission_date')->useCurrent();
            $table->text('wdc_remarks')->nullable();
            $table->text('cdfc_remarks')->nullable();
            $table->timestamp('wdc_review_date')->nullable();
            $table->timestamp('cdfc_approval_date')->nullable();
            $table->unsignedBigInteger('processed_by_id')->nullable();
            $table->unsignedBigInteger('approved_by_id')->nullable();
            $table->timestamps();

            $table->index(['bursary_code', 'bursary_type']);
            $table->index(['status', 'ward_id']);
            $table->index('mobile_phone');

            // Foreign Keys
            $table->foreign('ward_id')->references('id')->on('wards');
            $table->foreign('processed_by_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('approved_by_id')->references('id')->on('users')->nullOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educational_bursaries');
    }
};
