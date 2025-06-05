<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetOwnership extends Model
{
    use HasFactory;

    protected $fillable = [
        'vulnerability_assessment_id',
        'has_tractor',
        'has_plough',
        'has_hammer_mill',
        'has_car_truck',
        'other_durable_goods',
        'cattle_count',
        'goats_count',
        'sheep_count',
        'pigs_count',
        'poultry_count',
        'other_livestock',
        'has_radio',
        'has_television',
        'has_mobile_phone',
        'has_computer',
        'has_refrigerator',
        'has_generator',
        'has_water_pump',
        'has_solar_panel',
        'estimated_total_value',
        'asset_notes',
    ];

    protected $casts = [
        'has_tractor' => 'boolean',
        'has_plough' => 'boolean',
        'has_hammer_mill' => 'boolean',
        'has_car_truck' => 'boolean',
        'cattle_count' => 'integer',
        'goats_count' => 'integer',
        'sheep_count' => 'integer',
        'pigs_count' => 'integer',
        'poultry_count' => 'integer',
        'has_radio' => 'boolean',
        'has_television' => 'boolean',
        'has_mobile_phone' => 'boolean',
        'has_computer' => 'boolean',
        'has_refrigerator' => 'boolean',
        'has_generator' => 'boolean',
        'has_water_pump' => 'boolean',
        'has_solar_panel' => 'boolean',
        'estimated_total_value' => 'decimal:2',
    ];

    // Relationships
    public function vulnerabilityAssessment(): BelongsTo
    {
        return $this->belongsTo(VulnerabilityAssessment::class);
    }

    // Calculate asset score (inverse - fewer assets = higher vulnerability)
    public function calculateAssetScore(): float
    {
        $score = 20; // Start with maximum vulnerability score

        // Reduce score for each asset owned
        if ($this->has_tractor) $score -= 5;
        if ($this->has_plough) $score -= 2;
        if ($this->has_hammer_mill) $score -= 3;
        if ($this->has_car_truck) $score -= 4;
        if ($this->has_generator) $score -= 2;
        if ($this->has_water_pump) $score -= 2;
        if ($this->has_solar_panel) $score -= 2;

        // Livestock scoring
        if ($this->cattle_count > 0) $score -= min($this->cattle_count * 0.5, 3);
        if ($this->goats_count > 0) $score -= min($this->goats_count * 0.2, 2);
        if ($this->sheep_count > 0) $score -= min($this->sheep_count * 0.2, 2);
        if ($this->pigs_count > 0) $score -= min($this->pigs_count * 0.3, 2);
        if ($this->poultry_count > 0) $score -= min($this->poultry_count * 0.1, 1);

        return max($score, 0); // Don't go below 0
    }

    // Get total livestock count
    public function getTotalLivestockAttribute(): int
    {
        return $this->cattle_count + $this->goats_count + $this->sheep_count +
               $this->pigs_count + $this->poultry_count;
    }

    // Check if has significant assets
    public function hasSignificantAssets(): bool
    {
        return $this->has_tractor || $this->has_car_truck ||
               $this->cattle_count > 5 || $this->estimated_total_value > 10000;
    }
}
