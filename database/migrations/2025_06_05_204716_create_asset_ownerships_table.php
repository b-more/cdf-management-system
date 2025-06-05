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
        Schema::create('asset_ownerships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vulnerability_assessment_id');

            // Durable Goods
            $table->boolean('has_tractor')->default(false);
            $table->boolean('has_plough')->default(false);
            $table->boolean('has_hammer_mill')->default(false);
            $table->boolean('has_car_truck')->default(false);
            $table->text('other_durable_goods')->nullable();

            // Livestock
            $table->integer('cattle_count')->default(0);
            $table->integer('goats_count')->default(0);
            $table->integer('sheep_count')->default(0);
            $table->integer('pigs_count')->default(0);
            $table->integer('poultry_count')->default(0);
            $table->text('other_livestock')->nullable();

            // Electronic Devices
            $table->boolean('has_radio')->default(false);
            $table->boolean('has_television')->default(false);
            $table->boolean('has_mobile_phone')->default(false);
            $table->boolean('has_computer')->default(false);
            $table->boolean('has_refrigerator')->default(false);

            // Agricultural Equipment
            $table->boolean('has_generator')->default(false);
            $table->boolean('has_water_pump')->default(false);
            $table->boolean('has_solar_panel')->default(false);

            // Asset Value Estimation
            $table->decimal('estimated_total_value', 15, 2)->default(0);
            $table->text('asset_notes')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('vulnerability_assessment_id');
            $table->index('estimated_total_value');

            // Foreign Keys
            $table->foreign('vulnerability_assessment_id')->references('id')->on('vulnerability_assessments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_ownerships');
    }
};
