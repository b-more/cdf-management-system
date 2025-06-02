<?php

namespace App\Filament\Resources\EmpowermentResource\Pages;

use App\Filament\Resources\EmpowermentResource;
use App\Models\AuditTrail;
use App\Services\SmsService;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ListEmpowerments extends ListRecords
{
    protected static string $resource = EmpowermentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn () => checkEmpowermentCreatePermission()),

            Actions\Action::make('bulk_invite')
                ->label('Send Bulk Invitations')
                ->icon('heroicon-o-envelope')
                ->color('warning')
                ->form([
                    Forms\Components\Select::make('program_ids')
                        ->label('Select Programs')
                        ->multiple()
                        ->options(\App\Models\Empowerment::where('status', 'Approved')->pluck('title', 'id'))
                        ->required(),

                    Forms\Components\Textarea::make('message')
                        ->label('Invitation Message')
                        ->required()
                        ->default('You are invited to participate in our empowerment program. Please register before the deadline.'),
                ])
                ->action(function (array $data) {
                    $programs = \App\Models\Empowerment::whereIn('id', $data['program_ids'])->get();
                    $smsService = new SmsService();
                    $totalSent = 0;

                    foreach ($programs as $program) {
                        $users = \App\Models\User::where('ward_id', $program->ward_id)
                                    ->whereNotNull('phone')
                                    ->get();

                        foreach ($users as $user) {
                            $message = "EMPOWERMENT: {$program->title}. {$data['message']} Code: {$program->program_code}";
                            $result = $smsService->sendSms($user->phone, $message);
                            if ($result['success']) {
                                $totalSent++;
                            }
                        }

                        $this->logAuditTrail('Bulk Invitation',
                            'Sent bulk invitations for program: ' . $program->title,
                            $program->id
                        );
                    }

                    $this->notify('success', "Sent {$totalSent} SMS invitations!");
                })
                ->visible(fn () => checkEmpowermentUpdatePermission()),

            Actions\Action::make('generate_report')
                ->label('Generate Report')
                ->icon('heroicon-o-document-chart-bar')
                ->color('info')
                ->action(function () {
                    $this->logAuditTrail('Report Generation', 'Generated empowerment programs report');
                    $this->notify('success', 'Report generated successfully!');
                })
                ->visible(fn () => checkEmpowermentReadPermission()),
        ];
    }

    private function logAuditTrail(string $action, string $description, ?int $recordId = null): void
    {
        try {
            AuditTrail::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'table_name' => 'empowerments',
                'record_id' => $recordId,
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
