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
        Schema::create('housing_assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vulnerability_assessment_id');

            // Housing Ownership
            $table->enum('ownership_type', ['owned', 'rented', 'inherited', 'sublet', 'other']);
            $table->string('ownership_other')->nullable();

            // House Structure Materials
            $table->enum('roof_material', [
                'asbestos_sheets', 'asbestos_tiles', 'other_non_asbestos_tile',
                'iron_sheets', 'grass_wood_thatch', 'concrete'
            ]);
            $table->enum('floor_material', [
                'earth_sand', 'wood_planks', 'palm_bamboo',
                'finished_floor_wood_tiles', 'concrete', 'vinyl'
            ]);
            $table->enum('wall_material', [
                'natural_walls_mud_cane', 'rudimentary_walls_stone_bamboo',
                'finished_walls_bricks_cement'
            ]);

            // Basic Services
            $table->enum('toilet_location', ['inside_house', 'outside_house']);
            $table->enum('water_source', ['piped', 'well', 'shallow_well', 'other']);
            $table->string('water_source_other')->nullable();
            $table->enum('water_availability', ['communal', 'own_premises']);
            $table->boolean('has_electricity')->default(false);

            // Household Information
            $table->string('main_income_source')->nullable();
            $table->integer('meals_per_day')->default(2);
            $table->text('meal_details')->nullable();

            $table->timestamps();

            // Indexes
            // $table->index('vulnerability_assessment_id');
            // $table->index(['roof_material', 'floor_material', 'wall_material']);
            // $table->index('water_source');

            // Foreign Keys
            $table->foreign('vulnerability_assessment_id')->references('id')->on('vulnerability_assessments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('housing_assessments');
    }
};
