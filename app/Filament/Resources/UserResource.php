<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use App\Models\Role;
use App\Models\Ward;
use App\Models\AuditTrail;
use App\Services\SmsService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Users';

    protected static ?string $modelLabel = 'User';

    protected static ?string $pluralModelLabel = 'Users';

    protected static ?string $navigationGroup = 'User Management';

    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return checkUserReadPermission();
    }

    public static function canCreate(): bool
    {
        return checkUserCreatePermission();
    }

    public static function canEdit($record): bool
    {
        // Super Admin protection - only Super Admin can edit Super Admin accounts
        if ($record->role?->name === 'Super Admin') {
            return Auth::user()?->role?->name === 'Super Admin';
        }
        return checkUserUpdatePermission();
    }

    public static function canDelete($record): bool
    {
        // Super Admin protection - cannot delete Super Admin accounts
        if ($record->role?->name === 'Super Admin') {
            return false;
        }
        // Cannot delete self
        if ($record->id === Auth::id()) {
            return false;
        }
        return checkUserDeletePermission();
    }

    public static function canView($record): bool
    {
        return checkUserReadPermission();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('User Information')
                    ->tabs([
                        Tabs\Tab::make('Basic Information')
                            ->schema([
                                Section::make('Personal Details')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('name')
                                                    ->label('Full Name')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->placeholder('John Doe')
                                                    ->rules(['min:2', 'max:255'])
                                                    ->validationMessages([
                                                        'min' => 'Name must be at least 2 characters long',
                                                        'max' => 'Name cannot exceed 255 characters',
                                                    ]),

                                                Forms\Components\TextInput::make('email')
                                                    ->label('Email Address')
                                                    ->email()
                                                    ->required()
                                                    ->unique(ignoreRecord: true)
                                                    ->maxLength(255)
                                                    ->placeholder('john@example.com')
                                                    ->rules(['email'])
                                                    ->validationMessages([
                                                        'email' => 'Please enter a valid email address',
                                                        'unique' => 'This email address is already registered',
                                                    ]),
                                            ]),

                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('phone')
                                                    ->label('Phone Number')
                                                    ->tel()
                                                    ->maxLength(20)
                                                    ->placeholder('+260 977 123456')
                                                    ->helperText('Contact phone number (international format preferred)')
                                                    ->rules(['regex:/^[\+]?[0-9\s\-\(\)]{10,20}$/'])
                                                    ->validationMessages([
                                                        'regex' => 'Please enter a valid phone number (10-20 digits)',
                                                    ])
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(function (string $state, Forms\Set $set) {
                                                        // Clean and format phone number
                                                        $cleaned = preg_replace('/[^0-9\+]/', '', $state);
                                                        if (strlen($cleaned) > 20) {
                                                            $cleaned = substr($cleaned, 0, 20);
                                                        }
                                                        $set('phone', $cleaned);
                                                    }),

                                                Forms\Components\FileUpload::make('image')
                                                    ->label('Profile Image')
                                                    ->image()
                                                    ->imageEditor()
                                                    ->imageEditorAspectRatios([
                                                        '1:1',
                                                    ])
                                                    ->directory('profile-images')
                                                    ->disk('public')
                                                    ->visibility('public')
                                                    ->maxSize(2048)
                                                    ->helperText('Upload a profile image (max 2MB)'),
                                            ]),
                                    ])
                                    ->columns(1),

                                Section::make('System Access')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\Select::make('role_id')
                                                    ->label('User Role')
                                                    ->relationship('role', 'name')
                                                    ->required()
                                                    ->searchable()
                                                    ->preload()
                                                    ->live()
                                                    ->options(function () {
                                                        $user = Auth::user();
                                                        $query = Role::query();

                                                        // Only Super Admin can assign Super Admin role
                                                        if ($user?->role?->name !== 'Super Admin') {
                                                            $query->where('name', '!=', 'Super Admin');
                                                        }

                                                        return $query->pluck('name', 'id');
                                                    })
                                                    ->helperText('Select the appropriate role for this user'),

                                                Forms\Components\Select::make('ward_id')
                                                    ->label('Ward Assignment')
                                                    ->relationship('ward', 'name')
                                                    ->searchable()
                                                    ->preload()
                                                    ->helperText('Assign user to a specific ward (optional)')
                                                    ->visible(function (Forms\Get $get) {
                                                        $roleId = $get('role_id');
                                                        if ($roleId) {
                                                            $role = Role::find($roleId);
                                                            return in_array($role?->name, [
                                                                'Ward Development Committee',
                                                                'Constituency Officer',
                                                                'Applicant'
                                                            ]);
                                                        }
                                                        return true;
                                                    }),
                                            ]),

                                        Forms\Components\Toggle::make('is_active')
                                            ->label('Account Active')
                                            ->default(true)
                                            ->helperText('Inactive users cannot login to the system')
                                            ->visible(function () {
                                                // Only allow role changes for appropriate users
                                                return Auth::user()?->role?->name === 'Super Admin' ||
                                                       Auth::user()?->role?->name === 'Admin';
                                            }),
                                    ])
                                    ->columns(2)
                                    ->collapsible(),
                            ]),

                        Tabs\Tab::make('Security')
                            ->schema([
                                Section::make('Password Management')
                                    ->schema([
                                        Forms\Components\TextInput::make('password')
                                            ->label('Password')
                                            ->password()
                                            ->revealable()
                                            ->maxLength(255)
                                            ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                                            ->dehydrated(fn ($state) => filled($state))
                                            ->required(fn (string $context): bool => $context === 'create')
                                            ->rules(['min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'])
                                            ->validationMessages([
                                                'min' => 'Password must be at least 8 characters long',
                                                'regex' => 'Password must contain at least one uppercase letter, one lowercase letter, and one number',
                                            ])
                                            ->helperText('Leave blank to keep current password (when editing)'),

                                        Forms\Components\TextInput::make('password_confirmation')
                                            ->label('Confirm Password')
                                            ->password()
                                            ->revealable()
                                            ->maxLength(255)
                                            ->dehydrated(false)
                                            ->required(fn (string $context): bool => $context === 'create')
                                            ->same('password')
                                            ->validationMessages([
                                                'same' => 'Password confirmation must match the password',
                                            ]),
                                    ])
                                    ->columns(1),

                                Section::make('Account Security')
                                    ->schema([
                                        Forms\Components\Placeholder::make('last_login')
                                            ->label('Last Login')
                                            ->content(fn ($record) => $record?->last_login_at ?
                                                $record->last_login_at->format('M j, Y g:i A') : 'Never logged in'),

                                        Forms\Components\Placeholder::make('created_info')
                                            ->label('Account Created')
                                            ->content(fn ($record) => $record?->created_at ?
                                                $record->created_at->format('M j, Y g:i A') : 'Just now'),

                                        Forms\Components\Placeholder::make('email_verified')
                                            ->label('Email Verified')
                                            ->content(fn ($record) => $record?->email_verified_at ?
                                                'Verified on ' . $record->email_verified_at->format('M j, Y') : 'Not verified'),
                                    ])
                                    ->columns(1)
                                    ->hidden(fn (string $context): bool => $context === 'create'),
                            ]),

                        Tabs\Tab::make('Activity & Permissions')
                            ->schema([
                                Section::make('User Activity')
                                    ->schema([
                                        Forms\Components\Placeholder::make('projects_count')
                                            ->label('Community Projects')
                                            ->content(fn ($record) => $record ?
                                                $record->communityProjects()->count() . ' projects' : '0 projects'),

                                        Forms\Components\Placeholder::make('disaster_projects_count')
                                            ->label('Disaster Projects')
                                            ->content(fn ($record) => $record ?
                                                $record->disasterProjects()->count() . ' projects' : '0 projects'),

                                        Forms\Components\Placeholder::make('grants_count')
                                            ->label('Empowerment Grants')
                                            ->content(fn ($record) => $record ?
                                                $record->empowermentGrants()->count() . ' grants' : '0 grants'),

                                        Forms\Components\Placeholder::make('reports_count')
                                            ->label('Monitoring Reports')
                                            ->content(fn ($record) => $record ?
                                                $record->monitoringReports()->count() . ' reports' : '0 reports'),
                                    ])
                                    ->columns(2)
                                    ->hidden(fn (string $context): bool => $context === 'create'),

                                Section::make('Role Permissions')
                                    ->schema([
                                        Forms\Components\Placeholder::make('role_permissions')
                                            ->label('Current Permissions')
                                            ->content(function ($record) {
                                                if (!$record || !$record->role) {
                                                    return 'No role assigned';
                                                }

                                                $permissions = \App\Models\Permission::where('role_id', $record->role_id)->get();
                                                if ($permissions->isEmpty()) {
                                                    return 'No specific permissions set';
                                                }

                                                $permissionText = $permissions->groupBy('module')->map(function ($modulePerms, $module) {
                                                    $actions = [];
                                                    foreach ($modulePerms as $perm) {
                                                        if ($perm->create) $actions[] = 'Create';
                                                        if ($perm->read) $actions[] = 'Read';
                                                        if ($perm->update) $actions[] = 'Update';
                                                        if ($perm->delete) $actions[] = 'Delete';
                                                    }
                                                    return $module . ': ' . implode(', ', array_unique($actions));
                                                })->implode('<br>');

                                                return new \Illuminate\Support\HtmlString($permissionText);
                                            }),
                                    ])
                                    ->columns(1)
                                    ->hidden(fn (string $context): bool => $context === 'create'),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Photo')
                    ->circular()
                    ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&color=7F9CF5&background=EBF4FF')
                    ->size(40),

                Tables\Columns\TextColumn::make('name')
                    ->label('Full Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->icon('heroicon-o-envelope'),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-o-phone')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('role.name')
                    ->label('Role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Super Admin' => 'danger',
                        'Admin' => 'warning',
                        'CDFC Member' => 'success',
                        'Ward Development Committee' => 'info',
                        'Constituency Officer' => 'primary',
                        'Applicant' => 'gray',
                        default => 'secondary',
                    })
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('ward.name')
                    ->label('Ward')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label('Email Verified')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'warning')
                    ->formatStateUsing(fn ($state) => $state ? 'Verified' : 'Unverified')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('community_projects_count')
                    ->label('Projects')
                    ->counts('communityProjects')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registered')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->relationship('role', 'name')
                    ->multiple()
                    ->preload(),

                Tables\Filters\SelectFilter::make('ward')
                    ->relationship('ward', 'name')
                    ->multiple()
                    ->preload(),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Account Status')
                    ->boolean()
                    ->trueLabel('Active Users')
                    ->falseLabel('Inactive Users')
                    ->native(false),

                Tables\Filters\TernaryFilter::make('email_verified_at')
                    ->label('Email Verification')
                    ->nullable()
                    ->trueLabel('Verified Email')
                    ->falseLabel('Unverified Email')
                    ->native(false),

                Tables\Filters\Filter::make('recent_users')
                    ->label('Recent Users (30 days)')
                    ->query(fn (Builder $query): Builder =>
                        $query->where('created_at', '>=', now()->subDays(30))
                    ),

                Tables\Filters\Filter::make('has_projects')
                    ->label('Users with Projects')
                    ->query(fn (Builder $query): Builder =>
                        $query->has('communityProjects')
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->visible(fn ($record) => checkUserReadPermission())
                    ->after(function ($record) {
                        self::logActivity('View', $record, 'Viewed user profile: ' . $record->name);
                    }),

                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) =>
                        checkUserUpdatePermission() &&
                        ($record->role?->name !== 'Super Admin' || Auth::user()?->role?->name === 'Super Admin')
                    )
                    ->mutateFormDataUsing(function (array $data, $record): array {
                        self::logActivity('Update', $record,
                            'Updated user profile: ' . $record->name,
                            $record->toArray(),
                            $data
                        );
                        return $data;
                    }),

                Tables\Actions\Action::make('toggle_status')
                    ->label(fn ($record) => $record->is_active ? 'Deactivate' : 'Activate')
                    ->icon(fn ($record) => $record->is_active ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn ($record) => $record->is_active ? 'danger' : 'success')
                    ->requiresConfirmation()
                    ->modalHeading(fn ($record) => ($record->is_active ? 'Deactivate' : 'Activate') . ' User Account')
                    ->modalDescription(fn ($record) =>
                        $record->is_active
                            ? 'This will prevent the user from logging into the system.'
                            : 'This will allow the user to login to the system.'
                    )
                    ->action(function ($record) {
                        $oldStatus = $record->is_active;
                        $record->update(['is_active' => !$record->is_active]);

                        $action = $record->is_active ? 'Activated' : 'Deactivated';
                        self::logActivity('Status Change', $record,
                            $action . ' user account: ' . $record->name,
                            ['is_active' => $oldStatus],
                            ['is_active' => $record->is_active]
                        );

                        Notification::make()
                            ->title('User ' . $action)
                            ->body($record->name . ' has been ' . strtolower($action))
                            ->success()
                            ->send();
                    })
                    ->visible(fn ($record) =>
                        checkUserUpdatePermission() &&
                        $record->id !== Auth::id() &&
                        ($record->role?->name !== 'Super Admin' || Auth::user()?->role?->name === 'Super Admin')
                    ),

                Tables\Actions\Action::make('send_welcome_sms')
                    ->label('Send Welcome SMS')
                    ->icon('heroicon-o-envelope')
                    ->color('info')
                    ->form([
                        Forms\Components\Textarea::make('message')
                            ->label('Welcome Message')
                            ->required()
                            ->default('Welcome to the CDF Management System! Your account has been created successfully. Please contact us if you need assistance.')
                            ->rows(3),
                    ])
                    ->action(function ($record, array $data) {
                        if ($record->phone) {
                            $smsService = new SmsService();
                            $message = "CDF SYSTEM: Welcome {$record->name}! " . $data['message'];
                            $result = $smsService->sendSms($record->phone, $message);

                            if ($result['success']) {
                                self::logActivity('SMS Sent', $record,
                                    'Sent welcome SMS to user: ' . $record->name
                                );

                                Notification::make()
                                    ->title('SMS Sent')
                                    ->body('Welcome SMS sent to ' . $record->name)
                                    ->success()
                                    ->send();
                            } else {
                                Notification::make()
                                    ->title('SMS Failed')
                                    ->body('Failed to send SMS: ' . $result['message'])
                                    ->danger()
                                    ->send();
                            }
                        } else {
                            Notification::make()
                                ->title('No Phone Number')
                                ->body('User does not have a phone number set')
                                ->warning()
                                ->send();
                        }
                    })
                    ->visible(fn ($record) => checkUserUpdatePermission()),

                Tables\Actions\Action::make('reset_password')
                    ->label('Reset Password')
                    ->icon('heroicon-o-key')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Reset User Password')
                    ->modalDescription('This will generate a new temporary password for the user.')
                    ->form([
                        Forms\Components\TextInput::make('new_password')
                            ->label('New Password')
                            ->password()
                            ->revealable()
                            ->required()
                            ->minLength(8)
                            ->default(fn () => \Str::random(12)),

                        Forms\Components\Toggle::make('send_sms')
                            ->label('Send password via SMS')
                            ->default(true)
                            ->visible(fn ($record) => !empty($record->phone)),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update(['password' => Hash::make($data['new_password'])]);

                        self::logActivity('Password Reset', $record,
                            'Reset password for user: ' . $record->name
                        );

                        if ($data['send_sms'] && $record->phone) {
                            $smsService = new SmsService();
                            $message = "CDF SYSTEM: Your password has been reset. New password: {$data['new_password']}. Please change it after logging in.";
                            $smsService->sendSms($record->phone, $message);
                        }

                        Notification::make()
                            ->title('Password Reset')
                            ->body('Password has been reset for ' . $record->name)
                            ->success()
                            ->send();
                    })
                    ->visible(fn ($record) =>
                        checkUserUpdatePermission() &&
                        ($record->role?->name !== 'Super Admin' || Auth::user()?->role?->name === 'Super Admin')
                    ),

                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) =>
                        checkUserDeletePermission() &&
                        $record->id !== Auth::id() &&
                        $record->role?->name !== 'Super Admin'
                    )
                    ->before(function ($record) {
                        self::logActivity('Delete', $record, 'Deleted user account: ' . $record->name);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('activate_users')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            $count = 0;
                            foreach ($records as $record) {
                                if (!$record->is_active && checkUserUpdatePermission()) {
                                    $record->update(['is_active' => true]);
                                    self::logActivity('Bulk Activate', $record, 'Bulk activated user: ' . $record->name);
                                    $count++;
                                }
                            }

                            Notification::make()
                                ->title('Users Activated')
                                ->body("Activated {$count} user accounts")
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\BulkAction::make('deactivate_users')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $count = 0;
                            foreach ($records as $record) {
                                if ($record->is_active && $record->id !== Auth::id() && checkUserUpdatePermission()) {
                                    $record->update(['is_active' => false]);
                                    self::logActivity('Bulk Deactivate', $record, 'Bulk deactivated user: ' . $record->name);
                                    $count++;
                                }
                            }

                            Notification::make()
                                ->title('Users Deactivated')
                                ->body("Deactivated {$count} user accounts")
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\BulkAction::make('send_bulk_sms')
                        ->label('Send SMS to Selected')
                        ->icon('heroicon-o-envelope')
                        ->color('info')
                        ->form([
                            Forms\Components\Textarea::make('message')
                                ->label('SMS Message')
                                ->required()
                                ->maxLength(160)
                                ->helperText('Maximum 160 characters for SMS')
                                ->rows(3),
                        ])
                        ->action(function ($records, array $data) {
                            $smsService = new SmsService();
                            $sentCount = 0;

                            foreach ($records as $record) {
                                if ($record->phone && checkUserUpdatePermission()) {
                                    $message = "CDF SYSTEM: " . $data['message'];
                                    $result = $smsService->sendSms($record->phone, $message);

                                    if ($result['success']) {
                                        $sentCount++;
                                    }

                                    self::logActivity('Bulk SMS', $record,
                                        'Sent bulk SMS to user: ' . $record->name
                                    );
                                }
                            }

                            Notification::make()
                                ->title('SMS Sent')
                                ->body("Sent SMS to {$sentCount} users")
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => checkUserDeletePermission())
                        ->before(function ($records) {
                            foreach ($records as $record) {
                                if ($record->id !== Auth::id() && $record->role?->name !== 'Super Admin') {
                                    self::logActivity('Bulk Delete', $record, 'Bulk deleted user: ' . $record->name);
                                }
                            }
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100]);
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();
        $query = parent::getEloquentQuery();

        if ($user && $user->role) {
            switch ($user->role->name) {
                case 'Ward Development Committee':
                case 'Constituency Officer':
                    // Only see users in their ward
                    if ($user->ward_id) {
                        $query->where('ward_id', $user->ward_id);
                    }
                    break;

                case 'CDFC Member':
                case 'Admin':
                    // Can see all users except Super Admin (unless they are Super Admin)
                    if ($user->role->name !== 'Super Admin') {
                        $query->whereDoesntHave('role', function ($q) {
                            $q->where('name', 'Super Admin');
                        });
                    }
                    break;

                case 'Super Admin':
                    // Can see all users
                    break;

                case 'Applicant':
                    // Only see themselves
                    $query->where('id', $user->id);
                    break;
            }
        }

        return $query;
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    // Audit Trail Logging Method
    private static function logActivity(string $action, $record, string $description, array $oldValues = [], array $newValues = []): void
    {
        try {
            AuditTrail::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'table_name' => 'users',
                'record_id' => $record?->id,
                'old_values' => !empty($oldValues) ? json_encode($oldValues) : null,
                'new_values' => !empty($newValues) ? json_encode($newValues) : null,
                'description' => $description,
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
            ]);
        } catch (\Exception $e) {
            // Log error but don't break the application
            \Log::error('Failed to log audit trail: ' . $e->getMessage());
        }
    }
}
