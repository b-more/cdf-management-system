<?php

namespace App\Filament\Resources\EmpowermentResource\Pages;

use App\Filament\Resources\EmpowermentResource;
use App\Models\AuditTrail;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class EditEmpowerment extends EditRecord
{
    protected static string $resource = EmpowermentResource::class;

    protected array $originalData = [];

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Store current values for audit trail
        $this->originalData = $this->record->toArray();
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->after(function () {
                    $this->logAuditTrail('View', 'Viewed empowerment program: ' . $this->record->title);
                }),

            Actions\DeleteAction::make()
                ->before(function () {
                    $this->logAuditTrail('Delete', 'Deleted empowerment program: ' . $this->record->title, $this->record->toArray());
                }),

            Actions\Action::make('approve_program')
                ->label('Approve Program')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Approve Empowerment Program')
                ->modalDescription('This will approve the program and allow it to start.')
                ->action(function () {
                    $oldData = $this->record->toArray();
                    $this->record->update([
                        'status' => 'Approved',
                        'approved_by_id' => Auth::id(),
                    ]);

                    $this->logAuditTrail('Approve',
                        'Approved empowerment program: ' . $this->record->title,
                        $oldData,
                        $this->record->fresh()->toArray()
                    );

                    $this->notify('success', 'Program approved successfully!');
                })
                ->visible(fn () =>
                    $this->record->status === 'Planning' &&
                    checkEmpowermentUpdatePermission()
                ),

            Actions\Action::make('start_program')
                ->label('Start Program')
                ->icon('heroicon-o-play')
                ->color('primary')
                ->requiresConfirmation()
                ->action(function () {
                    $oldData = $this->record->toArray();
                    $this->record->update(['status' => 'Active']);

                    $this->logAuditTrail('Start Program',
                        'Started empowerment program: ' . $this->record->title,
                        $oldData,
                        $this->record->fresh()->toArray()
                    );

                    $this->notify('success', 'Program started successfully!');
                })
                ->visible(fn () =>
                    $this->record->status === 'Approved' &&
                    checkEmpowermentUpdatePermission()
                ),
        ];
    }

    protected function afterSave(): void
    {
        $this->logAuditTrail('Update',
            'Updated empowerment program: ' . $this->record->title,
            $this->originalData,
            $this->record->fresh()->toArray()
        );
    }

    private function logAuditTrail(string $action, string $description, ?array $oldValues = null, ?array $newValues = null): void
    {
        try {
            AuditTrail::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'table_name' => 'empowerments',
                'record_id' => $this->record->id,
                'old_values' => $oldValues ? json_encode($oldValues) : null,
                'new_values' => $newValues ? json_encode($newValues) : null,
                'description' => $description,
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to log audit trail: ' . $e->getMessage());
        }
    }
}
