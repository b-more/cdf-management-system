<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HousingAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'vulnerability_assessment_id',
        'ownership_type',
        'ownership_other',
        'roof_material',
        'floor_material',
        'wall_material',
        'toilet_location',
        'water_source',
        'water_source_other',
        'water_availability',
        'has_electricity',
        'main_income_source',
        'meals_per_day',
        'meal_details',
    ];

    protected $casts = [
        'has_electricity' => 'boolean',
        'meals_per_day' => 'integer',
    ];

    // Relationships
    public function vulnerabilityAssessment(): BelongsTo
    {
        return $this->belongsTo(VulnerabilityAssessment::class);
    }

    // Calculate housing quality score
    public function calculateHousingScore(): float
    {
        $score = 0;

        // Roof material scoring (0-25 points)
        $roofScores = [
            'grass_wood_thatch' => 25,
            'iron_sheets' => 15,
            'asbestos_sheets' => 10,
            'asbestos_tiles' => 8,
            'other_non_asbestos_tile' => 5,
            'concrete' => 0
        ];
        $score += $roofScores[$this->roof_material] ?? 0;

        // Floor material scoring (0-20 points)
        $floorScores = [
            'earth_sand' => 20,
            'palm_bamboo' => 15,
            'wood_planks' => 10,
            'finished_floor_wood_tiles' => 5,
            'concrete' => 2,
            'vinyl' => 0
        ];
        $score += $floorScores[$this->floor_material] ?? 0;

        // Wall material scoring (0-15 points)
        $wallScores = [
            'natural_walls_mud_cane' => 15,
            'rudimentary_walls_stone_bamboo' => 10,
            'finished_walls_bricks_cement' => 0
        ];
        $score += $wallScores[$this->wall_material] ?? 0;

        return min($score, 60); // Cap at 60 points
    }

    // Calculate basic services score
    public function calculateServicesScore(): float
    {
        $score = 0;

        // Water source scoring
        $waterScores = [
            'shallow_well' => 15,
            'well' => 10,
            'other' => 8,
            'piped' => 0
        ];
        $score += $waterScores[$this->water_source] ?? 0;

        // Toilet location scoring
        if ($this->toilet_location === 'outside_house') {
            $score += 10;
        }

        // Electricity scoring
        if (!$this->has_electricity) {
            $score += 10;
        }

        return min($score, 35); // Cap at 35 points
    }

    // Calculate food security score
    public function calculateFoodSecurityScore(): float
    {
        $mealsScore = 0;

        switch ($this->meals_per_day) {
            case 1:
                $mealsScore = 20;
                break;
            case 2:
                $mealsScore = 10;
                break;
            case 3:
                $mealsScore = 0;
                break;
            default:
                $mealsScore = 0;
        }

        return $mealsScore;
    }
}
