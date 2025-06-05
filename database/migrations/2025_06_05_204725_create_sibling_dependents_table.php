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
        Schema::create('sibling_dependents', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('educational_bursary_id');
            $table->enum('type', ['sibling', 'dependent']);

            // Basic Information
            $table->string('name');
            $table->enum('sex', ['male', 'female']);
            $table->integer('age');
            $table->string('occupation')->nullable();
            $table->enum('vital_status', ['alive', 'deceased']);

            // Education Information (for siblings)
            $table->boolean('is_in_school')->default(false);
            $table->string('school_name')->nullable();
            $table->string('grade_level')->nullable();
            $table->string('education_supporter')->nullable(); // Who pays for their education

            // Dependency Information
            $table->boolean('is_dependent')->default(false);
            $table->text('dependency_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sibling_dependents');
    }
};
