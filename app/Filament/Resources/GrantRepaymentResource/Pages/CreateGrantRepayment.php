<?php

namespace App\Filament\Resources\GrantRepaymentResource\Pages;

use App\Filament\Resources\GrantRepaymentResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateGrantRepayment extends CreateRecord
{
    protected static string $resource = GrantRepaymentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Auto-generate repayment code if not provided
        if (empty($data['repayment_code'])) {
            $data['repayment_code'] = 'REP-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        }

        // Auto-calculate outstanding amount
        $scheduled = $data['scheduled_amount'] ?? 0;
        $paid = $data['paid_amount'] ?? 0;
        $penalty = $data['penalty_amount'] ?? 0;
        $interest = $data['interest_amount'] ?? 0;

        $data['outstanding_amount'] = max(0, $scheduled + $penalty + $interest - $paid);
        $data['total_due'] = $scheduled + $penalty + $interest;

        // Auto-set status based on payment
        if ($paid >= ($scheduled + $penalty + $interest)) {
            $data['status'] = 'Paid';
            $data['paid_date'] = now();
        } elseif ($paid > 0) {
            $data['status'] = 'Partial';
        } elseif (isset($data['due_date']) && $data['due_date'] < now()->toDateString()) {
            $data['status'] = 'Overdue';
        }

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        return GrantRepaymentResource::handleRecordCreation($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
