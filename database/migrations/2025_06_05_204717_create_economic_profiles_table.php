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
        Schema::create('economic_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vulnerability_assessment_id');

            // Household Composition
            $table->integer('household_size')->default(1);
            $table->integer('adults_count')->default(1);
            $table->integer('children_count')->default(0);
            $table->integer('elderly_count')->default(0);
            $table->integer('disabled_members_count')->default(0);
            $table->decimal('dependency_ratio', 5, 2)->default(0);

            // Income Information
            $table->string('primary_income_source')->nullable();
            $table->string('secondary_income_source')->nullable();
            $table->decimal('estimated_monthly_income', 10, 2)->default(0);
            $table->boolean('income_is_regular')->default(false);
            $table->enum('income_reliability', ['very_reliable', 'reliable', 'unreliable', 'very_unreliable'])->default('unreliable');

            // Expenditure Information
            $table->decimal('estimated_monthly_expenditure', 10, 2)->default(0);
            $table->decimal('food_expenditure', 10, 2)->default(0);
            $table->decimal('education_expenditure', 10, 2)->default(0);
            $table->decimal('health_expenditure', 10, 2)->default(0);
            $table->decimal('housing_expenditure', 10, 2)->default(0);

            // Financial Stress Indicators
            $table->boolean('has_savings')->default(false);
            $table->decimal('savings_amount', 10, 2)->default(0);
            $table->boolean('has_debt')->default(false);
            $table->decimal('debt_amount', 10, 2)->default(0);
            $table->boolean('can_afford_emergency_expense')->default(false);
            $table->decimal('emergency_expense_threshold', 10, 2)->default(500);

            // Social Support
            $table->boolean('receives_social_support')->default(false);
            $table->text('social_support_details')->nullable();
            $table->boolean('receives_remittances')->default(false);
            $table->decimal('monthly_remittances', 10, 2)->default(0);

            $table->timestamps();

            // Indexes
            $table->index('vulnerability_assessment_id');
            $table->index('estimated_monthly_income');
            $table->index(['household_size', 'dependency_ratio']);

            // Foreign Keys
            $table->foreign('vulnerability_assessment_id')->references('id')->on('vulnerability_assessments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('economic_profiles');
    }
};
