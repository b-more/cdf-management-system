<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmpowermentGrant;
use App\Models\User;
use App\Models\Ward;
use Carbon\Carbon;

class EmpowermentGrantSeeder extends Seeder
{
    public function run(): void
    {
        $applicants = User::whereHas('role', fn($q) => $q->where('name', 'Applicant'))->get();
        $officers = User::whereHas('role', fn($q) => $q->whereIn('name', ['Officer', 'CDFC']))->get();
        $wards = Ward::all();

        $grants = [
            [
                'grant_code' => 'EGR-2024-001',
                'grant_type' => 'Business',
                'title' => 'Small Business Development Grant',
                'description' => 'Grant for starting a small retail business in Kanyama market',
                'status' => 'Active',
                'priority' => 'Medium',
                'requires_repayment' => false,
                'beneficiary_id' => $applicants->random()->id,
                'ward_id' => $wards->random()->id,
                'beneficiary_age' => 28,
                'beneficiary_gender' => 'Female',
                'requested_amount' => 5000.00,
                'approved_amount' => 4500.00,
                'disbursed_amount' => 4500.00,
                'application_date' => Carbon::now()->subDays(45),
                'approval_date' => Carbon::now()->subDays(30),
                'disbursement_date' => Carbon::now()->subDays(25),
                'processed_by_id' => $officers->random()->id,
                'approved_by_id' => $officers->random()->id,
                'assessment_notes' => 'Applicant has good business plan and market analysis',
                'conditions' => 'Must provide monthly progress reports for 6 months',
            ],
            [
                'grant_code' => 'EGR-2024-002',
                'grant_type' => 'Agriculture',
                'title' => 'Poultry Farming Loan',
                'description' => 'Micro-loan for starting a small poultry farming operation',
                'status' => 'Active',
                'priority' => 'High',
                'requires_repayment' => true,
                'beneficiary_id' => $applicants->random()->id,
                'ward_id' => $wards->random()->id,
                'beneficiary_age' => 35,
                'beneficiary_gender' => 'Male',
                'requested_amount' => 8000.00,
                'approved_amount' => 7500.00,
                'disbursed_amount' => 7500.00,
                'interest_rate' => 5.00,
                'repayment_period' => 18,
                'total_repayment' => 8250.00,
                'application_date' => Carbon::now()->subDays(60),
                'approval_date' => Carbon::now()->subDays(40),
                'disbursement_date' => Carbon::now()->subDays(35),
                'repayment_start_date' => Carbon::now()->subDays(30),
                'processed_by_id' => $officers->random()->id,
                'approved_by_id' => $officers->random()->id,
                'assessment_notes' => 'Strong agricultural background and good repayment capacity',
                'conditions' => 'Monthly repayments of K458 for 18 months',
            ],
            [
                'grant_code' => 'EGR-2024-003',
                'grant_type' => 'Skills',
                'title' => 'Tailoring Skills Development',
                'description' => 'Grant for purchasing tailoring equipment and training',
                'status' => 'Completed',
                'priority' => 'Medium',
                'requires_repayment' => false,
                'beneficiary_id' => $applicants->random()->id,
                'ward_id' => $wards->random()->id,
                'beneficiary_age' => 24,
                'beneficiary_gender' => 'Female',
                'requested_amount' => 3000.00,
                'approved_amount' => 3000.00,
                'disbursed_amount' => 3000.00,
                'application_date' => Carbon::now()->subDays(120),
                'approval_date' => Carbon::now()->subDays(100),
                'disbursement_date' => Carbon::now()->subDays(95),
                'processed_by_id' => $officers->random()->id,
                'approved_by_id' => $officers->random()->id,
                'assessment_notes' => 'Completed tailoring course successfully',
                'conditions' => 'Must establish tailoring business within 3 months',
            ],
            [
                'grant_code' => 'EGR-2024-004',
                'grant_type' => 'Youth',
                'title' => 'Youth Technology Empowerment',
                'description' => 'Grant for purchasing computer equipment for internet cafe',
                'status' => 'Review',
                'priority' => 'High',
                'requires_repayment' => false,
                'beneficiary_id' => $applicants->random()->id,
                'ward_id' => $wards->random()->id,
                'beneficiary_age' => 22,
                'beneficiary_gender' => 'Male',
                'requested_amount' => 12000.00,
                'approved_amount' => null,
                'disbursed_amount' => 0.00,
                'application_date' => Carbon::now()->subDays(15),
                'processed_by_id' => $officers->random()->id,
                'assessment_notes' => 'Under review - awaiting technical assessment',
                'conditions' => 'Pending approval',
            ],
            [
                'grant_code' => 'EGR-2024-005',
                'grant_type' => 'Women',
                'title' => 'Women Group Catering Business',
                'description' => 'Loan for women group to start catering services',
                'status' => 'Active',
                'priority' => 'Medium',
                'requires_repayment' => true,
                'beneficiary_id' => $applicants->random()->id,
                'ward_id' => $wards->random()->id,
                'beneficiary_age' => 32,
                'beneficiary_gender' => 'Female',
                'requested_amount' => 6000.00,
                'approved_amount' => 5500.00,
                'disbursed_amount' => 5500.00,
                'interest_rate' => 3.00,
                'repayment_period' => 12,
                'total_repayment' => 5830.00,
                'application_date' => Carbon::now()->subDays(50),
                'approval_date' => Carbon::now()->subDays(35),
                'disbursement_date' => Carbon::now()->subDays(30),
                'repayment_start_date' => Carbon::now()->subDays(25),
                'processed_by_id' => $officers->random()->id,
                'approved_by_id' => $officers->random()->id,
                'assessment_notes' => 'Strong women group with good leadership',
                'conditions' => 'Monthly repayments of K486 for 12 months',
            ],
        ];

        foreach ($grants as $grant) {
            EmpowermentGrant::firstOrCreate(
                ['grant_code' => $grant['grant_code']],
                $grant
            );
        }
    }
}
