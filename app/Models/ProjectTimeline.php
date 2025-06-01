<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectTimeline extends Model
{
    use HasFactory;

    protected $fillable = [
        'milestone_code',
        'title',
        'description',
        'project_type',
        'project_id',
        'planned_start_date',
        'planned_end_date',
        'actual_start_date',
        'actual_end_date',
        'planned_duration',
        'actual_duration',
        'variance_days',
        'status',
        'completion_percentage',
        'priority',
        'milestone_type',
        'is_critical_path',
        'dependencies',
        'required_resources',
        'deliverables',
        'budgeted_cost',
        'actual_cost',
        'cost_variance',
        'notes',
        'risks_issues',
        'assigned_to_id',
        'created_by_id',
    ];

    protected $casts = [
        'planned_start_date' => 'date',
        'planned_end_date' => 'date',
        'actual_start_date' => 'date',
        'actual_end_date' => 'date',
        'is_critical_path' => 'boolean',
        'budgeted_cost' => 'decimal:2',
        'actual_cost' => 'decimal:2',
        'cost_variance' => 'decimal:2',
        'completion_percentage' => 'integer',
        'planned_duration' => 'integer',
        'actual_duration' => 'integer',
        'variance_days' => 'integer',
    ];

    public function project()
    {
        // Dynamic relationship based on project_type
        if ($this->project_type === 'App\\Models\\CommunityProject') {
            return $this->belongsTo(CommunityProject::class, 'project_id');
        } elseif ($this->project_type === 'App\\Models\\DisasterProject') {
            return $this->belongsTo(DisasterProject::class, 'project_id');
        }
        return null;
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
