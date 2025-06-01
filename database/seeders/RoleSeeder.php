<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Super Admin', 'is_deleted' => false],
            ['name' => 'Admin', 'is_deleted' => false],
            ['name' => 'WDC', 'is_deleted' => false],
            ['name' => 'CDFC', 'is_deleted' => false],
            ['name' => 'Officer', 'is_deleted' => false],
            ['name' => 'Applicant', 'is_deleted' => false],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']], $role);
        }
    }
}
