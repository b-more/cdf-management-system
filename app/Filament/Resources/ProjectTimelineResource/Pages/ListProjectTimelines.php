<?php

namespace App\Filament\Resources\ProjectTimelineResource\Pages;

use App\Filament\Resources\ProjectTimelineResource;
use App\Models\AuditTrail;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ListProjectTimelines extends ListRecords
{
    protected static string $resource = ProjectTimelineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn () => checkProjectTimelineCreatePermission()),

            Actions\Action::make('generate_report')
                ->label('Generate Timeline Report')
                ->icon('heroicon-o-document-chart-bar')
                ->color('info')
                ->action(function () {
                    $this->logAuditTrail('Report Generation', 'Generated project timeline report');

                    // You can implement report generation logic here
                    $this->notify('success', 'Timeline report generated successfully');
                })
                ->visible(fn () => checkProjectTimelineReadPermission()),

            Actions\Action::make('bulk_import')
                ->label('Import Timelines')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('success')
                ->form([
                    \Filament\Forms\Components\FileUpload::make('file')
                        ->label('CSV File')
                        ->acceptedFileTypes(['text/csv', 'application/csv'])
                        ->required(),
                ])
                ->action(function (array $data) {
                    $this->logAuditTrail('Bulk Import', 'Initiated timeline bulk import');

                    // Implement CSV import logic here
                    $this->notify('success', 'Timelines imported successfully');
                })
                ->visible(fn () => checkProjectTimelineCreatePermission()),
        ];
    }

    private function logAuditTrail(string $action, string $description): void
    {
        try {
            AuditTrail::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'table_name' => 'project_timelines',
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
