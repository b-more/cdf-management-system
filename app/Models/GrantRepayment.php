<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GrantRepayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'repayment_code',
        'empowerment_grant_id',
        'description',
        'scheduled_amount',
        'paid_amount',
        'outstanding_amount',
        'penalty_amount',
        'interest_amount',
        'total_due',
        'due_date',
        'paid_date',
        'installment_number',
        'status',
        'payment_method',
        'transaction_reference',
        'receipt_number',
        'payment_notes',
        'grace_period_days',
        'extended_due_date',
        'penalty_rate',
        'extension_reason',
        'recorded_by_id',
        'approved_by_id',
        'remarks',
    ];

    protected $casts = [
        'scheduled_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'outstanding_amount' => 'decimal:2',
        'penalty_amount' => 'decimal:2',
        'interest_amount' => 'decimal:2',
        'total_due' => 'decimal:2',
        'due_date' => 'date',
        'paid_date' => 'date',
        'extended_due_date' => 'date',
        'penalty_rate' => 'decimal:2',
        'grace_period_days' => 'integer',
        'installment_number' => 'integer',
    ];

    public function empowermentGrant(): BelongsTo
    {
        return $this->belongsTo(EmpowermentGrant::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }
}
