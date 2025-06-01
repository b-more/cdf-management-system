<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'ward_id',
        'phone',
        'image',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class);
    }

    public function communityProjects(): HasMany
    {
        return $this->hasMany(CommunityProject::class, 'applicant_id');
    }

    public function disasterProjects(): HasMany
    {
        return $this->hasMany(DisasterProject::class, 'applicant_id');
    }

    public function empowermentGrants(): HasMany
    {
        return $this->hasMany(EmpowermentGrant::class, 'beneficiary_id');
    }

    public function monitoringReports(): HasMany
    {
        return $this->hasMany(MonitoringReport::class, 'submitted_by');
    }

    public function smsNotifications(): HasMany
    {
        return $this->hasMany(SmsNotification::class);
    }

    public function auditTrails(): HasMany
    {
        return $this->hasMany(AuditTrail::class);
    }

    public function isAdmin(): bool
    {
        return $this->role_id === 1;
    }

    public function isWDC(): bool
    {
        return $this->role?->name === 'WDC';
    }

    public function isCDFC(): bool
    {
        return $this->role?->name === 'CDFC';
    }
}
