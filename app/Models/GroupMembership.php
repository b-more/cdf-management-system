<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupMembership extends Model
{
    use HasFactory;

    protected $fillable = [
        'empowerment_application_id',
        'member_name',
        'position',
        'gender',
        'nrc_number',
        'phone_number',
        'signature_path',
        'is_signatory',
        'date_joined',
        'is_active',
        'exit_date',
        'exit_reason',
    ];

    protected $casts = [
        'is_signatory' => 'boolean',
        'date_joined' => 'date',
        'is_active' => 'boolean',
        'exit_date' => 'date',
    ];

    // Relationships
    public function empowermentApplication(): BelongsTo
    {
        return $this->belongsTo(EmpowermentApplication::class);
    }

    // Check if member is a signatory
    public function isSignatory(): bool
    {
        return $this->is_signatory;
    }

    // Check if member is active
    public function isActive(): bool
    {
        return $this->is_active && is_null($this->exit_date);
    }

    // Scope for active members
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->whereNull('exit_date');
    }

    // Scope for signatories
    public function scopeSignatories($query)
    {
        return $query->where('is_signatory', true);
    }

    // Scope by gender
    public function scopeByGender($query, $gender)
    {
        return $query->where('gender', $gender);
    }
}
