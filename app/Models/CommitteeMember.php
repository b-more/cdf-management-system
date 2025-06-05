<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommitteeMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_committee_id',
        'member_name',
        'position',
        'gender',
        'nrc_number',
        'contact_phone',
        'email',
        'signature_path',
        'date_appointed',
        'is_active',
        'resignation_date',
        'resignation_reason',
        'skills_expertise',
        'previous_experience',
        'availability',
        'commitment_level',
    ];

    protected $casts = [
        'date_appointed' => 'date',
        'is_active' => 'boolean',
        'resignation_date' => 'date',
    ];

    // Relationships
    public function projectCommittee(): BelongsTo
    {
        return $this->belongsTo(ProjectCommittee::class);
    }

    // Check if member is chairperson
    public function isChairperson(): bool
    {
        return strtolower($this->position) === 'chairperson' || strtolower($this->position) === 'chair';
    }

    // Check if member is secretary
    public function isSecretary(): bool
    {
        return strtolower($this->position) === 'secretary';
    }

    // Check if member is treasurer
    public function isTreasurer(): bool
    {
        return strtolower($this->position) === 'treasurer';
    }

    // Scope for active members
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope by position
    public function scopeByPosition($query, $position)
    {
        return $query->where('position', $position);
    }

    // Scope by gender
    public function scopeByGender($query, $gender)
    {
        return $query->where('gender', $gender);
    }
}
