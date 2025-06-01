<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed in correct order to maintain referential integrity
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            WardSeeder::class,
            UserSeeder::class,
            CommunityProjectSeeder::class,
            EmpowermentGrantSeeder::class,
            GrantRepaymentSeeder::class,
            EmpowermentSeeder::class,
        ]);
    }
}
