<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            'User', 'Role', 'Permission', 'Ward', 'CommunityProject', 'DisasterProject',
            'FundAllocation', 'MonitoringReport', 'EmpowermentGrant', 'GrantRepayment',
            'SmsNotification', 'Document', 'AuditTrail', 'ProjectTimeline', 'BudgetLine',
            'Dashboard', 'Report', 'Empowerment'
        ];

        $roles = Role::all();

        foreach ($roles as $role) {
            foreach ($modules as $module) {
                $permissions = $this->getPermissionsForRole($role->name, $module);

                Permission::firstOrCreate(
                    ['role_id' => $role->id, 'module' => $module],
                    $permissions
                );
            }
        }
    }

    private function getPermissionsForRole(string $roleName, string $module): array
    {
        // Super Admin gets full access to everything
        if ($roleName === 'Super Admin') {
            return ['create' => true, 'read' => true, 'update' => true, 'delete' => true];
        }

        // Admin gets almost full access but limited on some sensitive modules
        if ($roleName === 'Admin') {
            $restrictedModules = ['Role', 'Permission', 'AuditTrail'];
            if (in_array($module, $restrictedModules)) {
                return ['create' => false, 'read' => true, 'update' => false, 'delete' => false];
            }
            return ['create' => true, 'read' => true, 'update' => true, 'delete' => true];
        }

        // WDC (Ward Development Committee) permissions
        if ($roleName === 'WDC') {
            $wdcModules = [
                'CommunityProject' => ['create' => false, 'read' => true, 'update' => true, 'delete' => false],
                'DisasterProject' => ['create' => true, 'read' => true, 'update' => true, 'delete' => false],
                'MonitoringReport' => ['create' => true, 'read' => true, 'update' => true, 'delete' => false],
                'ProjectTimeline' => ['create' => true, 'read' => true, 'update' => true, 'delete' => false],
                'Document' => ['create' => true, 'read' => true, 'update' => false, 'delete' => false],
                'Ward' => ['create' => false, 'read' => true, 'update' => false, 'delete' => false],
                'Empowerment' => ['create' => true, 'read' => true, 'update' => true, 'delete' => false],
                'SmsNotification' => ['create' => true, 'read' => true, 'update' => false, 'delete' => false],
                'Dashboard' => ['create' => false, 'read' => true, 'update' => false, 'delete' => false],
                'Report' => ['create' => true, 'read' => true, 'update' => false, 'delete' => false],
            ];

            return $wdcModules[$module] ?? ['create' => false, 'read' => false, 'update' => false, 'delete' => false];
        }

        // CDFC (Constituency Development Fund Committee) permissions
        if ($roleName === 'CDFC') {
            $cdfcModules = [
                'CommunityProject' => ['create' => false, 'read' => true, 'update' => true, 'delete' => false],
                'DisasterProject' => ['create' => false, 'read' => true, 'update' => true, 'delete' => false],
                'FundAllocation' => ['create' => true, 'read' => true, 'update' => true, 'delete' => false],
                'BudgetLine' => ['create' => true, 'read' => true, 'update' => true, 'delete' => false],
                'MonitoringReport' => ['create' => false, 'read' => true, 'update' => true, 'delete' => false],
                'EmpowermentGrant' => ['create' => true, 'read' => true, 'update' => true, 'delete' => false],
                'GrantRepayment' => ['create' => true, 'read' => true, 'update' => true, 'delete' => false],
                'Empowerment' => ['create' => true, 'read' => true, 'update' => true, 'delete' => false],
                'ProjectTimeline' => ['create' => false, 'read' => true, 'update' => false, 'delete' => false],
                'Document' => ['create' => true, 'read' => true, 'update' => false, 'delete' => false],
                'Ward' => ['create' => false, 'read' => true, 'update' => false, 'delete' => false],
                'SmsNotification' => ['create' => true, 'read' => true, 'update' => false, 'delete' => false],
                'Dashboard' => ['create' => false, 'read' => true, 'update' => false, 'delete' => false],
                'Report' => ['create' => true, 'read' => true, 'update' => false, 'delete' => false],
            ];

            return $cdfcModules[$module] ?? ['create' => false, 'read' => false, 'update' => false, 'delete' => false];
        }

        // Officer permissions (monitoring officers, provincial officers)
        if ($roleName === 'Officer') {
            $officerModules = [
                'MonitoringReport' => ['create' => true, 'read' => true, 'update' => true, 'delete' => false],
                'ProjectTimeline' => ['create' => true, 'read' => true, 'update' => true, 'delete' => false],
                'CommunityProject' => ['create' => false, 'read' => true, 'update' => false, 'delete' => false],
                'DisasterProject' => ['create' => false, 'read' => true, 'update' => false, 'delete' => false],
                'FundAllocation' => ['create' => false, 'read' => true, 'update' => false, 'delete' => false],
                'EmpowermentGrant' => ['create' => false, 'read' => true, 'update' => false, 'delete' => false],
                'GrantRepayment' => ['create' => false, 'read' => true, 'update' => false, 'delete' => false],
                'Empowerment' => ['create' => false, 'read' => true, 'update' => false, 'delete' => false],
                'Document' => ['create' => true, 'read' => true, 'update' => true, 'delete' => false],
                'Ward' => ['create' => false, 'read' => true, 'update' => false, 'delete' => false],
                'Dashboard' => ['create' => false, 'read' => true, 'update' => false, 'delete' => false],
                'Report' => ['create' => true, 'read' => true, 'update' => false, 'delete' => false],
            ];

            return $officerModules[$module] ?? ['create' => false, 'read' => false, 'update' => false, 'delete' => false];
        }

        // Applicant permissions (community members applying for projects)
        if ($roleName === 'Applicant') {
            $applicantModules = [
                'CommunityProject' => ['create' => true, 'read' => true, 'update' => true, 'delete' => false],
                'DisasterProject' => ['create' => true, 'read' => true, 'update' => true, 'delete' => false],
                'EmpowermentGrant' => ['create' => true, 'read' => true, 'update' => false, 'delete' => false],
                'GrantRepayment' => ['create' => false, 'read' => true, 'update' => false, 'delete' => false],
                'Empowerment' => ['create' => false, 'read' => true, 'update' => false, 'delete' => false],
                'Document' => ['create' => true, 'read' => true, 'update' => false, 'delete' => false],
                'MonitoringReport' => ['create' => false, 'read' => true, 'update' => false, 'delete' => false],
                'Ward' => ['create' => false, 'read' => true, 'update' => false, 'delete' => false],
                'Dashboard' => ['create' => false, 'read' => true, 'update' => false, 'delete' => false],
            ];

            return $applicantModules[$module] ?? ['create' => false, 'read' => false, 'update' => false, 'delete' => false];
        }

        // Default: no permissions
        return ['create' => false, 'read' => false, 'update' => false, 'delete' => false];
    }
}
