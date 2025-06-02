<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\AuditTrail;
use App\Services\SmsService;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $this->logAuditTrail('Create', 'Created user account: ' . $this->record->name);

        // Send welcome SMS if phone number is provided
        if ($this->record->phone) {
            $smsService = new SmsService();
            $message = "Welcome to CDF Management System! Your account has been created. Username: {$this->record->email}. Please contact admin for password.";
            $result = $smsService->sendSms($this->record->phone, $message);

            if ($result['success']) {
                $this->logAuditTrail('Welcome SMS', 'Sent welcome SMS to new user: ' . $this->record->name);
            }
        }
    }

    private function logAuditTrail(string $action, string $description): void
    {
        try {
            AuditTrail::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'table_name' => 'users',
                'record_id' => $this->record->id,
                'old_values' => null,
                'new_values' => json_encode($this->record->toArray()),
                'description' => $description,
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to log audit trail: ' . $e->getMessage());
        }
    }
}
