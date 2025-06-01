<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class BudgetLine extends Model
{
    use HasFactory;

    protected $fillable = [
        'budget_code',
        'line_item',
        'description',
        'category',
        'priority',
        'status',
        'fund_allocation_id',
        'budgetable_type',
        'budgetable_id',
        'budgeted_amount',
        'allocated_amount',
        'spent_amount',
        'committed_amount',
        'available_amount',
        'variance_amount',
        'unit_cost',
        'quantity',
        'budget_percentage',
        'utilization_rate',
        'variance_type',
        'budget_period_start',
        'budget_period_end',
        'approval_date',
        'first_expenditure_date',
        'last_expenditure_date',
        'prepared_by_id',
        'approved_by_id',
        'approval_notes',
        'revision_notes',
    ];

    protected $casts = [
        'budgeted_amount' => 'decimal:2',
        'allocated_amount' => 'decimal:2',
        'spent_amount' => 'decimal:2',
        'committed_amount' => 'decimal:2',
        'available_amount' => 'decimal:2',
        'variance_amount' => 'decimal:2',
        'unit_cost' => 'decimal:2',
        'budget_percentage' => 'decimal:2',
        'utilization_rate' => 'decimal:2',
        'quantity' => 'integer',
        'budget_period_start' => 'date',
        'budget_period_end' => 'date',
        'approval_date' => 'date',
        'first_expenditure_date' => 'date',
        'last_expenditure_date' => 'date',
    ];

    public function fundAllocation(): BelongsTo
    {
        return $this->belongsTo(FundAllocation::class);
    }

    public function budgetable(): MorphTo
    {
        return $this->morphTo();
    }

    public function preparedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'prepared_by_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }
}
