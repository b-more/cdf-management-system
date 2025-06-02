<?php

namespace App\Filament\Resources\WardResource\Pages;

use App\Filament\Resources\WardResource;
use App\Models\AuditTrail;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ListWards extends ListRecords
{
    protected static string $resource = WardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn () => checkWardCreatePermission()),

            Actions\Action::make('import_wards')
                ->label('Import Wards')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('success')
                ->form([
                    \Filament\Forms\Components\FileUpload::make('file')
                        ->label('CSV File')
                        ->acceptedFileTypes(['text/csv', 'application/csv'])
                        ->required(),
                ])
                ->action(function (array $data) {
                    $this->logAuditTrail('Bulk Import', 'Initiated ward bulk import');

                    // Implement CSV import logic here
                    $this->notify('success', 'Wards imported successfully');
                })
                ->visible(fn () => checkWardCreatePermission()),

            Actions\Action::make('export_wards')
                ->label('Export All Wards')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('info')
                ->action(function () {
                    $this->logAuditTrail('Export All', 'Exported all wards data');

                    // Implement export logic here
                    $this->notify('success', 'Wards exported successfully');
                })
                ->visible(fn () => checkWardReadPermission()),
        ];
    }

    private function logAuditTrail(string $action, string $description): void
    {
        try {
            AuditTrail::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'table_name' => 'wards',
                'record_id' => null,
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
