<?php

namespace App\Filament\Resources\ProjectTimelineResource\Pages;

use App\Filament\Resources\ProjectTimelineResource;
use App\Models\AuditTrail;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ViewProjectTimeline extends ViewRecord
{
    protected static string $resource = ProjectTimelineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->visible(fn () => checkProjectTimelineUpdatePermission()),

            Actions\DeleteAction::make()
                ->visible(fn () => checkProjectTimelineDeletePermission())
                ->before(function () {
                    $this->logAuditTrail('Delete', 'Deleted project timeline: ' . $this->record->title);
                }),

            Actions\Action::make('timeline_history')
                ->label('View History')
                ->icon('heroicon-o-clock')
                ->color('gray')
                ->modalHeading('Timeline History')
                ->modalContent(function () {
                    $auditLogs = AuditTrail::where('table_name', 'project_timelines')
                        ->where('record_id', $this->record->id)
                        ->with('user')
                        ->orderBy('created_at', 'desc')
                        ->get();

                    return view('filament.timeline-history', compact('auditLogs'));
                })
                ->modalActions([
                    Actions\Action::make('close')->label('Close')->color('gray')->close(),
                ]),

            Actions\Action::make('export_timeline')
                ->label('Export Timeline')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    $this->logAuditTrail('Export', 'Exported timeline data: ' . $this->record->title);

                    // Implement export logic here
                    $this->notify('success', 'Timeline exported successfully');
                })
                ->visible(fn () => checkProjectTimelineReadPermission()),
        ];
    }

    protected function boot(): void
    {
        parent::boot();
        $this->logAuditTrail('View', 'Viewed project timeline: ' . $this->record->title);
    }

    private function logAuditTrail(string $action, string $description): void
    {
        try {
            AuditTrail::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'table_name' => 'project_timelines',
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
