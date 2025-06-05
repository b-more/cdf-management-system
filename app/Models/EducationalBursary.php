<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class EducationalBursary extends Model
{
    use HasFactory;

    protected $fillable = [
        'bursary_code',
        'bursary_type',
        'status',
        'applicant_surname',
        'applicant_other_names',
        'gender',
        'nationality',
        'nrc_number',
        'date_of_birth',
        'place_of_birth',
        'ward_id',
        'district',
        'constituency',
        'zone',
        'postal_address',
        'mobile_phone',
        'email',
        'orphan_status',
        'is_disabled',
        'disability_nature',
        'financial_challenges',
        'is_school_leaver',
        'last_grade_attended',
        'last_school_attended',
        'last_school_district',
        'school_from_date',
        'school_to_date',
        'highest_certificate',
        'has_acceptance_letter',
        'institution_name',
        'programme_of_study',
        'programme_duration',
        'received_previous_scholarship',
        'previous_scholarship_details',
        'received_previous_cdf_bursary',
        'previous_cdf_details',
        'submission_date',
        'wdc_remarks',
        'cdfc_remarks',
        'wdc_review_date',
        'cdfc_approval_date',
        'processed_by_id',
        'approved_by_id',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'school_from_date' => 'date',
        'school_to_date' => 'date',
        'submission_date' => 'datetime',
        'wdc_review_date' => 'datetime',
        'cdfc_approval_date' => 'datetime',
        'is_disabled' => 'boolean',
        'is_school_leaver' => 'boolean',
        'has_acceptance_letter' => 'boolean',
        'received_previous_scholarship' => 'boolean',
        'received_previous_cdf_bursary' => 'boolean',
    ];

    // Relationships
    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class);
    }

    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }

    public function familyMembers(): HasMany
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function siblingDependents(): HasMany
    {
        return $this->hasMany(SiblingDependent::class);
    }

    public function vulnerabilityAssessment(): MorphOne
    {
        return $this->morphOne(VulnerabilityAssessment::class, 'assessable');
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    // Accessor for full name
    public function getFullNameAttribute(): string
    {
        return trim($this->applicant_surname . ' ' . $this->applicant_other_names);
    }

    // Scope for filtering by status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope for filtering by bursary type
    public function scopeByType($query, $type)
    {
        return $query->where('bursary_type', $type);
    }

    // Check if bursary is approved
    public function isApproved(): bool
    {
        return $this->status === 'cdfc_approved';
    }

    // Check if bursary is rejected
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    // Generate unique bursary code
    public static function generateBursaryCode(string $type): string
    {
        $prefix = $type === 'skills_development' ? 'SKILL' : 'SEC';
        $year = date('Y');
        $sequence = str_pad(self::where('bursary_type', $type)->count() + 1, 4, '0', STR_PAD_LEFT);

        return "CDF-{$prefix}-{$year}-{$sequence}";
    }
}
