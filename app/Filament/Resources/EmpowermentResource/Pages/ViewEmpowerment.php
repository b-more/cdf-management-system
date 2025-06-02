<?php

namespace App\Filament\Resources\EmpowermentResource\Pages;

use App\Filament\Resources\EmpowermentResource;
use App\Models\AuditTrail;
use App\Services\SmsService;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ViewEmpowerment extends ViewRecord
{
    protected static string $resource = EmpowermentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->visible(fn () => checkEmpowermentUpdatePermission()),

            Actions\DeleteAction::make()
                ->visible(fn () => checkEmpowermentDeletePermission())
                ->before(function () {
                    $this->logAuditTrail('Delete', 'Deleted empowerment program: ' . $this->record->title);
                }),

            Actions\Action::make('send_invitations')
                ->label('Send Invitations')
                ->icon('heroicon-o-envelope')
                ->color('warning')
                ->form([
                    Forms\Components\Textarea::make('message')
                        ->label('Invitation Message')
                        ->required()
                        ->default('You are invited to participate in our empowerment program. Please register before the deadline.'),

                    Forms\Components\Toggle::make('send_to_ward_users')
                        ->label('Send to all ward users')
                        ->default(true),
                ])
                ->action(function (array $data) {
                    $users = collect();

                    if ($data['send_to_ward_users']) {
                        $users = \App\Models\User::where('ward_id', $this->record->ward_id)
                                    ->whereNotNull('phone')
                                    ->get();
                    }

                    $smsService = new SmsService();
                    $count = 0;

                    foreach ($users as $user) {
                        $message = "EMPOWERMENT: {$this->record->title}. {$data['message']} Code: {$this->record->program_code}";
                        $result = $smsService->sendSms($user->phone, $message);
                        if ($result['success']) {
                            $count++;
                        }
                    }

                    $this->logAuditTrail('Send Invitations',
                        "Sent {$count} invitations for program: " . $this->record->title
                    );

                    $this->notify('success', "Sent {$count} SMS invitations!");
                })
                ->visible(fn () =>
                    in_array($this->record->status, ['Approved', 'Active']) &&
                    checkEmpowermentUpdatePermission()
                ),

            Actions\Action::make('program_history')
                ->label('View History')
                ->icon('heroicon-o-clock')
                ->color('gray')
                ->modalHeading('Program History')
                ->modalContent(function () {
                    $auditLogs = AuditTrail::where('table_name', 'empowerments')
                        ->where('record_id', $this->record->id)
                        ->with('user')
                        ->orderBy('created_at', 'desc')
                        ->get();

                    return view('filament.empowerment-history', compact('auditLogs'));
                })
                ->modalActions([
                    Actions\Action::make('close')->label('Close')->color('gray')->close(),
                ]),

            Actions\Action::make('export_data')
                ->label('Export Data')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    $this->logAuditTrail('Export', 'Exported empowerment program data: ' . $this->record->title);
                    $this->notify('success', 'Program data exported successfully!');
                })
                ->visible(fn () => checkEmpowermentReadPermission()),
        ];
    }

    public function mount(int | string $record): void
    {
        parent::mount($record);

        // Log view activity
        $this->logAuditTrail('View', 'Viewed empowerment program: ' . $this->record->title);
    }

    private function logAuditTrail(string $action, string $description): void
    {
        try {
            AuditTrail::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'table_name' => 'empowerments',
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
