<?php

namespace App\Filament\Resources\ProjectTimelineResource\Pages;

use App\Filament\Resources\ProjectTimelineResource;
use App\Models\AuditTrail;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class EditProjectTimeline extends EditRecord
{
    protected static string $resource = ProjectTimelineResource::class;

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
                    $this->logAuditTrail('View', 'Viewed project timeline: ' . $this->record->title);
                }),

            Actions\DeleteAction::make()
                ->before(function () {
                    $this->logAuditTrail('Delete', 'Deleted project timeline: ' . $this->record->title);
                }),

            Actions\Action::make('mark_critical')
                ->label('Toggle Critical Path')
                ->icon('heroicon-o-exclamation-triangle')
                ->color('warning')
                ->action(function () {
                    $oldValue = $this->record->is_critical_path;
                    $this->record->update([
                        'is_critical_path' => !$this->record->is_critical_path
                    ]);

                    $action = $this->record->is_critical_path ? 'Added to' : 'Removed from';
                    $this->logAuditTrail('Critical Path Update',
                        $action . ' critical path: ' . $this->record->title
                    );
                })
                ->visible(fn () => checkProjectTimelineUpdatePermission()),
        ];
    }

    protected function afterSave(): void
    {
        $this->logAuditTrail('Update',
            'Updated project timeline: ' . $this->record->title,
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
                'table_name' => 'project_timelines',
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

