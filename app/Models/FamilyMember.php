<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FamilyMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'educational_bursary_id',
        'relationship',
        'vital_status',
        'surname',
        'first_name',
        'other_names',
        'gender',
        'date_of_birth',
        'nationality',
        'nrc_number',
        'relationship_to_applicant',
        'village',
        'chief',
        'district',
        'residential_address',
        'constituency',
        'province',
        'postal_address',
        'mobile_phone',
        'email',
        'occupation',
        'employer_name',
        'position_rank',
        'employer_address',
        'has_disability',
        'disability_nature',
        'has_medical_condition',
        'medical_condition_details',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'has_disability' => 'boolean',
        'has_medical_condition' => 'boolean',
    ];

    // Relationships
    public function educationalBursary(): BelongsTo
    {
        return $this->belongsTo(EducationalBursary::class);
    }

    // Accessor for full name
    public function getFullNameAttribute(): string
    {
        return trim($this->surname . ' ' . $this->first_name . ' ' . $this->other_names);
    }

    // Check if family member is deceased
    public function isDeceased(): bool
    {
        return $this->vital_status === 'deceased';
    }

    // Check if family member is employed
    public function isEmployed(): bool
    {
        return !empty($this->occupation) && !empty($this->employer_name);
    }

    // Scope for parents only
    public function scopeParents($query)
    {
        return $query->whereIn('relationship', ['father', 'mother']);
    }

    // Scope for guardians only
    public function scopeGuardians($query)
    {
        return $query->where('relationship', 'guardian');
    }

    // Scope for alive members
    public function scopeAlive($query)
    {
        return $query->where('vital_status', 'alive');
    }
}
