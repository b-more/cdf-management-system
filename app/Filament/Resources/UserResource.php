<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use App\Models\Role;
use App\Models\Ward;
use App\Models\Permission;
use App\Services\SmsService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_active', true)->count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'success';
    }

    public static function shouldRegisterNavigation(): bool
    {
        // Use the global permission function from PermissionHelper.php
        return checkUserReadPermission();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 1, 'lg' => 3])->schema([

                // Main User Information Section
                Section::make('User Profile')
                    ->description('Enter user\'s basic information and profile details.')
                    ->icon('heroicon-o-user-circle')
                    ->schema([
                        Grid::make(2)->schema([
                            Forms\Components\FileUpload::make('image')
                                ->label('Profile Photo')
                                ->image()
                                ->imageEditor()
                                ->directory('user-photos')
                                ->visibility('public')
                                ->columnSpanFull()
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif'])
                                ->maxSize(2048)
                                ->helperText('Upload a profile photo (max 2MB). JPEG, PNG, or GIF formats only.'),

                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->label('Full Name')
                                ->placeholder('Enter full name')
                                ->autocomplete('name'),

                            Forms\Components\TextInput::make('email')
                                ->email()
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(255)
                                ->placeholder('user@example.com')
                                ->autocomplete('email'),

                            Forms\Components\TextInput::make('phone')
                                ->tel()
                                ->label('Phone Number')
                                ->placeholder('260971234567')
                                ->maxLength(20)
                                ->helperText('Phone number for SMS notifications')
                                ->rule('regex:/^[0-9+\-\s\(\)]+$/'),
                        ]),
                    ])->columnSpan(2),

                // Account Settings Section
                Section::make('Account Settings')
                    ->description('Configure user\'s role, permissions, and account status.')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        Forms\Components\Select::make('role_id')
                            ->relationship('role', 'name', function ($query) {
                                // Only Super Admin can create other Super Admins
                                if (auth()->user() && auth()->user()->role_id !== 1) {
                                    return $query->where('name', '!=', 'Super Admin');
                                }
                                return $query->where('is_deleted', false);
                            })
                            ->required()
                            ->preload()
                            ->searchable()
                            ->label('User Role')
                            ->helperText('Select the user\'s role in the CDF system')
                            ->reactive()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                // Auto-select appropriate ward for role-based users
                                $role = Role::find($state);
                                if ($role && in_array($role->name, ['WDC', 'CDFC', 'Applicant'])) {
                                    // Keep ward selection available for these roles
                                } else {
                                    $set('ward_id', null);
                                }
                            }),

                        Forms\Components\Select::make('ward_id')
                            ->relationship('ward', 'name')
                            ->preload()
                            ->searchable()
                            ->label('Assigned Ward')
                            ->helperText('Select ward for WDC, CDFC, or Applicant roles')
                            ->visible(function (Forms\Get $get) {
                                $roleId = $get('role_id');
                                if (!$roleId) return false;
                                $role = Role::find($roleId);
                                return $role && in_array($role->name, ['WDC', 'CDFC', 'Applicant']);
                            }),

                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => $state ? Hash::make($state) : null)
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn ($livewire) => $livewire instanceof Pages\CreateUser)
                            ->maxLength(255)
                            ->label('Password')
                            ->helperText('Leave blank to keep current password')
                            ->autocomplete('new-password'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active Status')
                            ->helperText('Inactive users cannot log in to the system')
                            ->default(true)
                            ->disabled(function ($record) {
                                // Prevent disabling Super Admin accounts unless user is also Super Admin
                                return $record && $record->role_id === 1 && auth()->user()->role_id !== 1;
                            }),

                        Forms\Components\DateTimePicker::make('email_verified_at')
                            ->label('Email Verified At')
                            ->helperText('When the user verified their email address')
                            ->visible(fn ($record) => $record !== null),
                    ])->columnSpan(1),
            ]),

            // Additional Information Section (for existing users)
            Section::make('User Statistics')
                ->description('User activity and statistics in the CDF system.')
                ->icon('heroicon-o-chart-bar')
                ->schema([
                    Grid::make(4)->schema([
                        Forms\Components\Placeholder::make('projects_count')
                            ->label('Projects Submitted')
                            ->content(function ($record) {
                                if (!$record) return '0';
                                return $record->communityProjects()->count() + $record->disasterProjects()->count();
                            }),

                        Forms\Components\Placeholder::make('approved_projects')
                            ->label('Approved Projects')
                            ->content(function ($record) {
                                if (!$record) return '0';
                                $community = $record->communityProjects()->where('status', 'cdfc_approved')->count();
                                $disaster = $record->disasterProjects()->where('status', 'cdfc_approved')->count();
                                return $community + $disaster;
                            }),

                        Forms\Components\Placeholder::make('grants_received')
                            ->label('Grants Received')
                            ->content(function ($record) {
                                if (!$record) return '0';
                                return $record->empowermentGrants()->count();
                            }),

                        Forms\Components\Placeholder::make('last_login')
                            ->label('Last Login')
                            ->content(function ($record) {
                                if (!$record || !$record->updated_at) return 'Never';
                                return $record->updated_at->diffForHumans();
                            }),
                    ]),
                ])
                ->visible(fn ($record) => $record !== null)
                ->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->circular()
                    ->defaultImageUrl(fn ($record) =>
                        'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&color=7F9CF5&background=EBF4FF'
                    )
                    ->size(40),

                Tables\Columns\TextColumn::make('name')
                    ->weight(FontWeight::Bold)
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->email),

                Tables\Columns\TextColumn::make('role.name')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Super Admin' => 'danger',
                        'Admin' => 'warning',
                        'WDC' => 'info',
                        'CDFC' => 'success',
                        'Officer' => 'primary',
                        'Applicant' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('ward.name')
                    ->badge()
                    ->color('secondary')
                    ->sortable()
                    ->placeholder('No ward assigned')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Phone number copied!')
                    ->toggleable()
                    ->placeholder('No phone'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\IconColumn::make('email_verified_at')
                    ->label('Verified')
                    ->boolean()
                    ->trueIcon('heroicon-o-shield-check')
                    ->falseIcon('heroicon-o-shield-exclamation')
                    ->trueColor('success')
                    ->falseColor('warning')
                    ->getStateUsing(fn ($record) => !is_null($record->email_verified_at))
                    ->toggleable(),

                Tables\Columns\TextColumn::make('projects_count')
                    ->label('Projects')
                    ->getStateUsing(function ($record) {
                        return $record->communityProjects()->count() + $record->disasterProjects()->count();
                    })
                    ->badge()
                    ->color('info')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->relationship('role', 'name')
                    ->multiple()
                    ->preload(),

                SelectFilter::make('ward')
                    ->relationship('ward', 'name')
                    ->multiple()
                    ->preload(),

                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Created from'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Created until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['created_from'] ?? null) {
                            $indicators['created_from'] = 'Created from ' . Carbon::parse($data['created_from'])->toFormattedDateString();
                        }
                        if ($data['created_until'] ?? null) {
                            $indicators['created_until'] = 'Created until ' . Carbon::parse($data['created_until'])->toFormattedDateString();
                        }
                        return $indicators;
                    }),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->boolean()
                    ->trueLabel('Active Users')
                    ->falseLabel('Inactive Users')
                    ->native(false),

                Tables\Filters\TernaryFilter::make('email_verified_at')
                    ->label('Email Verified')
                    ->nullable()
                    ->trueLabel('Verified')
                    ->falseLabel('Unverified')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('email_verified_at'),
                        false: fn (Builder $query) => $query->whereNull('email_verified_at'),
                    ),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->color('info'),

                    Tables\Actions\EditAction::make()
                        ->color('warning')
                        ->visible(function ($record) {
                            return checkUserUpdatePermission() && (
                                auth()->user()->role_id === 1 || // Super Admin
                                auth()->id() === $record->id || // Own profile
                                ($record->role_id !== 1 && auth()->user()->role_id <= 2) // Not editing Super Admin
                            );
                        }),

                    Tables\Actions\Action::make('send_sms')
                        ->label('Send SMS')
                        ->icon('heroicon-o-chat-bubble-left-right')
                        ->color('info')
                        ->visible(fn ($record) => $record->phone && checkSmsNotificationCreatePermission())
                        ->form([
                            Forms\Components\Textarea::make('message')
                                ->label('Message')
                                ->required()
                                ->maxLength(160)
                                ->rows(3)
                                ->hint('Max 160 characters')
                                ->placeholder('Enter your message...'),
                        ])
                        ->action(function (array $data, $record) {
                            $smsService = new SmsService();
                            $result = $smsService->sendSingleSms(
                                $record->phone,
                                $data['message'],
                                $record->id
                            );

                            if ($result['success']) {
                                Notification::make()
                                    ->title('SMS Sent Successfully')
                                    ->body("Message sent to {$record->name}")
                                    ->success()
                                    ->send();
                            } else {
                                Notification::make()
                                    ->title('SMS Failed')
                                    ->body($result['message'])
                                    ->danger()
                                    ->send();
                            }
                        }),

                    Tables\Actions\Action::make('toggle_status')
                        ->label(fn ($record) => $record->is_active ? 'Deactivate' : 'Activate')
                        ->icon(fn ($record) => $record->is_active ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                        ->color(fn ($record) => $record->is_active ? 'danger' : 'success')
                        ->visible(function ($record) {
                            return checkUserUpdatePermission() &&
                                   auth()->id() !== $record->id && // Can't deactivate own account
                                   ($record->role_id !== 1 || auth()->user()->role_id === 1); // Super Admin protection
                        })
                        ->requiresConfirmation()
                        ->action(function ($record) {
                            $record->update(['is_active' => !$record->is_active]);

                            Notification::make()
                                ->title('User Status Updated')
                                ->body("User {$record->name} has been " . ($record->is_active ? 'activated' : 'deactivated'))
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\Action::make('reset_password')
                        ->label('Reset Password')
                        ->icon('heroicon-o-key')
                        ->color('warning')
                        ->visible(fn () => checkUserUpdatePermission())
                        ->requiresConfirmation()
                        ->action(function ($record) {
                            $newPassword = 'password123'; // In production, generate random password
                            $record->update(['password' => Hash::make($newPassword)]);

                            // Send SMS if phone available
                            if ($record->phone && checkSmsNotificationCreatePermission()) {
                                $smsService = new SmsService();
                                $smsService->sendSingleSms(
                                    $record->phone,
                                    "Your CDF account password has been reset. New password: {$newPassword}",
                                    $record->id
                                );
                            }

                            Notification::make()
                                ->title('Password Reset')
                                ->body("Password reset for {$record->name}. New password: {$newPassword}")
                                ->warning()
                                ->persistent()
                                ->send();
                        }),

                    Tables\Actions\DeleteAction::make()
                        ->visible(function ($record) {
                            return checkUserDeletePermission() && (
                                auth()->user()->role_id === 1 || // Super Admin can delete anyone
                                (auth()->user()->role_id === 2 && $record->role_id > 2) // Admin can delete non-admin users
                            ) && auth()->id() !== $record->id; // Can't delete own account
                        }),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn () => checkUserUpdatePermission())
                        ->action(function ($records) {
                            $records->each->update(['is_active' => true]);

                            Notification::make()
                                ->title('Users Activated')
                                ->body(count($records) . ' users have been activated')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->visible(fn () => checkUserUpdatePermission())
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            // Exclude current user from deactivation
                            $records = $records->filter(fn ($record) => $record->id !== auth()->id());
                            $records->each->update(['is_active' => false]);

                            Notification::make()
                                ->title('Users Deactivated')
                                ->body(count($records) . ' users have been deactivated')
                                ->warning()
                                ->send();
                        }),

                    Tables\Actions\BulkAction::make('send_bulk_sms')
                        ->label('Send SMS to Selected')
                        ->icon('heroicon-o-chat-bubble-left-right')
                        ->color('info')
                        ->visible(fn () => checkSmsNotificationCreatePermission())
                        ->form([
                            Forms\Components\Textarea::make('message')
                                ->label('Message')
                                ->required()
                                ->maxLength(160)
                                ->rows(3)
                                ->hint('Max 160 characters'),
                        ])
                        ->action(function (array $data, $records) {
                            $recipients = [];
                            foreach ($records as $record) {
                                if ($record->phone) {
                                    $recipients[] = [
                                        'phone' => $record->phone,
                                        'message' => $data['message'],
                                        'user_id' => $record->id,
                                    ];
                                }
                            }

                            if (empty($recipients)) {
                                Notification::make()
                                    ->title('No Phone Numbers')
                                    ->body('None of the selected users have phone numbers')
                                    ->warning()
                                    ->send();
                                return;
                            }

                            $smsService = new SmsService();
                            $result = $smsService->sendBulkSms($recipients, 'bulk');

                            if ($result['success']) {
                                Notification::make()
                                    ->title('Bulk SMS Sent')
                                    ->body("SMS sent to {$result['count']} users")
                                    ->success()
                                    ->send();
                            } else {
                                Notification::make()
                                    ->title('Bulk SMS Failed')
                                    ->body($result['message'])
                                    ->danger()
                                    ->send();
                            }
                        }),

                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => checkUserDeletePermission()),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s') // Auto-refresh every 30 seconds
            ->persistSortInSession()
            ->persistSearchInSession()
            ->persistFiltersInSession();
    }

    public static function getRelations(): array
    {
        return [
            // Add relations if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            //'view' => Pages\ViewUser::route('/{record}'),
        ];
    }

    // Modify what users can view based on role
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // Super Admin can see all users
        if (auth()->user()->role_id === 1) {
            return $query;
        }

        // Admin can see all except Super Admin
        if (auth()->user()->role_id === 2) {
            return $query->whereHas('role', function ($q) {
                $q->where('name', '!=', 'Super Admin');
            });
        }

        // WDC/CDFC can see users in their ward + applicants
        if (auth()->user()->isWDC() || auth()->user()->isCDFC()) {
            return $query->where(function ($q) {
                $q->where('ward_id', auth()->user()->ward_id)
                  ->orWhereHas('role', function ($roleQuery) {
                      $roleQuery->where('name', 'Applicant');
                  });
            });
        }

        // Officers can see applicants and other officers
        if (auth()->user()->role?->name === 'Officer') {
            return $query->whereHas('role', function ($q) {
                $q->whereIn('name', ['Officer', 'Applicant']);
            });
        }

        // Applicants can only see themselves
        return $query->where('id', auth()->id());
    }

    public static function canCreate(): bool
    {
        return checkUserCreatePermission();
    }

    public static function canEdit($record): bool
    {
        return checkUserUpdatePermission() && (
            auth()->user()->role_id === 1 || // Super Admin
            auth()->id() === $record->id || // Own profile
            ($record->role_id !== 1 && auth()->user()->role_id <= 2) // Not editing Super Admin
        );
    }

    public static function canDelete($record): bool
    {
        return checkUserDeletePermission() &&
               auth()->id() !== $record->id && // Can't delete own account
               (auth()->user()->role_id === 1 || // Super Admin can delete anyone
                (auth()->user()->role_id === 2 && $record->role_id > 2)); // Admin can delete non-admin users
    }
}
