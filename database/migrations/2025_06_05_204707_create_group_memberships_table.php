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
        Schema::create('group_memberships', function (Blueprint $table) {
             $table->id();
            $table->unsignedBigInteger('empowerment_application_id');

            // Member Information
            $table->string('member_name');
            $table->string('position'); // Chairperson, Secretary, Treasurer, Member, etc.
            $table->enum('gender', ['male', 'female']);
            $table->string('nrc_number', 50);
            $table->string('phone_number', 20)->nullable();
            $table->string('signature_path')->nullable(); // Path to signature image/document

            // Membership Details
            $table->boolean('is_signatory')->default(false); // One of the 5 signatories for declaration
            $table->date('date_joined')->nullable();
            $table->boolean('is_active')->default(true);
            $table->date('exit_date')->nullable();
            $table->text('exit_reason')->nullable();

            // Additional Information
            $table->text('skills_contribution')->nullable(); // What skills they bring to the group
            $table->text('responsibilities')->nullable(); // Their specific responsibilities
            $table->enum('membership_type', ['founding_member', 'regular_member', 'associate_member'])->default('regular_member');
            $table->decimal('membership_fee_paid', 10, 2)->default(0);
            $table->date('last_fee_payment_date')->nullable();

            // Contact Information
            $table->text('residential_address')->nullable();
            $table->string('email')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone', 20)->nullable();

            // Training and Experience
            $table->boolean('has_business_training')->default(false);
            $table->text('training_details')->nullable();
            $table->text('previous_group_experience')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('empowerment_application_id');
            $table->index(['member_name', 'is_active']);
            $table->index('is_signatory');
            $table->index('position');

            // Foreign Keys
            $table->foreign('empowerment_application_id')->references('id')->on('empowerment_applications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_memberships');
    }
};
