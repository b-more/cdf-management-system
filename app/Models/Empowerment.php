<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Empowerment extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_code',
        'title',
        'description',
        'program_type',
        'target_group',
        'status',
        'ward_id',
        'venue',
        'target_participants',
        'registered_participants',
        'completed_participants',
        'objectives',
        'curriculum',
        'duration_hours',
        'duration_days',
        'prerequisites',
        'required_materials',
        'equipment_needed',
        'facilitators',
        'start_date',
        'end_date',
        'session_time',
        'registration_deadline',
        'frequency',
        'total_budget',
        'allocated_budget',
        'spent_amount',
        'cost_per_participant',
        'funding_source',
        'expected_outcomes',
        'success_indicators',
        'completion_rate_target',
        'satisfaction_target',
        'coordinator_id',
        'approved_by_id',
        'implementation_notes',
        'evaluation_notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'registration_deadline' => 'date',
        'session_time' => 'datetime',
        'total_budget' => 'decimal:2',
        'allocated_budget' => 'decimal:2',
        'spent_amount' => 'decimal:2',
        'cost_per_participant' => 'decimal:2',
        'target_participants' => 'integer',
        'registered_participants' => 'integer',
        'completed_participants' => 'integer',
        'duration_hours' => 'integer',
        'duration_days' => 'integer',
        'completion_rate_target' => 'decimal:2',
        'satisfaction_target' => 'decimal:2',
    ];

    // Relationships
    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class);
    }

    public function coordinator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }

    // Polymorphic relationships
    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function budgetLines(): MorphMany
    {
        return $this->morphMany(BudgetLine::class, 'budgetable');
    }

    // Computed attributes
    public function getCompletionRateAttribute(): float
    {
        if ($this->target_participants > 0) {
            return round(($this->completed_participants / $this->target_participants) * 100, 2);
        }
        return 0;
    }

    public function getRegistrationRateAttribute(): float
    {
        if ($this->target_participants > 0) {
            return round(($this->registered_participants / $this->target_participants) * 100, 2);
        }
        return 0;
    }

    public function getBudgetUtilizationAttribute(): float
    {
        if ($this->allocated_budget > 0) {
            return round(($this->spent_amount / $this->allocated_budget) * 100, 2);
        }
        return 0;
    }

    public function getRemainingBudgetAttribute(): float
    {
        return $this->allocated_budget - $this->spent_amount;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['Active', 'Ongoing']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'Completed');
    }

    public function scopeByWard($query, $wardId)
    {
        return $query->where('ward_id', $wardId);
    }

    public function scopeByProgramType($query, $type)
    {
        return $query->where('program_type', $type);
    }

    public function scopeByTargetGroup($query, $group)
    {
        return $query->where('target_group', $group);
    }

    // Helper methods
    public function isActive(): bool
    {
        return in_array($this->status, ['Active', 'Ongoing']);
    }

    public function isCompleted(): bool
    {
        return $this->status === 'Completed';
    }

    public function canRegister(): bool
    {
        return $this->status === 'Active' &&
               ($this->registration_deadline === null || $this->registration_deadline >= now()) &&
               $this->registered_participants < $this->target_participants;
    }

    public function hasStarted(): bool
    {
        return $this->start_date && $this->start_date <= now();
    }

    public function hasEnded(): bool
    {
        return $this->end_date && $this->end_date < now();
    }

    public function getDuration(): int
    {
        if ($this->start_date && $this->end_date) {
            return $this->start_date->diffInDays($this->end_date);
        }
        return $this->duration_days ?? 0;
    }

    public function getAvailableSlots(): int
    {
        return max(0, $this->target_participants - $this->registered_participants);
    }
}
