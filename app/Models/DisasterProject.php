<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class DisasterProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_code',
        'disaster_type',
        'title',
        'description',
        'severity',
        'status',
        'is_emergency',
        'ward_id',
        'location',
        'latitude',
        'longitude',
        'affected_people',
        'affected_households',
        'estimated_cost',
        'requested_amount',
        'approved_amount',
        'occurred_at',
        'reported_at',
        'response_deadline',
        'completion_date',
        'reported_by_id',
        'assigned_officer_id',
        'response_plan',
        'assessment_notes',
    ];

    protected $casts = [
        'occurred_at' => 'datetime',
        'reported_at' => 'datetime',
        'response_deadline' => 'date',
        'completion_date' => 'date',
        'is_emergency' => 'boolean',
        'estimated_cost' => 'decimal:2',
        'requested_amount' => 'decimal:2',
        'approved_amount' => 'decimal:2',
        'affected_people' => 'integer',
        'affected_households' => 'integer',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class);
    }

    public function reportedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by_id');
    }

    public function assignedOfficer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_officer_id');
    }

    public function monitoringReports(): MorphMany
    {
        return $this->morphMany(MonitoringReport::class, 'reportable');
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function budgetLines(): MorphMany
    {
        return $this->morphMany(BudgetLine::class, 'budgetable');
    }

    public function timelines(): HasMany
    {
        return $this->hasMany(ProjectTimeline::class, 'project_id')
                    ->where('project_type', self::class);
    }
}
