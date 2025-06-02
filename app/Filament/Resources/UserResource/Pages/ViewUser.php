<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\AuditTrail;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->visible(fn () =>
                    checkUserUpdatePermission() &&
                    ($this->record->role?->name !== 'Super Admin' || Auth::user()?->role?->name === 'Super Admin')
                ),

            Actions\DeleteAction::make()
                ->visible(fn () =>
                    checkUserDeletePermission() &&
                    $this->record->id !== Auth::id() &&
                    $this->record->role?->name !== 'Super Admin'
                )
                ->before(function () {
                    $this->logAuditTrail('Delete', 'Deleted user account: ' . $this->record->name);
                }),
        ];
    }

    protected function boot(): void
    {
        parent::boot();
        $this->logAuditTrail('View', 'Viewed user profile: ' . $this->record->name);
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
                'new_values' => null,
                'description' => $description,
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to log audit trail: ' . $e->getMessage());
        }
    }
}
