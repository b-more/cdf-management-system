<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiblingDependent extends Model
{
    use HasFactory;

    protected $fillable = [
        'educational_bursary_id',
        'type',
        'name',
        'sex',
        'age',
        'occupation',
        'vital_status',
        'is_in_school',
        'school_name',
        'grade_level',
        'education_supporter',
        'is_dependent',
        'dependency_notes',
    ];

    protected $casts = [
        'age' => 'integer',
        'is_in_school' => 'boolean',
        'is_dependent' => 'boolean',
    ];

    // Relationships
    public function educationalBursary(): BelongsTo
    {
        return $this->belongsTo(EducationalBursary::class);
    }

    // Check if is sibling
    public function isSibling(): bool
    {
        return $this->type === 'sibling';
    }

    // Check if is dependent
    public function isDependent(): bool
    {
        return $this->type === 'dependent';
    }

    // Check if is alive
    public function isAlive(): bool
    {
        return $this->vital_status === 'alive';
    }

    // Scope for siblings only
    public function scopeSiblings($query)
    {
        return $query->where('type', 'sibling');
    }

    // Scope for dependents only
    public function scopeDependents($query)
    {
        return $query->where('type', 'dependent');
    }

    // Scope for those in school
    public function scopeInSchool($query)
    {
        return $query->where('is_in_school', true);
    }
}
