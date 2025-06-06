<?php

namespace App\Filament\Resources\WardResource\Pages;

use App\Filament\Resources\WardResource;
use App\Models\AuditTrail;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class EditWard extends EditRecord
{
    protected static string $resource = WardResource::class;

    protected array $originalData = [];

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $this->originalData = $this->record->toArray();
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->after(function () {
                    $this->logAuditTrail('View', 'Viewed ward: ' . $this->record->name);
                }),

            Actions\DeleteAction::make()
                ->before(function () {
                    // Check for related records
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

    protected function afterSave(): void
    {
        $this->logAuditTrail('Update',
            'Updated ward: ' . $this->record->name,
            $this->originalData,
            $this->record->fresh()->toArray()
        );
    }

    private function logAuditTrail(string $action, string $description, array $oldValues = [], array $newValues = []): void
    {
        try {
            AuditTrail::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'table_name' => 'wards',
                'record_id' => $this->record->id,
                'old_values' => !empty($oldValues) ? json_encode($oldValues) : null,
                'new_values' => !empty($newValues) ? json_encode($newValues) : null,
                'description' => $description,
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to log audit trail: ' . $e->getMessage());
        }
    }
}
