<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MonitoringReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_code',
        'report_type',
        'title',
        'executive_summary',
        'content',
        'reportable_type',
        'reportable_id',
        'ward_id',
        'contractor_name',
        'progress_percentage',
        'physical_progress',
        'financial_progress',
        'status',
        'overall_rating',
        'quality_rating',
        'safety_rating',
        'environmental_compliance',
        'community_satisfaction',
        'quality_notes',
        'budget_allocated',
        'amount_spent',
        'remaining_budget',
        'budget_variance',
        'budget_status',
        'reporting_period_start',
        'reporting_period_end',
        'visit_date',
        'expected_completion',
        'revised_completion',
        'delay_days',
        'issues_identified',
        'challenges_faced',
        'risk_level',
        'recommendations',
        'next_steps',
        'corrective_actions',
        'prepared_by_id',
        'reviewed_by_id',
        'submission_deadline',
        'review_deadline',
        'lessons_learned',
        'best_practices',
        'stakeholder_feedback',
    ];

    protected $casts = [
        'reporting_period_start' => 'date',
        'reporting_period_end' => 'date',
        'visit_date' => 'date',
        'expected_completion' => 'date',
        'revised_completion' => 'date',
        'submission_deadline' => 'date',
        'review_deadline' => 'date',
        'budget_allocated' => 'decimal:2',
        'amount_spent' => 'decimal:2',
        'remaining_budget' => 'decimal:2',
        'budget_variance' => 'decimal:2',
        'progress_percentage' => 'integer',
        'physical_progress' => 'integer',
        'financial_progress' => 'integer',
        'delay_days' => 'integer',
    ];

    public function reportable(): MorphTo
    {
        return $this->morphTo();
    }

    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class);
    }

    public function preparedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'prepared_by_id');
    }

    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by_id');
    }
}
