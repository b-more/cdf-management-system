<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class EmpowermentApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_code',
        'application_type',
        'status',
        'organization_name',
        'organization_type',
        'registration_date',
        'registration_number',
        'registration_authority',
        'ward_id',
        'district',
        'constituency',
        'zone',
        'business_physical_address',
        'grant_type',
        'requested_amount',
        'approved_amount',
        'disbursed_amount',
        'has_similar_experience',
        'experience_details',
        'main_community_problems',
        'target_problem',
        'project_identification_process',
        'community_benefits',
        'direct_jobs_created',
        'has_previous_loans',
        'member_count',
        'bank_name',
        'branch',
        'sort_code',
        'swift_code',
        'account_number',
        'tpin',
        'mobile_wallet_name',
        'mobile_wallet_number',
        'received_entrepreneurship_training',
        'received_technical_training',
        'received_savings_training',
        'received_literacy_training',
        'received_financial_literacy_training',
        'trained_members_count',
        'training_details',
        'primary_contact_name',
        'primary_contact_address',
        'primary_contact_phone',
        'primary_contact_nrc',
        'secondary_contact_name',
        'secondary_contact_address',
        'secondary_contact_phone',
        'secondary_contact_nrc',
        'submission_date',
        'wdc_remarks',
        'cdfc_remarks',
        'wdc_review_date',
        'cdfc_approval_date',
        'processed_by_id',
        'approved_by_id',
    ];

    protected $casts = [
        'registration_date' => 'date',
        'requested_amount' => 'decimal:2',
        'approved_amount' => 'decimal:2',
        'disbursed_amount' => 'decimal:2',
        'has_similar_experience' => 'boolean',
        'has_previous_loans' => 'boolean',
        'member_count' => 'integer',
        'direct_jobs_created' => 'integer',
        'received_entrepreneurship_training' => 'boolean',
        'received_technical_training' => 'boolean',
        'received_savings_training' => 'boolean',
        'received_literacy_training' => 'boolean',
        'received_financial_literacy_training' => 'boolean',
        'trained_members_count' => 'integer',
        'submission_date' => 'datetime',
        'wdc_review_date' => 'datetime',
        'cdfc_approval_date' => 'datetime',
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

    public function groupMemberships(): HasMany
    {
        return $this->hasMany(GroupMembership::class);
    }

    public function previousLoans(): HasMany
    {
        return $this->hasMany(PreviousLoan::class);
    }

    public function vulnerabilityAssessment(): MorphOne
    {
        return $this->morphOne(VulnerabilityAssessment::class, 'assessable');
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    // Generate unique application code
    public static function generateApplicationCode(string $type): string
    {
        $prefix = $type === 'grant' ? 'GRANT' : 'LOAN';
        $year = date('Y');
        $sequence = str_pad(self::where('application_type', $type)->count() + 1, 4, '0', STR_PAD_LEFT);

        return "CDF-EMP-{$prefix}-{$year}-{$sequence}";
    }

    // Check if application is approved
    public function isApproved(): bool
    {
        return $this->status === 'cdfc_approved';
    }

    // Check if application is rejected
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    // Check if is grant application
    public function isGrant(): bool
    {
        return $this->application_type === 'grant';
    }

    // Check if is loan application
    public function isLoan(): bool
    {
        return $this->application_type === 'loan';
    }

    // Calculate training score
    public function getTrainingScore(): int
    {
        $trainings = 0;
        if ($this->received_entrepreneurship_training) $trainings++;
        if ($this->received_technical_training) $trainings++;
        if ($this->received_savings_training) $trainings++;
        if ($this->received_literacy_training) $trainings++;
        if ($this->received_financial_literacy_training) $trainings++;

        return $trainings;
    }

    // Check if organization meets minimum requirements
    public function meetsMinimumRequirements(): bool
    {
        return $this->member_count >= 10 &&
               !empty($this->account_number) &&
               $this->direct_jobs_created > 0;
    }

    // Scope for grants only
    public function scopeGrants($query)
    {
        return $query->where('application_type', 'grant');
    }

    // Scope for loans only
    public function scopeLoans($query)
    {
        return $query->where('application_type', 'loan');
    }

    // Scope by organization type
    public function scopeByOrganizationType($query, $type)
    {
        return $query->where('organization_type', $type);
    }
}
