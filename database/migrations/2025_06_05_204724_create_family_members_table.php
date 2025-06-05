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
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('educational_bursary_id');
            $table->enum('relationship', ['father', 'mother', 'guardian']);
            $table->enum('vital_status', ['alive', 'deceased']);

            // Personal Information
            $table->string('surname');
            $table->string('first_name');
            $table->string('other_names')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->date('date_of_birth')->nullable();
            $table->string('nationality')->default('Zambian');
            $table->string('nrc_number', 50)->nullable();
            $table->string('relationship_to_applicant');

            // Location Information
            $table->string('village')->nullable();
            $table->string('chief')->nullable();
            $table->string('district')->nullable();
            $table->text('residential_address')->nullable();
            $table->string('constituency')->nullable();
            $table->string('province')->nullable();
            $table->text('postal_address')->nullable();
            $table->string('mobile_phone', 20)->nullable();
            $table->string('email')->nullable();

            // Employment Details
            $table->string('occupation')->nullable();
            $table->string('employer_name')->nullable();
            $table->string('position_rank')->nullable();
            $table->text('employer_address')->nullable();

            // Health Information
            $table->boolean('has_disability')->default(false);
            $table->text('disability_nature')->nullable();
            $table->boolean('has_medical_condition')->default(false);
            $table->text('medical_condition_details')->nullable();
            $table->timestamps();

            $table->index(['educational_bursary_id', 'relationship']);
            $table->index('vital_status');

            // Foreign Keys
            $table->foreign('educational_bursary_id')->references('id')->on('educational_bursaries')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};
