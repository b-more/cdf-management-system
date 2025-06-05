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
        Schema::create('committee_members', function (Blueprint $table) {
             $table->id();
            $table->unsignedBigInteger('project_committee_id');

            // Member Information
            $table->string('member_name');
            $table->string('position'); // Chairperson, Secretary, Treasurer, Member
            $table->enum('gender', ['male', 'female']);
            $table->string('nrc_number', 50)->nullable();
            $table->string('contact_phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('signature_path')->nullable(); // Path to signature image

            // Appointment Information
            $table->date('date_appointed');
            $table->boolean('is_active')->default(true);
            $table->date('resignation_date')->nullable();
            $table->text('resignation_reason')->nullable();

            // Skills and Experience
            $table->text('skills_expertise')->nullable();
            $table->text('previous_experience')->nullable();
            $table->enum('availability', ['full_time', 'part_time', 'volunteer'])->default('volunteer');
            $table->enum('commitment_level', ['high', 'medium', 'low'])->default('medium');

            $table->timestamps();

            // Indexes
            $table->index('project_committee_id');
            $table->index(['member_name', 'is_active']);
            $table->index('position');

            // Foreign Keys
            $table->foreign('project_committee_id')->references('id')->on('project_committees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('committee_members');
    }
};
