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
        Schema::create('previous_loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empowerment_application_id');

            // Loan Details
            $table->string('organization_name');
            $table->decimal('loan_amount', 15, 2);
            $table->string('loan_currency', 3)->default('ZMW');
            $table->date('loan_date');
            $table->string('loan_purpose')->nullable();
            $table->enum('loan_status', ['active', 'completed', 'defaulted', 'written_off'])->default('active');
            $table->enum('repayment_status', ['current', 'late', 'partially_paid', 'fully_paid', 'defaulted'])->default('current');
            $table->decimal('outstanding_amount', 15, 2)->default(0);

            // Loan Terms
            $table->integer('repayment_period_months')->nullable();
            $table->decimal('interest_rate', 5, 2)->nullable();
            $table->string('collateral_provided')->nullable();
            $table->text('collateral_details')->nullable();
            $table->integer('guarantors_count')->default(0);

            // Reference Information
            $table->string('loan_reference_number')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_phone', 20)->nullable();
            $table->text('remarks')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('empowerment_application_id');
            $table->index(['loan_status', 'repayment_status']);

            // Foreign Keys
            $table->foreign('empowerment_application_id')->references('id')->on('empowerment_applications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('previous_loans');
    }
};
