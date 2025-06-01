<?php

namespace App\Filament\Resources\GrantRepaymentResource\Widgets;

use App\Models\GrantRepayment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RepaymentStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        // Check if GrantRepayment table exists to prevent errors during migration
        if (!\Schema::hasTable('grant_repayments')) {
            return [
                Stat::make('Total Repayments', '0')
                    ->description('No data available')
                    ->color('secondary'),
            ];
        }

        try {
            $totalRepayments = GrantRepayment::count();
            $paidRepayments = GrantRepayment::where('status', 'Paid')->count();
            $overdueRepayments = GrantRepayment::where('status', 'Overdue')->count();
            $pendingRepayments = GrantRepayment::where('status', 'Pending')->count();

            // Calculate total outstanding amount safely
            $totalOutstanding = GrantRepayment::whereNotIn('status', ['Paid', 'Waived'])
                ->get()
                ->sum(function ($repayment) {
                    $scheduled = $repayment->scheduled_amount ?? 0;
                    $penalty = $repayment->penalty_amount ?? 0;
                    $interest = $repayment->interest_amount ?? 0;
                    $paid = $repayment->paid_amount ?? 0;

                    return max(0, $scheduled + $penalty + $interest - $paid);
                });

            // Calculate collection rate
            $collectionRate = $totalRepayments > 0 ? round(($paidRepayments / $totalRepayments) * 100, 1) : 0;

            return [
                Stat::make('Total Repayments', number_format($totalRepayments))
                    ->description('All repayment records')
                    ->descriptionIcon('heroicon-m-document-text')
                    ->color('primary'),

                Stat::make('Collection Rate', $collectionRate . '%')
                    ->description("{$paidRepayments} of {$totalRepayments} paid")
                    ->descriptionIcon('heroicon-m-check-circle')
                    ->color($collectionRate >= 80 ? 'success' : ($collectionRate >= 60 ? 'warning' : 'danger')),

                Stat::make('Overdue Payments', number_format($overdueRepayments))
                    ->description('Requiring immediate attention')
                    ->descriptionIcon('heroicon-m-exclamation-triangle')
                    ->color($overdueRepayments > 0 ? 'danger' : 'success'),

                Stat::make('Outstanding Amount', 'K ' . number_format($totalOutstanding, 2))
                    ->description('Total amount pending')
                    ->descriptionIcon('heroicon-m-banknotes')
                    ->color($totalOutstanding > 0 ? 'warning' : 'success'),

                Stat::make('Pending Payments', number_format($pendingRepayments))
                    ->description('Due soon')
                    ->descriptionIcon('heroicon-m-clock')
                    ->color('info'),

                Stat::make('This Month Due', $this->getThisMonthDue())
                    ->description('Due in current month')
                    ->descriptionIcon('heroicon-m-calendar-days')
                    ->color('warning'),
            ];

        } catch (\Exception $e) {
            // Return safe stats if there's any error
            return [
                Stat::make('Total Repayments', '0')
                    ->description('Error loading data')
                    ->color('danger'),
            ];
        }
    }

    private function getThisMonthDue(): string
    {
        try {
            $thisMonthDue = GrantRepayment::whereMonth('due_date', now()->month)
                ->whereYear('due_date', now()->year)
                ->whereNotIn('status', ['Paid', 'Waived'])
                ->count();

            return number_format($thisMonthDue);
        } catch (\Exception $e) {
            return '0';
        }
    }

    // Optional: Refresh widget every 30 seconds
    protected static ?string $pollingInterval = '30s';

    // Optional: Make widget half width
    protected int | string | array $columnSpan = 'full';
}
