<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EconomicProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'vulnerability_assessment_id',
        'household_size',
        'adults_count',
        'children_count',
        'elderly_count',
        'disabled_members_count',
        'dependency_ratio',
        'primary_income_source',
        'secondary_income_source',
        'estimated_monthly_income',
        'income_is_regular',
        'income_reliability',
        'estimated_monthly_expenditure',
        'food_expenditure',
        'education_expenditure',
        'health_expenditure',
        'housing_expenditure',
        'has_savings',
        'savings_amount',
        'has_debt',
        'debt_amount',
        'can_afford_emergency_expense',
        'emergency_expense_threshold',
        'receives_social_support',
        'social_support_details',
        'receives_remittances',
        'monthly_remittances',
    ];

    protected $casts = [
        'household_size' => 'integer',
        'adults_count' => 'integer',
        'children_count' => 'integer',
        'elderly_count' => 'integer',
        'disabled_members_count' => 'integer',
        'dependency_ratio' => 'decimal:2',
        'estimated_monthly_income' => 'decimal:2',
        'income_is_regular' => 'boolean',
        'estimated_monthly_expenditure' => 'decimal:2',
        'food_expenditure' => 'decimal:2',
        'education_expenditure' => 'decimal:2',
        'health_expenditure' => 'decimal:2',
        'housing_expenditure' => 'decimal:2',
        'has_savings' => 'boolean',
        'savings_amount' => 'decimal:2',
        'has_debt' => 'boolean',
        'debt_amount' => 'decimal:2',
        'can_afford_emergency_expense' => 'boolean',
        'emergency_expense_threshold' => 'decimal:2',
        'receives_social_support' => 'boolean',
        'receives_remittances' => 'boolean',
        'monthly_remittances' => 'decimal:2',
    ];

    // Relationships
    public function vulnerabilityAssessment(): BelongsTo
    {
        return $this->belongsTo(VulnerabilityAssessment::class);
    }

    // Calculate dependency ratio
    public function calculateDependencyRatio(): float
    {
        if ($this->adults_count == 0) return 0;

        $dependents = $this->children_count + $this->elderly_count + $this->disabled_members_count;
        $ratio = $dependents / $this->adults_count;

        $this->update(['dependency_ratio' => $ratio]);

        return $ratio;
    }

    // Calculate family vulnerability score
    public function calculateFamilyVulnerabilityScore(): float
    {
        $score = 0;

        // Income reliability scoring
        $reliabilityScores = [
            'very_unreliable' => 15,
            'unreliable' => 10,
            'reliable' => 5,
            'very_reliable' => 0
        ];
        $score += $reliabilityScores[$this->income_reliability] ?? 10;

        // Dependency ratio scoring
        if ($this->dependency_ratio > 2.0) $score += 10;
        elseif ($this->dependency_ratio > 1.0) $score += 5;

        // Financial stress indicators
        if (!$this->has_savings) $score += 5;
        if ($this->has_debt) $score += 5;
        if (!$this->can_afford_emergency_expense) $score += 5;

        // Disability in household
        if ($this->disabled_members_count > 0) $score += 5;

        // Elderly in household
        if ($this->elderly_count > 0) $score += 3;

        return min($score, 50); // Cap at 50 points
    }

    // Get income per capita
    public function getIncomePerCapitaAttribute(): float
    {
        if ($this->household_size == 0) return 0;

        return $this->estimated_monthly_income / $this->household_size;
    }

    // Check if below poverty line (example threshold)
    public function isBelowPovertyLine(): bool
    {
        $povertyLinePerCapita = 500; // ZMW per person per month
        return $this->income_per_capita < $povertyLinePerCapita;
    }

    // Get financial stress level
    public function getFinancialStressLevel(): string
    {
        $stressFactors = 0;

        if (!$this->has_savings) $stressFactors++;
        if ($this->has_debt) $stressFactors++;
        if (!$this->can_afford_emergency_expense) $stressFactors++;
        if ($this->estimated_monthly_expenditure > $this->estimated_monthly_income) $stressFactors++;
        if (!$this->income_is_regular) $stressFactors++;

        if ($stressFactors >= 4) return 'critical';
        if ($stressFactors >= 3) return 'high';
        if ($stressFactors >= 2) return 'medium';
        return 'low';
    }
}
