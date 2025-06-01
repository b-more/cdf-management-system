<?php

use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

// Safety check to prevent errors during migration/seeding
function checkTableExists(): bool
{
    try {
        return Schema::hasTable('permissions') && Schema::hasTable('roles');
    } catch (Exception $e) {
        return false;
    }
}

// User Management
function checkUserCreatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'User')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->create == 1) : false;
}

function checkUserReadPermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'User')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->read == 1) : false;
}

function checkUserUpdatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'User')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->update == 1) : false;
}

function checkUserDeletePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'User')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->delete == 1) : false;
}

// Ward Management
function checkWardCreatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'Ward')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->create == 1) : false;
}

function checkWardReadPermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'Ward')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->read == 1) : false;
}

function checkWardUpdatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'Ward')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->update == 1) : false;
}

function checkWardDeletePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'Ward')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->delete == 1) : false;
}

// Community Project Management
function checkCommunityProjectCreatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'CommunityProject')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->create == 1) : false;
}

function checkCommunityProjectReadPermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'CommunityProject')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->read == 1) : false;
}

function checkCommunityProjectUpdatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'CommunityProject')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->update == 1) : false;
}

function checkCommunityProjectDeletePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'CommunityProject')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->delete == 1) : false;
}

// Disaster Project Management
function checkDisasterProjectCreatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'DisasterProject')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->create == 1) : false;
}

function checkDisasterProjectReadPermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'DisasterProject')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->read == 1) : false;
}

function checkDisasterProjectUpdatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'DisasterProject')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->update == 1) : false;
}

function checkDisasterProjectDeletePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'DisasterProject')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->delete == 1) : false;
}

// Fund Allocation Management
function checkFundAllocationCreatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'FundAllocation')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->create == 1) : false;
}

function checkFundAllocationReadPermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'FundAllocation')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->read == 1) : false;
}

function checkFundAllocationUpdatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'FundAllocation')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->update == 1) : false;
}

function checkFundAllocationDeletePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'FundAllocation')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->delete == 1) : false;
}

// Monitoring Report Management
function checkMonitoringReportCreatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'MonitoringReport')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->create == 1) : false;
}

function checkMonitoringReportReadPermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'MonitoringReport')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->read == 1) : false;
}

function checkMonitoringReportUpdatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'MonitoringReport')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->update == 1) : false;
}

function checkMonitoringReportDeletePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'MonitoringReport')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->delete == 1) : false;
}

// Empowerment Grant Management
function checkEmpowermentGrantCreatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'EmpowermentGrant')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->create == 1) : false;
}

function checkEmpowermentGrantReadPermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'EmpowermentGrant')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->read == 1) : false;
}

function checkEmpowermentGrantUpdatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'EmpowermentGrant')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->update == 1) : false;
}

function checkEmpowermentGrantDeletePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'EmpowermentGrant')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->delete == 1) : false;
}

// SMS Notification Management
function checkSmsNotificationCreatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'SmsNotification')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->create == 1) : false;
}

function checkSmsNotificationReadPermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'SmsNotification')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->read == 1) : false;
}

function checkSmsNotificationUpdatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'SmsNotification')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->update == 1) : false;
}

function checkSmsNotificationDeletePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'SmsNotification')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->delete == 1) : false;
}

// Document Management
function checkDocumentCreatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'Document')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->create == 1) : false;
}

function checkDocumentReadPermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'Document')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->read == 1) : false;
}

function checkDocumentUpdatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'Document')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->update == 1) : false;
}

function checkDocumentDeletePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'Document')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->delete == 1) : false;
}

// Audit Trail Management
function checkAuditTrailCreatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'AuditTrail')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->create == 1) : false;
}

function checkAuditTrailReadPermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'AuditTrail')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->read == 1) : false;
}

function checkAuditTrailUpdatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'AuditTrail')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->update == 1) : false;
}

function checkAuditTrailDeletePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'AuditTrail')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->delete == 1) : false;
}

// Role Management
function checkRoleCreatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'Role')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->create == 1) : false;
}

function checkRoleReadPermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'Role')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->read == 1) : false;
}

function checkRoleUpdatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'Role')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->update == 1) : false;
}

function checkRoleDeletePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'Role')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->delete == 1) : false;
}

// Permission Management
function checkPermissionCreatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'Permission')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->create == 1) : false;
}

function checkPermissionReadPermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'Permission')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->read == 1) : false;
}

function checkPermissionUpdatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'Permission')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->update == 1) : false;
}

function checkPermissionDeletePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'Permission')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->delete == 1) : false;
}

// Grant Repayment Management
function checkGrantRepaymentCreatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'GrantRepayment')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->create == 1) : false;
}

function checkGrantRepaymentReadPermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'GrantRepayment')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->read == 1) : false;
}

function checkGrantRepaymentUpdatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'GrantRepayment')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->update == 1) : false;
}

function checkGrantRepaymentDeletePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'GrantRepayment')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->delete == 1) : false;
}

// Project Timeline Management
function checkProjectTimelineCreatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'ProjectTimeline')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->create == 1) : false;
}

function checkProjectTimelineReadPermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'ProjectTimeline')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->read == 1) : false;
}

function checkProjectTimelineUpdatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'ProjectTimeline')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->update == 1) : false;
}

function checkProjectTimelineDeletePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'ProjectTimeline')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->delete == 1) : false;
}

// Budget Line Management
function checkBudgetLineCreatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'BudgetLine')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->create == 1) : false;
}

function checkBudgetLineReadPermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'BudgetLine')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->read == 1) : false;
}

function checkBudgetLineUpdatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'BudgetLine')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->update == 1) : false;
}

function checkBudgetLineDeletePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'BudgetLine')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->delete == 1) : false;
}

// Dashboard Access
function checkDashboardReadPermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'Dashboard')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->read == 1) : false;
}

// Reports Access
function checkReportCreatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'Report')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->create == 1) : false;
}

function checkReportReadPermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'Report')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->read == 1) : false;
}

function checkReportUpdatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'Report')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->read == 1) : false;
}

function checkReportDeletePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'Report')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->delete == 1) : false;
}

// Empowerment Management
function checkEmpowermentCreatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'Empowerment')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->create == 1) : false;
}

function checkEmpowermentReadPermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'Empowerment')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->read == 1) : false;
}

function checkEmpowermentUpdatePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'Empowerment')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->update == 1) : false;
}

function checkEmpowermentDeletePermission(): bool
{
    if (!checkTableExists()) return true;
    $user = Auth::user();
    if (!$user || !$user->role_id) return false;

    $permission = Permission::where('module', 'Empowerment')->where('role_id', $user->role_id)->first();
    return $permission ? ($permission->delete == 1) : false;
}
