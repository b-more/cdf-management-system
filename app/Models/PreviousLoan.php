<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PreviousLoan extends Model
{
    use HasFactory;

    protected $fillable = [
        'empowerment_application_id',
        'organization_name',
        'loan_amount',
        'loan_currency',
        'loan_date',
        'loan_purpose',
        'loan_status',
        'repayment_status',
        'outstanding_amount',
        'repayment_period_months',
        'interest_rate',
        'collateral_provided',
        'collateral_details',
        'guarantors_count',
        'loan_reference_number',
        'contact_person',
        'contact_phone',
        'remarks',
    ];

    protected $casts = [
        'loan_amount' => 'decimal:2',
        'outstanding_amount' => 'decimal:2',
        'loan_date' => 'date',
        'repayment_period_months' => 'integer',
        'interest_rate' => 'decimal:2',
        'guarantors_count' => 'integer',
    ];

    // Relationships
    public function empowermentApplication(): BelongsTo
    {
        return $this->belongsTo(EmpowermentApplication::class);
    }

    // Check if loan is fully repaid
    public function isFullyRepaid(): bool
    {
        return $this->repayment_status === 'fully_paid' || $this->outstanding_amount <= 0;
    }

    // Check if loan is defaulted
    public function isDefaulted(): bool
    {
        return $this->loan_status === 'defaulted';
    }

    // Get repayment percentage
    public function getRepaymentPercentageAttribute(): float
    {
        if ($this->loan_amount <= 0) return 0;

        $repaidAmount = $this->loan_amount - $this->outstanding_amount;
        return ($repaidAmount / $this->loan_amount) * 100;
    }

    // Scope for active loans
    public function scopeActive($query)
    {
        return $query->whereIn('loan_status', ['active', 'current']);
    }

    // Scope for defaulted loans
    public function scopeDefaulted($query)
    {
        return $query->where('loan_status', 'defaulted');
    }

    // Scope for fully paid loans
    public function scopeFullyPaid($query)
    {
        return $query->where('repayment_status', 'fully_paid');
    }
}
