<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GrantRepayment;
use App\Models\EmpowermentGrant;
use App\Models\User;
use Carbon\Carbon;

class GrantRepaymentSeeder extends Seeder
{
    public function run(): void
    {
        // Get grants that require repayment
        $repayableGrants = EmpowermentGrant::where('requires_repayment', true)->get();
        $officers = User::whereHas('role', fn($q) => $q->whereIn('name', ['Officer', 'CDFC', 'Admin']))->get();

        foreach ($repayableGrants as $grant) {
            $monthlyAmount = $grant->approved_amount / ($grant->repayment_period ?? 12);
            $startDate = $grant->repayment_start_date ?? Carbon::now()->subMonths(2);

            // Create repayment schedule
            for ($i = 1; $i <= ($grant->repayment_period ?? 12); $i++) {
                $dueDate = $startDate->copy()->addMonths($i - 1);
                $isPastDue = $dueDate < Carbon::now();
                $isRecent = $dueDate->diffInDays(Carbon::now()) <= 30;

                // Determine payment status and amounts
                $status = 'Pending';
                $paidAmount = 0;
                $paidDate = null;

                if ($isPastDue) {
                    if ($i <= 2) {
                        // First two payments are usually paid
                        $status = 'Paid';
                        $paidAmount = $monthlyAmount;
                        $paidDate = $dueDate->copy()->addDays(rand(0, 5));
                    } elseif ($i == 3 && rand(0, 1)) {
                        // Third payment might be partial
                        $status = 'Partial';
                        $paidAmount = $monthlyAmount * 0.6;
                        $paidDate = $dueDate->copy()->addDays(rand(0, 10));
                    } elseif ($i > 3) {
                        // Later payments might be overdue
                        $status = rand(0, 2) == 0 ? 'Overdue' : 'Pending';
                    }
                } elseif ($isRecent && rand(0, 1)) {
                    // Recent due dates might be paid early
                    $status = 'Paid';
                    $paidAmount = $monthlyAmount;
                    $paidDate = $dueDate->copy()->subDays(rand(1, 3));
                }

                // Calculate penalty for overdue payments
                $penaltyAmount = 0;
                if ($status === 'Overdue') {
                    $daysOverdue = Carbon::now()->diffInDays($dueDate);
                    $penaltyAmount = ($monthlyAmount * 0.02) * ($daysOverdue / 30); // 2% per month
                }

                $repayment = [
                    'repayment_code' => 'REP-' . $grant->grant_code . '-' . str_pad($i, 2, '0', STR_PAD_LEFT),
                    'empowerment_grant_id' => $grant->id,
                    'description' => "Monthly repayment installment #{$i} for {$grant->title}",
                    'scheduled_amount' => $monthlyAmount,
                    'paid_amount' => $paidAmount,
                    'outstanding_amount' => max(0, $monthlyAmount + $penaltyAmount - $paidAmount),
                    'penalty_amount' => $penaltyAmount,
                    'interest_amount' => 0, // Simple interest already included in total
                    'total_due' => $monthlyAmount + $penaltyAmount,
                    'due_date' => $dueDate,
                    'paid_date' => $paidDate,
                    'installment_number' => $i,
                    'status' => $status,
                    'payment_method' => $paidAmount > 0 ? ['Cash', 'Mobile_Money', 'Bank_Transfer'][rand(0, 2)] : null,
                    'transaction_reference' => $paidAmount > 0 ? 'TXN' . rand(100000, 999999) : null,
                    'payment_notes' => $paidAmount > 0 ? 'Payment received on time' : null,
                    'grace_period_days' => 5,
                    'penalty_rate' => 2.00,
                    'recorded_by_id' => $officers->random()->id,
                    'approved_by_id' => $paidAmount > 0 ? $officers->random()->id : null,
                    'remarks' => $status === 'Overdue' ? 'Payment overdue - follow up required' : null,
                ];

                GrantRepayment::firstOrCreate(
                    ['repayment_code' => $repayment['repayment_code']],
                    $repayment
                );
            }
        }
    }
}
