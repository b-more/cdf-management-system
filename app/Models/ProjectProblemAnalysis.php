<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectProblemAnalysis extends Model
{
    use HasFactory;

    protected $fillable = [
        'community_project_id',
        'main_problems',
        'priority_ranking',
        'target_problem',
        'proposed_solution',
        'alternative_solutions',
        'previous_attempts',
        'previous_attempts_success',
        'previous_attempts_details',
        'root_cause_analysis',
        'stakeholder_analysis',
        'risk_assessment',
        'mitigation_strategies',
        'success_indicators',
        'monitoring_plan',
        'community_consultation_process',
        'consultation_date',
        'consultation_participants',
        'consultation_outcomes',
        'consensus_level',
        'dissenting_opinions',
    ];

    protected $casts = [
        'previous_attempts_success' => 'boolean',
        'consultation_date' => 'date',
        'consultation_participants' => 'integer',
    ];

    // Relationships
    public function communityProject(): BelongsTo
    {
        return $this->belongsTo(CommunityProject::class);
    }

    // Check if previous attempts were successful
    public function hadSuccessfulPreviousAttempts(): bool
    {
        return $this->previous_attempts_success;
    }

    // Get consensus level as percentage
    public function getConsensusPercentageAttribute(): float
    {
        if (empty($this->consensus_level)) return 0;

        // Extract percentage from text like "80% consensus"
        preg_match('/(\d+)/', $this->consensus_level, $matches);
        return isset($matches[1]) ? (float)$matches[1] : 0;
    }

    // Check if has strong community consensus
    public function hasStrongConsensus(): bool
    {
        return $this->consensus_percentage >= 75;
    }
}
