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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->string('document_type', 100)->nullable();
            $table->text('description')->nullable();
            $table->string('file_path', 500)->nullable();
            $table->string('documentable_type', 255)->nullable();
            $table->unsignedBigInteger('documentable_id')->nullable();
            $table->bigInteger('file_size')->nullable();
            $table->string('mime_type', 100)->nullable();
            $table->string('version', 10)->nullable();
            $table->boolean('is_public')->nullable()->default(false);
            $table->boolean('is_active')->nullable()->default(true);
            $table->datetime('expires_at')->nullable();
            $table->string('access_level', 50)->nullable();
            $table->text('access_notes')->nullable();
            $table->unsignedBigInteger('uploaded_by_id')->nullable();
            $table->unsignedBigInteger('approved_by_id')->nullable();
            $table->text('tags')->nullable();
             $table->enum('document_category', [
                // Educational Bursaries
                'BIRTH_CERTIFICATE',
                'DEATH_CERTIFICATE',
                'DISABILITY_CARD',
                'MEDICAL_RECORDS',
                'RECOMMENDATION_LETTER_TRADITIONAL',
                'RECOMMENDATION_LETTER_RELIGIOUS',
                'RECOMMENDATION_LETTER_SCHOOL',
                'RECOMMENDATION_LETTER_CWAC',
                'SCHOOL_ACCEPTANCE_LETTER',
                'EDUCATIONAL_CERTIFICATES',
                'INCOME_PROOF',
                'PAY_SLIPS',

                // Community Projects
                'LAND_TITLE',
                'MEETING_MINUTES_ZONAL',
                'MEETING_MINUTES_WDC',
                'TECHNICAL_DRAWINGS',
                'BILL_OF_QUANTITIES',
                'ENVIRONMENTAL_IMPACT',
                'COMMUNITY_AGREEMENT',

                // Empowerment
                'ORGANIZATION_CERTIFICATE',
                'CONSTITUTION_BYLAWS',
                'BANK_STATEMENT',
                'BUSINESS_PROPOSAL',
                'LOAN_AGREEMENT',
                'GRANT_AGREEMENT',
                'NRC_COPY',
                'RECOMMENDATION_LETTER_CIVIC',
                'RECOMMENDATION_LETTER_BANK',

                // General
                'OTHER'
            ])->nullable();

            // Add verification status
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->unsignedBigInteger('verified_by_id')->nullable();

            // Add document priority for processing
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');

            // Add expiry tracking
            $table->boolean('has_expiry')->default(false);
            $table->date('document_expiry_date')->nullable();

            // Add compliance status
            $table->enum('compliance_status', ['pending', 'compliant', 'non_compliant', 'requires_update'])->default('pending');
            $table->text('compliance_notes')->nullable();

            // Foreign key for verification
            $table->foreign('verified_by_id')->references('id')->on('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['documentable_type', 'documentable_id']);
            $table->index('document_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
