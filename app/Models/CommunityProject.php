<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class CommunityProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_code',
        'title',
        'description',
        'category',
        'priority',
        'status',
        'ward_id',
        'location',
        'latitude',
        'longitude',
        'beneficiaries_count',
        'households_count',
        'estimated_cost',
        'requested_amount',
        'approved_amount',
        'start_date',
        'end_date',
        'wdc_review_date',
        'cdfc_approval_date',
        'applicant_id',
        'assigned_officer_id',
        'wdc_remarks',
        'cdfc_remarks',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'wdc_review_date' => 'date',
        'cdfc_approval_date' => 'date',
        'estimated_cost' => 'decimal:2',
        'requested_amount' => 'decimal:2',
        'approved_amount' => 'decimal:2',
        'beneficiaries_count' => 'integer',
        'households_count' => 'integer',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class);
    }

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'applicant_id');
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
