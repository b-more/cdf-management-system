<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\AuditTrail;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

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
                    $this->logAuditTrail('View', 'Viewed user profile: ' . $this->record->name);
                }),

            Actions\DeleteAction::make()
                ->visible(fn () =>
                    checkUserDeletePermission() &&
                    $this->record->id !== Auth::id() &&
                    $this->record->role?->name !== 'Super Admin'
                )
                ->before(function () {
                    $this->logAuditTrail('Delete', 'Deleted user account: ' . $this->record->name);
                }),

            Actions\Action::make('user_activity')
                ->label('View Activity')
                ->icon('heroicon-o-clock')
                ->color('gray')
                ->modalHeading('User Activity History')
                ->modalContent(function () {
                    $auditLogs = AuditTrail::where('user_id', $this->record->id)
                        ->orWhere(function ($query) {
                            $query->where('table_name', 'users')
                                  ->where('record_id', $this->record->id);
                        })
                        ->with('user')
                        ->orderBy('created_at', 'desc')
                        ->limit(50)
                        ->get();

                    $html = '<div class="space-y-3">';
                    foreach ($auditLogs as $log) {
                        $html .= '<div class="border-l-4 border-blue-400 pl-4 py-2">';
                        $html .= '<div class="flex justify-between items-start">';
                        $html .= '<div>';
                        $html .= '<p class="font-medium text-gray-900">' . $log->description . '</p>';
                        $html .= '<p class="text-sm text-gray-500">Action: ' . $log->action . '</p>';
                        $html .= '</div>';
                        $html .= '<div class="text-right">';
                        $html .= '<p class="text-sm text-gray-500">' . $log->created_at->format('M j, Y g:i A') . '</p>';
                        $html .= '<p class="text-xs text-gray-400">by ' . ($log->user->name ?? 'System') . '</p>';
                        $html .= '</div>';
                        $html .= '</div>';
                        $html .= '</div>';
                    }
                    $html .= '</div>';

                    return new \Illuminate\Support\HtmlString($html);
                })
                ->modalActions([
                    Actions\Action::make('close')->label('Close')->color('gray')->close(),
                ])
                ->after(function () {
                    $this->logAuditTrail('Activity View', 'Viewed activity history for user: ' . $this->record->name);
                }),

            Actions\Action::make('impersonate')
                ->label('Login as User')
                ->icon('heroicon-o-user-circle')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Login as User')
                ->modalDescription('This will log you in as this user. You will be able to see what they see.')
                ->action(function () {
                    if (Auth::user()?->role?->name === 'Super Admin' && $this->record->is_active) {
                        $this->logAuditTrail('Impersonate', 'Started impersonating user: ' . $this->record->name);

                        // Store original user ID in session
                        session(['impersonating_from' => Auth::id()]);

                        // Login as the target user
                        Auth::login($this->record);

                        $this->redirect('/admin');
                    }
                })
                ->visible(fn () =>
                    Auth::user()?->role?->name === 'Super Admin' &&
                    $this->record->is_active &&
                    $this->record->id !== Auth::id()
                ),
        ];
    }

    protected function afterSave(): void
    {
        $this->logAuditTrail('Update',
            'Updated user profile: ' . $this->record->name,
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
                'table_name' => 'users',
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
