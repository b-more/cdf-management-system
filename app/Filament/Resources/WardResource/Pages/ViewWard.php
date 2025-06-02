<?php

namespace App\Filament\Resources\WardResource\Pages;

use App\Filament\Resources\WardResource;
use App\Models\AuditTrail;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ViewWard extends ViewRecord
{
    protected static string $resource = WardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->visible(fn () => checkWardUpdatePermission()),

            Actions\DeleteAction::make()
                ->visible(fn () => checkWardDeletePermission())
                ->before(function () {
                    $hasUsers = $this->record->users()->exists();
                    $hasProjects = $this->record->communityProjects()->exists() || $this->record->disasterProjects()->exists();

                    if ($hasUsers || $hasProjects) {
                        $this->notify('danger', 'Cannot delete ward with associated users or projects.');
                        return false;
                    }

                    $this->logAuditTrail('Delete', 'Deleted ward: ' . $this->record->name);
                }),
        ];
    }

    protected function boot(): void
    {
        parent::boot();
        $this->logAuditTrail('View', 'Viewed ward: ' . $this->record->name);
    }

    private function logAuditTrail(string $action, string $description): void
    {
        try {
            AuditTrail::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'table_name' => 'wards',
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
