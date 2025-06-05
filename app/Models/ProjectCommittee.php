<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectCommittee extends Model
{
    use HasFactory;

    protected $fillable = [
        'community_project_id',
        'committee_type',
        'committee_name',
        'formation_date',
        'is_active',
        'dissolution_date',
        'dissolution_reason',
        'meeting_frequency',
        'last_meeting_date',
        'next_meeting_date',
        'chairperson_name',
        'secretary_name',
        'treasurer_name',
        'committee_description',
        'responsibilities',
        'achievements',
        'challenges',
    ];

    protected $casts = [
        'formation_date' => 'date',
        'is_active' => 'boolean',
        'dissolution_date' => 'date',
        'last_meeting_date' => 'date',
        'next_meeting_date' => 'date',
    ];

    // Relationships
    public function communityProject(): BelongsTo
    {
        return $this->belongsTo(CommunityProject::class);
    }

    public function committeeMembers(): HasMany
    {
        return $this->hasMany(CommitteeMember::class);
    }

    // Get active members count
    public function getActiveMembersCountAttribute(): int
    {
        return $this->committeeMembers()->active()->count();
    }

    // Check if committee is implementation type
    public function isImplementationCommittee(): bool
    {
        return $this->committee_type === 'implementation';
    }

    // Check if committee is management type
    public function isManagementCommittee(): bool
    {
        return $this->committee_type === 'management';
    }

    // Scope for active committees
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
