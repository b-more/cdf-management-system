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
        Schema::create('empowerment_applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_code', 50)->unique();
            $table->enum('application_type', ['grant', 'loan']);
            $table->enum('status', ['submitted', 'wdc_review', 'wdc_approved', 'cdfc_review', 'cdfc_approved', 'rejected', 'active', 'completed'])->default('submitted');

            // Organization Information
            $table->string('organization_name');
            $table->enum('organization_type', ['cooperative', 'club', 'organized_group', 'association']);
            $table->date('registration_date')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('registration_authority')->nullable();

            // Location Information
            $table->unsignedBigInteger('ward_id');
            $table->string('district');
            $table->string('constituency');
            $table->string('zone')->nullable();
            $table->text('business_physical_address');

            // Grant/Loan Details
            $table->string('grant_type')->nullable();
            $table->decimal('requested_amount', 15, 2);
            $table->decimal('approved_amount', 15, 2)->nullable();
            $table->decimal('disbursed_amount', 15, 2)->default(0);

            // Project Information
            $table->boolean('has_similar_experience')->default(false);
            $table->text('experience_details')->nullable();
            $table->text('main_community_problems')->nullable();
            $table->text('target_problem')->nullable();
            $table->text('project_identification_process')->nullable();
            $table->text('community_benefits')->nullable();
            $table->integer('direct_jobs_created')->default(0);

            // Financial History
            $table->boolean('has_previous_loans')->default(false);
            $table->integer('member_count')->default(0);

            // Bank Account Information
            $table->string('bank_name')->nullable();
            $table->string('branch')->nullable();
            $table->string('sort_code')->nullable();
            $table->string('swift_code')->nullable();
            $table->string('account_number')->nullable();
            $table->string('tpin')->nullable();
            $table->string('mobile_wallet_name')->nullable();
            $table->string('mobile_wallet_number')->nullable();

            // Training Information
            $table->boolean('received_entrepreneurship_training')->default(false);
            $table->boolean('received_technical_training')->default(false);
            $table->boolean('received_savings_training')->default(false);
            $table->boolean('received_literacy_training')->default(false);
            $table->boolean('received_financial_literacy_training')->default(false);
            $table->integer('trained_members_count')->default(0);
            $table->text('training_details')->nullable();

            // Contact Information
            $table->string('primary_contact_name');
            $table->text('primary_contact_address');
            $table->string('primary_contact_phone', 20);
            $table->string('primary_contact_nrc', 50);
            $table->string('secondary_contact_name')->nullable();
            $table->text('secondary_contact_address')->nullable();
            $table->string('secondary_contact_phone', 20)->nullable();
            $table->string('secondary_contact_nrc', 50)->nullable();

            // Processing Information
            $table->timestamp('submission_date')->useCurrent();
            $table->text('wdc_remarks')->nullable();
            $table->text('cdfc_remarks')->nullable();
            $table->timestamp('wdc_review_date')->nullable();
            $table->timestamp('cdfc_approval_date')->nullable();
            $table->unsignedBigInteger('processed_by_id')->nullable();
            $table->unsignedBigInteger('approved_by_id')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['application_code', 'application_type']);
            $table->index(['status', 'ward_id']);
            $table->index('organization_type');

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
        Schema::dropIfExists('empowerment_applications');
    }
};
