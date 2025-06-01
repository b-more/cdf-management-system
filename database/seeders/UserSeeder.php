<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Ward;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminRole = Role::where('name', 'Super Admin')->first();
        $adminRole = Role::where('name', 'Admin')->first();
        $wdcRole = Role::where('name', 'WDC')->first();
        $cdfcRole = Role::where('name', 'CDFC')->first();
        $officerRole = Role::where('name', 'Officer')->first();
        $applicantRole = Role::where('name', 'Applicant')->first();

        $kanyamaWard = Ward::where('name', 'Kanyama')->first();
        $materoWard = Ward::where('name', 'Matero')->first();

        $users = [
            [
                'name' => 'System Administrator',
                'email' => 'admin@cdf.gov.zm',
                'password' => Hash::make('Admin.1234'),
                'role_id' => $superAdminRole->id,
                'ward_id' => null,
                'phone' => '260971000001',
                'is_active' => true,
            ],
            [
                'name' => 'CDF Administrator',
                'email' => 'cdf.admin@cdf.gov.zm',
                'password' => Hash::make('Admin.1234'),
                'role_id' => $adminRole->id,
                'ward_id' => null,
                'phone' => '260971000002',
                'is_active' => true,
            ],
            [
                'name' => 'John Mwansa',
                'email' => 'john.mwansa@kanyama.wdc.zm',
                'password' => Hash::make('Admin.1234'),
                'role_id' => $wdcRole->id,
                'ward_id' => $kanyamaWard->id,
                'phone' => '260971000003',
                'is_active' => true,
            ],
            [
                'name' => 'Mary Banda',
                'email' => 'mary.banda@matero.wdc.zm',
                'password' => Hash::make('Admin.1234'),
                'role_id' => $wdcRole->id,
                'ward_id' => $materoWard->id,
                'phone' => '260971000004',
                'is_active' => true,
            ],
            [
                'name' => 'Peter Chanda',
                'email' => 'peter.chanda@kanyama.cdfc.zm',
                'password' => Hash::make('Admin.1234'),
                'role_id' => $cdfcRole->id,
                'ward_id' => $kanyamaWard->id,
                'phone' => '260971000005',
                'is_active' => true,
            ],
            [
                'name' => 'Grace Mulenga',
                'email' => 'grace.mulenga@officer.zm',
                'password' => Hash::make('Admin.1234'),
                'role_id' => $officerRole->id,
                'ward_id' => null,
                'phone' => '260971000006',
                'is_active' => true,
            ],
            [
                'name' => 'James Phiri',
                'email' => 'james.phiri@community.zm',
                'password' => Hash::make('Admin.1234'),
                'role_id' => $applicantRole->id,
                'ward_id' => $kanyamaWard->id,
                'phone' => '260971000007',
                'is_active' => true,
            ],
            [
                'name' => 'Susan Tembo',
                'email' => 'susan.tembo@community.zm',
                'password' => Hash::make('Admin.1234'),
                'role_id' => $applicantRole->id,
                'ward_id' => $materoWard->id,
                'phone' => '260971000008',
                'is_active' => true,
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(['email' => $user['email']], $user);
        }
    }
}
