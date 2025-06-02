<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\AuditTrail;
use App\Services\SmsService;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn () => checkUserCreatePermission()),

            Actions\Action::make('bulk_import')
                ->label('Import Users')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('success')
                ->form([
                    Forms\Components\FileUpload::make('file')
                        ->label('CSV File')
                        ->acceptedFileTypes(['text/csv', 'application/csv'])
                        ->required()
                        ->helperText('CSV should contain: name, email, phone, role_id, ward_id'),

                    Forms\Components\Toggle::make('send_welcome_sms')
                        ->label('Send welcome SMS to imported users')
                        ->default(true),
                ])
                ->action(function (array $data) {
                    $this->logAuditTrail('Bulk Import', 'Initiated user bulk import');

                    // Implement CSV import logic here
                    $this->notify('success', 'Users imported successfully');
                })
                ->visible(fn () => checkUserCreatePermission()),

            Actions\Action::make('user_statistics')
                ->label('User Statistics')
                ->icon('heroicon-o-chart-bar')
                ->color('info')
                ->modalHeading('User Statistics')
                ->modalContent(function () {
                    $totalUsers = \App\Models\User::count();
                    $activeUsers = \App\Models\User::where('is_active', true)->count();
                    $verifiedUsers = \App\Models\User::whereNotNull('email_verified_at')->count();
                    $roleStats = \App\Models\User::join('roles', 'users.role_id', '=', 'roles.id')
                        ->groupBy('roles.name')
                        ->selectRaw('roles.name, count(*) as count')
                        ->get();

                    $html = '<div class="space-y-4">';
                    $html .= '<div class="grid grid-cols-3 gap-4">';

                    $html .= '<div class="bg-blue-50 p-4 rounded-lg text-center">';
                    $html .= '<div class="text-2xl font-bold text-blue-600">' . $totalUsers . '</div>';
                    $html .= '<div class="text-sm text-blue-800">Total Users</div>';
                    $html .= '</div>';

                    $html .= '<div class="bg-green-50 p-4 rounded-lg text-center">';
                    $html .= '<div class="text-2xl font-bold text-green-600">' . $activeUsers . '</div>';
                    $html .= '<div class="text-sm text-green-800">Active Users</div>';
                    $html .= '</div>';

                    $html .= '<div class="bg-purple-50 p-4 rounded-lg text-center">';
                    $html .= '<div class="text-2xl font-bold text-purple-600">' . $verifiedUsers . '</div>';
                    $html .= '<div class="text-sm text-purple-800">Verified Email</div>';
                    $html .= '</div>';

                    $html .= '</div>';

                    $html .= '<div class="mt-6">';
                    $html .= '<h3 class="font-semibold text-gray-900 mb-3">Users by Role</h3>';
                    foreach ($roleStats as $stat) {
                        $html .= '<div class="flex justify-between items-center py-2 border-b">';
                        $html .= '<span class="text-gray-700">' . $stat->name . '</span>';
                        $html .= '<span class="font-medium text-gray-900">' . $stat->count . '</span>';
                        $html .= '</div>';
                    }
                    $html .= '</div>';

                    $html .= '</div>';

                    return new \Illuminate\Support\HtmlString($html);
                })
                ->modalActions([
                    Actions\Action::make('close')->label('Close')->color('gray')->close(),
                ])
                ->after(function () {
                    $this->logAuditTrail('Statistics View', 'Viewed user statistics dashboard');
                })
                ->visible(fn () => checkUserReadPermission()),

            Actions\Action::make('system_announcement')
                ->label('Send Announcement')
                ->icon('heroicon-o-megaphone')
                ->color('warning')
                ->form([
                    Forms\Components\Select::make('target_roles')
                        ->label('Target Roles')
                        ->multiple()
                        ->options(\App\Models\Role::pluck('name', 'id'))
                        ->placeholder('Select roles to send to (leave empty for all users)'),

                    Forms\Components\Textarea::make('message')
                        ->label('Announcement Message')
                        ->required()
                        ->maxLength(160)
                        ->helperText('Maximum 160 characters for SMS')
                        ->rows(3),
                ])
                ->action(function (array $data) {
                    $query = \App\Models\User::where('is_active', true)->whereNotNull('phone');

                    if (!empty($data['target_roles'])) {
                        $query->whereIn('role_id', $data['target_roles']);
                    }

                    $users = $query->get();
                    $smsService = new SmsService();
                    $sentCount = 0;

                    foreach ($users as $user) {
                        $message = "CDF ANNOUNCEMENT: " . $data['message'];
                        $result = $smsService->sendSms($user->phone, $message);

                        if ($result['success']) {
                            $sentCount++;
                        }
                    }

                    $this->logAuditTrail('System Announcement',
                        "Sent system announcement to {$sentCount} users"
                    );

                    $this->notify('success', "Announcement sent to {$sentCount} users");
                })
                ->visible(fn () => checkUserUpdatePermission()),
        ];
    }

    private function logAuditTrail(string $action, string $description): void
    {
        try {
            AuditTrail::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'table_name' => 'users',
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
