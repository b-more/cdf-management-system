<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommunityContribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'community_project_id',
        'contribution_type',
        'description',
        'estimated_value',
        'actual_value',
        'quantity',
        'unit_of_measure',
        'contributor_type',
        'contributor_name',
        'contribution_date',
        'is_completed',
        'completion_date',
        'verification_status',
        'verified_by',
        'verification_date',
        'verification_notes',
        'receipt_number',
        'documentation_path',
    ];

    protected $casts = [
        'estimated_value' => 'decimal:2',
        'actual_value' => 'decimal:2',
        'quantity' => 'decimal:2',
        'contribution_date' => 'date',
        'is_completed' => 'boolean',
        'completion_date' => 'date',
        'verification_date' => 'date',
    ];

    // Relationships
    public function communityProject(): BelongsTo
    {
        return $this->belongsTo(CommunityProject::class);
    }

    // Check if contribution is labor
    public function isLaborContribution(): bool
    {
        return $this->contribution_type === 'labor';
    }

    // Check if contribution is materials
    public function isMaterialContribution(): bool
    {
        return $this->contribution_type === 'materials';
    }

    // Check if contribution is monetary
    public function isMonetaryContribution(): bool
    {
        return in_array($this->contribution_type, ['maintenance_fees', 'cash_contribution']);
    }

    // Get contribution value
    public function getContributionValueAttribute(): float
    {
        return $this->actual_value > 0 ? $this->actual_value : $this->estimated_value;
    }

    // Scope for completed contributions
    public function scopeCompleted($query)
    {
        return $query->where('is_completed', true);
    }

    // Scope by contribution type
    public function scopeByType($query, $type)
    {
        return $query->where('contribution_type', $type);
    }

    // Scope for verified contributions
    public function scopeVerified($query)
    {
        return $query->where('verification_status', 'verified');
    }
}
