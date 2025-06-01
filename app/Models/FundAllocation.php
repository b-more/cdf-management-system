<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FundAllocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'allocation_code',
        'financial_year',
        'title',
        'description',
        'total_amount',
        'allocated_amount',
        'disbursed_amount',
        'fund_type',
        'status',
        'ward_id',
        'allocation_date',
        'start_date',
        'end_date',
        'allocated_by_id',
        'approved_by_id',
        'remarks',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'allocated_amount' => 'decimal:2',
        'disbursed_amount' => 'decimal:2',
        'allocation_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class);
    }

    public function allocatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'allocated_by_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }

    public function budgetLines(): HasMany
    {
        return $this->hasMany(BudgetLine::class);
    }
}
