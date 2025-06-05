<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectSustainabilityPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'community_project_id',
        'sustainability_strategy',
        'maintenance_plan',
        'maintenance_schedule',
        'maintenance_responsibility',
        'maintenance_budget',
        'funding_sources',
        'community_ownership_plan',
        'capacity_building_needs',
        'training_requirements',
        'technical_support_needs',
        'institutional_arrangements',
        'governance_structure',
        'monitoring_arrangements',
        'evaluation_framework',
        'risk_mitigation_plan',
        'contingency_plans',
        'sustainability_indicators',
        'review_schedule',
        'reporting_mechanism',
        'community_commitment',
        'stakeholder_roles',
        'resource_mobilization_plan',
    ];

    protected $casts = [
        'maintenance_budget' => 'decimal:2',
    ];

    // Relationships
    public function communityProject(): BelongsTo
    {
        return $this->belongsTo(CommunityProject::class);
    }

    // Check if has adequate maintenance budget
    public function hasAdequateMaintenanceBudget(): bool
    {
        return $this->maintenance_budget > 0;
    }

    // Check if has clear ownership plan
    public function hasClearOwnershipPlan(): bool
    {
        return !empty($this->community_ownership_plan) && !empty($this->governance_structure);
    }

    // Get sustainability score based on completeness
    public function getSustainabilityScore(): int
    {
        $score = 0;
        $fields = [
            'sustainability_strategy',
            'maintenance_plan',
            'maintenance_responsibility',
            'funding_sources',
            'community_ownership_plan',
            'governance_structure',
            'monitoring_arrangements',
            'community_commitment'
        ];

        foreach ($fields as $field) {
            if (!empty($this->$field)) {
                $score += 12.5; // Each field worth 12.5 points for 100% total
            }
        }

        return min($score, 100);
    }
}
