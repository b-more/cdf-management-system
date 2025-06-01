<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ward extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'latitude',
        'longitude',
        'area_size',
        'contact_person',
        'phone',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'area_size' => 'decimal:2',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function communityProjects(): HasMany
    {
        return $this->hasMany(CommunityProject::class);
    }

    public function disasterProjects(): HasMany
    {
        return $this->hasMany(DisasterProject::class);
    }

    public function fundAllocations(): HasMany
    {
        return $this->hasMany(FundAllocation::class);
    }

    public function empowermentGrants(): HasMany
    {
        return $this->hasMany(EmpowermentGrant::class);
    }

    public function monitoringReports(): HasMany
    {
        return $this->hasMany(MonitoringReport::class);
    }

    public function empowermentPrograms(): HasMany
    {
        return $this->hasMany(Empowerment::class);
    }
}
