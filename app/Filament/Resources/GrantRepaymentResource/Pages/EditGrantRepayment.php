<?php

namespace App\Filament\Resources\GrantRepaymentResource\Pages;

use App\Filament\Resources\GrantRepaymentResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditGrantRepayment extends EditRecord
{
    protected static string $resource = GrantRepaymentResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Store current values for audit trail
        session(['grant_repayment_old_values' => $this->record->toArray()]);
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Auto-calculate outstanding amount
        $scheduled = $data['scheduled_amount'] ?? 0;
        $paid = $data['paid_amount'] ?? 0;
        $penalty = $data['penalty_amount'] ?? 0;
        $interest = $data['interest_amount'] ?? 0;

        $data['outstanding_amount'] = max(0, $scheduled + $penalty + $interest - $paid);
        $data['total_due'] = $scheduled + $penalty + $interest;

        // Auto-update status based on payment
        if ($paid >= ($scheduled + $penalty + $interest)) {
            $data['status'] = 'Paid';
            if (!$data['paid_date']) {
                $data['paid_date'] = now();
            }
        } elseif ($paid > 0 && $data['status'] === 'Pending') {
            $data['status'] = 'Partial';
        }

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        return GrantRepaymentResource::handleRecordUpdate($record, $data);
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\ViewAction::make()
                ->visible(fn () => \checkGrantRepaymentReadPermission()),
            \Filament\Actions\DeleteAction::make()
                ->visible(fn () => \checkGrantRepaymentDeletePermission()),
        ];
    }
}
