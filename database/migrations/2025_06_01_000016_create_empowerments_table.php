<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empowerments', function (Blueprint $table) {
            $table->id();
            $table->string('program_code', 50)->nullable();
            $table->string('title', 255)->nullable();
            $table->longText('description')->nullable();
            $table->string('program_type', 100)->nullable();
            $table->string('target_group', 100)->nullable();
            $table->string('status', 50)->nullable();
            $table->unsignedBigInteger('ward_id')->nullable();
            $table->string('venue', 255)->nullable();
            $table->integer('target_participants')->nullable();
            $table->integer('registered_participants')->nullable();
            $table->integer('completed_participants')->nullable();
            $table->longText('objectives')->nullable();
            $table->longText('curriculum')->nullable();
            $table->integer('duration_hours')->nullable();
            $table->integer('duration_days')->nullable();
            $table->text('prerequisites')->nullable();
            $table->text('required_materials')->nullable();
            $table->text('equipment_needed')->nullable();
            $table->text('facilitators')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->time('session_time')->nullable();
            $table->date('registration_deadline')->nullable();
            $table->string('frequency', 50)->nullable();
            $table->decimal('total_budget', 15, 2)->nullable();
            $table->decimal('allocated_budget', 15, 2)->nullable();
            $table->decimal('spent_amount', 15, 2)->nullable();
            $table->decimal('cost_per_participant', 15, 2)->nullable();
            $table->string('funding_source', 100)->nullable();
            $table->longText('expected_outcomes')->nullable();
            $table->text('success_indicators')->nullable();
            $table->decimal('completion_rate_target', 5, 2)->nullable();
            $table->decimal('satisfaction_target', 5, 2)->nullable();
            $table->unsignedBigInteger('coordinator_id')->nullable();
            $table->unsignedBigInteger('approved_by_id')->nullable();
            $table->text('implementation_notes')->nullable();
            $table->text('evaluation_notes')->nullable();
            $table->timestamps();

            $table->index(['program_code', 'program_type']);
            $table->index(['status', 'ward_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empowerments');
    }
};
