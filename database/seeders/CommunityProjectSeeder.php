<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CommunityProject;
use App\Models\User;
use App\Models\Ward;
use Carbon\Carbon;

class CommunityProjectSeeder extends Seeder
{
    public function run(): void
    {
        $applicants = User::whereHas('role', fn($q) => $q->where('name', 'Applicant'))->get();
        $officers = User::whereHas('role', fn($q) => $q->whereIn('name', ['Officer', 'WDC', 'CDFC']))->get();
        $wards = Ward::all();

        $projects = [
            [
                'project_code' => 'CDF-2024-001',
                'title' => 'Kanyama Market Rehabilitation',
                'description' => 'Rehabilitation and upgrade of Kanyama Market infrastructure including roofing, drainage, and stall improvements.',
                'category' => 'Infrastructure',
                'priority' => 'High',
                'status' => 'Implementation',
                'ward_id' => $wards->where('name', 'Kanyama')->first()->id,
                'location' => 'Kanyama Market Complex',
                'latitude' => -15.4067,
                'longitude' => 28.2833,
                'beneficiaries_count' => 500,
                'households_count' => 200,
                'estimated_cost' => 45000.00,
                'requested_amount' => 40000.00,
                'approved_amount' => 38000.00,
                'start_date' => Carbon::now()->subDays(30),
                'end_date' => Carbon::now()->addDays(60),
                'wdc_review_date' => Carbon::now()->subDays(45),
                'cdfc_approval_date' => Carbon::now()->subDays(35),
                'applicant_id' => $applicants->random()->id,
                'assigned_officer_id' => $officers->random()->id,
                'wdc_remarks' => 'Project approved with recommendations for improved drainage system',
                'cdfc_remarks' => 'Approved with budget adjustment for better cost-effectiveness',
            ],
            [
                'project_code' => 'CDF-2024-002',
                'title' => 'Matero Community Borehole',
                'description' => 'Construction of a community borehole with solar-powered water pump system.',
                'category' => 'Water',
                'priority' => 'Critical',
                'status' => 'Completed',
                'ward_id' => $wards->where('name', 'Matero')->first()->id,
                'location' => 'Matero Main Community Center',
                'latitude' => -15.3833,
                'longitude' => 28.3167,
                'beneficiaries_count' => 800,
                'households_count' => 320,
                'estimated_cost' => 25000.00,
                'requested_amount' => 25000.00,
                'approved_amount' => 24000.00,
                'start_date' => Carbon::now()->subDays(90),
                'end_date' => Carbon::now()->subDays(15),
                'wdc_review_date' => Carbon::now()->subDays(110),
                'cdfc_approval_date' => Carbon::now()->subDays(95),
                'applicant_id' => $applicants->random()->id,
                'assigned_officer_id' => $officers->random()->id,
                'wdc_remarks' => 'Critical need for clean water access in the community',
                'cdfc_remarks' => 'Approved as high priority infrastructure project',
            ],
            [
                'project_code' => 'CDF-2024-003',
                'title' => 'Munali Primary School Classroom Block',
                'description' => 'Construction of a 4-classroom block with modern facilities for Munali Primary School.',
                'category' => 'Education',
                'priority' => 'High',
                'status' => 'CDFC_Review',
                'ward_id' => $wards->where('name', 'Munali')->first()->id,
                'location' => 'Munali Primary School Compound',
                'latitude' => -15.3500,
                'longitude' => 28.3500,
                'beneficiaries_count' => 600,
                'households_count' => 240,
                'estimated_cost' => 65000.00,
                'requested_amount' => 60000.00,
                'approved_amount' => null,
                'start_date' => Carbon::now()->addDays(30),
                'end_date' => Carbon::now()->addDays(120),
                'wdc_review_date' => Carbon::now()->subDays(10),
                'cdfc_approval_date' => null,
                'applicant_id' => $applicants->random()->id,
                'assigned_officer_id' => $officers->random()->id,
                'wdc_remarks' => 'Recommended for approval - addresses overcrowding in school',
                'cdfc_remarks' => null,
            ],
            [
                'project_code' => 'CDF-2024-004',
                'title' => 'Kabwata Health Post Equipment',
                'description' => 'Procurement of medical equipment and supplies for Kabwata Health Post.',
                'category' => 'Health',
                'priority' => 'Medium',
                'status' => 'WDC_Approved',
                'ward_id' => $wards->where('name', 'Kabwata')->first()->id,
                'location' => 'Kabwata Health Post',
                'latitude' => -15.4167,
                'longitude' => 28.2833,
                'beneficiaries_count' => 1200,
                'households_count' => 480,
                'estimated_cost' => 18000.00,
                'requested_amount' => 18000.00,
                'approved_amount' => null,
                'start_date' => Carbon::now()->addDays(15),
                'end_date' => Carbon::now()->addDays(45),
                'wdc_review_date' => Carbon::now()->subDays(5),
                'cdfc_approval_date' => null,
                'applicant_id' => $applicants->random()->id,
                'assigned_officer_id' => $officers->random()->id,
                'wdc_remarks' => 'Approved - will improve healthcare delivery in the area',
                'cdfc_remarks' => null,
            ],
            [
                'project_code' => 'CDF-2024-005',
                'title' => 'Chongwe Youth Sports Complex',
                'description' => 'Development of a multi-purpose sports complex for youth activities and tournaments.',
                'category' => 'Sports',
                'priority' => 'Medium',
                'status' => 'Draft',
                'ward_id' => $wards->where('name', 'Chongwe Central')->first()->id,
                'location' => 'Chongwe Central Community Grounds',
                'latitude' => -15.3333,
                'longitude' => 28.6833,
                'beneficiaries_count' => 300,
                'households_count' => 120,
                'estimated_cost' => 35000.00,
                'requested_amount' => 32000.00,
                'approved_amount' => null,
                'start_date' => Carbon::now()->addDays(60),
                'end_date' => Carbon::now()->addDays(150),
                'wdc_review_date' => null,
                'cdfc_approval_date' => null,
                'applicant_id' => $applicants->random()->id,
                'assigned_officer_id' => null,
                'wdc_remarks' => null,
                'cdfc_remarks' => null,
            ],
        ];

        foreach ($projects as $project) {
            CommunityProject::firstOrCreate(
                ['project_code' => $project['project_code']],
                $project
            );
        }
    }
}
