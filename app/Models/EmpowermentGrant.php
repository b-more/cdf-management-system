<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class EmpowermentGrant extends Model
{
    use HasFactory;

    protected $fillable = [
        'grant_code',
        'grant_type',
        'title',
        'description',
        'status',
        'priority',
        'requires_repayment',
        'beneficiary_id',
        'ward_id',
        'beneficiary_age',
        'beneficiary_gender',
        'requested_amount',
        'approved_amount',
        'disbursed_amount',
        'interest_rate',
        'repayment_period',
        'total_repayment',
        'application_date',
        'approval_date',
        'disbursement_date',
        'repayment_start_date',
        'processed_by_id',
        'approved_by_id',
        'assessment_notes',
        'conditions',
    ];

    protected $casts = [
        'requires_repayment' => 'boolean',
        'requested_amount' => 'decimal:2',
        'approved_amount' => 'decimal:2',
        'disbursed_amount' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'total_repayment' => 'decimal:2',
        'application_date' => 'date',
        'approval_date' => 'date',
        'disbursement_date' => 'date',
        'repayment_start_date' => 'date',
        'beneficiary_age' => 'integer',
        'repayment_period' => 'integer',
    ];

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(User::class, 'beneficiary_id');
    }

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

    public function repayments(): HasMany
    {
        return $this->hasMany(GrantRepayment::class);
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function budgetLines(): MorphMany
    {
        return $this->morphMany(BudgetLine::class, 'budgetable');
    }
}

