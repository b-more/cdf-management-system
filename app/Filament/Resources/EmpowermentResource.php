<?php

// ===============================================
// EmpowermentResource.php with Audit Trail
// ===============================================

namespace App\Filament\Resources;

use App\Filament\Resources\EmpowermentResource\Pages;
use App\Models\Empowerment;
use App\Models\Ward;
use App\Models\User;
use App\Models\AuditTrail;
use App\Services\SmsService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EmpowermentResource extends Resource
{
    protected static ?string $model = Empowerment::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Empowerment Programs';
    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return checkEmpowermentReadPermission();
    }

    public static function canCreate(): bool
    {
        return checkEmpowermentCreatePermission();
    }

    public static function canEdit($record): bool
    {
        return checkEmpowermentUpdatePermission();
    }

    public static function canDelete($record): bool
    {
        return checkEmpowermentDeletePermission();
    }

    public static function canView($record): bool
    {
        return checkEmpowermentReadPermission();
    }

    // Audit Trail Logging Methods
    protected static function logActivity(string $action, Model $record, ?array $oldValues = null, ?array $newValues = null): void
    {
        $user = Auth::user();
        if (!$user) return;

        AuditTrail::create([
            'user_id' => $user->id,
            'action' => $action,
            'table_name' => 'empowerments',
            'record_id' => $record->id,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'description' => self::getActionDescription($action, $record),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    protected static function getActionDescription(string $action, Model $record): string
    {
        $user = Auth::user();
        return match($action) {
            'Create' => "Created empowerment program: {$record->title}",
            'Update' => "Updated empowerment program: {$record->title}",
            'Delete' => "Deleted empowerment program: {$record->title}",
            'View' => "Viewed empowerment program: {$record->title}",
            'Approve' => "Approved empowerment program: {$record->title}",
            'Send_Invitation' => "Sent invitations for program: {$record->title}",
            'Start_Program' => "Started empowerment program: {$record->title}",
            'Complete_Program' => "Completed empowerment program: {$record->title}",
            default => "Performed {$action} on empowerment program: {$record->title}",
        };
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Empowerment Program')
                    ->tabs([
                        Tabs\Tab::make('Program Information')
                            ->schema([
                                Section::make('Basic Information')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('program_code')
                                                    ->required()
                                                    ->maxLength(50)
                                                    ->unique(ignoreRecord: true)
                                                    ->label('Program Code')
                                                    ->default(fn () => 'EMP-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT)),

                                                Forms\Components\TextInput::make('title')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->label('Program Title'),
                                            ]),

                                        Forms\Components\RichEditor::make('description')
                                            ->required()
                                            ->columnSpanFull()
                                            ->label('Program Description'),

                                        Grid::make(3)
                                            ->schema([
                                                Forms\Components\Select::make('program_type')
                                                    ->options([
                                                        'Skills_Training' => 'Skills Training',
                                                        'Business_Development' => 'Business Development',
                                                        'Youth_Empowerment' => 'Youth Empowerment',
                                                        'Women_Empowerment' => 'Women Empowerment',
                                                        'Digital_Literacy' => 'Digital Literacy',
                                                        'Financial_Literacy' => 'Financial Literacy',
                                                        'Agricultural_Training' => 'Agricultural Training',
                                                        'Health_Education' => 'Health Education',
                                                        'Leadership_Development' => 'Leadership Development',
                                                        'Other' => 'Other',
                                                    ])
                                                    ->required()
                                                    ->searchable()
                                                    ->live(),

                                                Forms\Components\Select::make('target_group')
                                                    ->options([
                                                        'Youth' => 'Youth (18-35)',
                                                        'Women' => 'Women',
                                                        'Men' => 'Men',
                                                        'Elderly' => 'Elderly (60+)',
                                                        'PWDs' => 'Persons with Disabilities',
                                                        'Farmers' => 'Farmers',
                                                        'Entrepreneurs' => 'Entrepreneurs',
                                                        'Students' => 'Students',
                                                        'General' => 'General Public',
                                                        'Other' => 'Other',
                                                    ])
                                                    ->required()
                                                    ->searchable(),

                                                Forms\Components\Select::make('status')
                                                    ->options([
                                                        'Planning' => 'Planning',
                                                        'Approved' => 'Approved',
                                                        'Active' => 'Active',
                                                        'Ongoing' => 'Ongoing',
                                                        'Completed' => 'Completed',
                                                        'Suspended' => 'Suspended',
                                                        'Cancelled' => 'Cancelled',
                                                    ])
                                                    ->required()
                                                    ->default('Planning')
                                                    ->live(),
                                            ]),
                                    ]),

                                Section::make('Location & Scope')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\Select::make('ward_id')
                                                    ->relationship('ward', 'name')
                                                    ->searchable()
                                                    ->preload()
                                                    ->label('Primary Ward')
                                                    ->required(),

                                                Forms\Components\TextInput::make('venue')
                                                    ->maxLength(255)
                                                    ->label('Venue/Location'),
                                            ]),

                                        Grid::make(3)
                                            ->schema([
                                                Forms\Components\TextInput::make('target_participants')
                                                    ->numeric()
                                                    ->required()
                                                    ->default(0)
                                                    ->minValue(1)
                                                    ->label('Target Participants'),

                                                Forms\Components\TextInput::make('registered_participants')
                                                    ->numeric()
                                                    ->default(0)
                                                    ->minValue(0)
                                                    ->label('Registered Participants'),

                                                Forms\Components\TextInput::make('completed_participants')
                                                    ->numeric()
                                                    ->default(0)
                                                    ->minValue(0)
                                                    ->label('Completed Participants'),
                                            ]),
                                    ])
                                    ->collapsible(),
                            ]),

                        Tabs\Tab::make('Program Details')
                            ->schema([
                                Section::make('Content & Curriculum')
                                    ->schema([
                                        Forms\Components\RichEditor::make('objectives')
                                            ->columnSpanFull()
                                            ->label('Program Objectives'),

                                        Forms\Components\RichEditor::make('curriculum')
                                            ->columnSpanFull()
                                            ->label('Curriculum/Content'),

                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('duration_hours')
                                                    ->numeric()
                                                    ->suffix('hours')
                                                    ->minValue(1)
                                                    ->label('Duration (Hours)'),

                                                Forms\Components\TextInput::make('duration_days')
                                                    ->numeric()
                                                    ->suffix('days')
                                                    ->minValue(1)
                                                    ->label('Duration (Days)'),
                                            ]),

                                        Forms\Components\Textarea::make('prerequisites')
                                            ->rows(3)
                                            ->columnSpanFull()
                                            ->label('Prerequisites'),
                                    ]),

                                Section::make('Resources & Requirements')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\Textarea::make('required_materials')
                                                    ->rows(3)
                                                    ->label('Required Materials'),

                                                Forms\Components\Textarea::make('equipment_needed')
                                                    ->rows(3)
                                                    ->label('Equipment Needed'),
                                            ]),

                                        Forms\Components\Textarea::make('facilitators')
                                            ->rows(3)
                                            ->columnSpanFull()
                                            ->label('Facilitators/Trainers'),
                                    ])
                                    ->collapsible(),
                            ]),

                        Tabs\Tab::make('Schedule & Budget')
                            ->schema([
                                Section::make('Schedule')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                Forms\Components\DatePicker::make('start_date')
                                                    ->required()
                                                    ->label('Start Date'),

                                                Forms\Components\DatePicker::make('end_date')
                                                    ->required()
                                                    ->after('start_date')
                                                    ->label('End Date'),

                                                Forms\Components\TimePicker::make('session_time')
                                                    ->label('Session Time'),
                                            ]),

                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\DatePicker::make('registration_deadline')
                                                    ->before('start_date')
                                                    ->label('Registration Deadline'),

                                                Forms\Components\Select::make('frequency')
                                                    ->options([
                                                        'Daily' => 'Daily',
                                                        'Weekly' => 'Weekly',
                                                        'Bi-Weekly' => 'Bi-Weekly',
                                                        'Monthly' => 'Monthly',
                                                        'One-Time' => 'One-Time Event',
                                                        'Custom' => 'Custom Schedule',
                                                    ])
                                                    ->label('Frequency'),
                                            ]),
                                    ]),

                                Section::make('Budget')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                Forms\Components\TextInput::make('total_budget')
                                                    ->numeric()
                                                    ->required()
                                                    ->prefix('K')
                                                    ->minValue(0)
                                                    ->label('Total Budget'),

                                                Forms\Components\TextInput::make('allocated_budget')
                                                    ->numeric()
                                                    ->default(0)
                                                    ->prefix('K')
                                                    ->minValue(0)
                                                    ->label('Allocated Budget'),

                                                Forms\Components\TextInput::make('spent_amount')
                                                    ->numeric()
                                                    ->default(0)
                                                    ->prefix('K')
                                                    ->minValue(0)
                                                    ->label('Spent Amount'),
                                            ]),

                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('cost_per_participant')
                                                    ->numeric()
                                                    ->prefix('K')
                                                    ->minValue(0)
                                                    ->label('Cost per Participant'),

                                                Forms\Components\Select::make('funding_source')
                                                    ->options([
                                                        'CDF' => 'CDF Allocation',
                                                        'Government' => 'Government Grant',
                                                        'NGO' => 'NGO Partnership',
                                                        'Private' => 'Private Sector',
                                                        'Community' => 'Community Contribution',
                                                        'Mixed' => 'Mixed Sources',
                                                        'Other' => 'Other',
                                                    ])
                                                    ->searchable(),
                                            ]),
                                    ])
                                    ->collapsible(),
                            ]),

                        Tabs\Tab::make('Outcomes & Management')
                            ->schema([
                                Section::make('Expected Outcomes')
                                    ->schema([
                                        Forms\Components\RichEditor::make('expected_outcomes')
                                            ->columnSpanFull()
                                            ->label('Expected Outcomes'),

                                        Forms\Components\Textarea::make('success_indicators')
                                            ->rows(3)
                                            ->columnSpanFull()
                                            ->label('Success Indicators'),

                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('completion_rate_target')
                                                    ->numeric()
                                                    ->suffix('%')
                                                    ->default(80)
                                                    ->minValue(0)
                                                    ->maxValue(100)
                                                    ->label('Target Completion Rate'),

                                                Forms\Components\TextInput::make('satisfaction_target')
                                                    ->numeric()
                                                    ->suffix('%')
                                                    ->default(85)
                                                    ->minValue(0)
                                                    ->maxValue(100)
                                                    ->label('Target Satisfaction Rate'),
                                            ]),
                                    ]),

                                Section::make('Management')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\Select::make('coordinator_id')
                                                    ->relationship('coordinator', 'name')
                                                    ->required()
                                                    ->searchable()
                                                    ->preload()
                                                    ->default(Auth::id())
                                                    ->label('Program Coordinator'),

                                                Forms\Components\Select::make('approved_by_id')
                                                    ->relationship('approvedBy', 'name')
                                                    ->searchable()
                                                    ->preload()
                                                    ->label('Approved By'),
                                            ]),

                                        Forms\Components\Textarea::make('implementation_notes')
                                            ->rows(3)
                                            ->columnSpanFull()
                                            ->label('Implementation Notes'),

                                        Forms\Components\Textarea::make('evaluation_notes')
                                            ->rows(3)
                                            ->columnSpanFull()
                                            ->label('Evaluation Notes'),
                                    ])
                                    ->collapsible(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('program_code')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(30)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 30 ? $state : null;
                    }),

                Tables\Columns\BadgeColumn::make('program_type')
                    ->colors([
                        'primary' => 'Skills_Training',
                        'success' => 'Business_Development',
                        'info' => 'Youth_Empowerment',
                        'warning' => 'Women_Empowerment',
                        'danger' => 'Digital_Literacy',
                        'secondary' => ['Financial_Literacy', 'Agricultural_Training', 'Health_Education', 'Leadership_Development', 'Other'],
                    ]),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'Planning',
                        'warning' => 'Approved',
                        'success' => ['Active', 'Ongoing', 'Completed'],
                        'danger' => ['Suspended', 'Cancelled'],
                    ]),

                Tables\Columns\TextColumn::make('target_group')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('target_participants')
                    ->numeric()
                    ->label('Target'),

                Tables\Columns\TextColumn::make('registered_participants')
                    ->numeric()
                    ->label('Registered'),

                Tables\Columns\TextColumn::make('completion_rate')
                    ->getStateUsing(fn ($record) => $record->target_participants > 0 ?
                        round(($record->completed_participants / $record->target_participants) * 100, 1) : 0)
                    ->suffix('%')
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state >= 80 => 'success',
                        $state >= 60 => 'warning',
                        default => 'danger',
                    })
                    ->label('Completion'),

                Tables\Columns\TextColumn::make('ward.name')
                    ->label('Ward')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('total_budget')
                    ->money('ZMW')
                    ->sortable()
                    ->label('Budget'),

                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('coordinator.name')
                    ->label('Coordinator')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('program_type'),
                Tables\Filters\SelectFilter::make('status'),
                Tables\Filters\SelectFilter::make('target_group'),
                Tables\Filters\SelectFilter::make('ward')
                    ->relationship('ward', 'name'),

                Tables\Filters\Filter::make('active_programs')
                    ->query(fn (Builder $query): Builder =>
                        $query->whereIn('status', ['Active', 'Ongoing'])
                    )
                    ->label('Active Programs'),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function (Empowerment $record) {
                        $oldValues = $record->toArray();

                        $record->update([
                            'status' => 'Approved',
                            'approved_by_id' => Auth::id(),
                        ]);

                        // Log audit trail
                        self::logActivity('Approve', $record, $oldValues, $record->fresh()->toArray());

                        Notification::make()
                            ->title('Program Approved')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Empowerment $record) =>
                        $record->status === 'Planning' &&
                        checkEmpowermentUpdatePermission()
                    ),

                Tables\Actions\Action::make('start_program')
                    ->icon('heroicon-o-play')
                    ->color('primary')
                    ->action(function (Empowerment $record) {
                        $oldValues = $record->toArray();

                        $record->update(['status' => 'Active']);

                        // Log audit trail
                        self::logActivity('Start_Program', $record, $oldValues, $record->fresh()->toArray());

                        Notification::make()
                            ->title('Program Started')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Empowerment $record) =>
                        $record->status === 'Approved' &&
                        checkEmpowermentUpdatePermission()
                    ),

                Tables\Actions\Action::make('send_invitation')
                    ->icon('heroicon-o-envelope')
                    ->color('warning')
                    ->form([
                        Forms\Components\Textarea::make('message')
                            ->required()
                            ->default('You are invited to participate in our empowerment program. Please register before the deadline.')
                            ->label('Invitation Message'),

                        Forms\Components\Toggle::make('send_to_ward_users')
                            ->label('Send to all ward users')
                            ->default(true),
                    ])
                    ->action(function (Empowerment $record, array $data) {
                        $users = collect();

                        if ($data['send_to_ward_users']) {
                            $users = User::where('ward_id', $record->ward_id)
                                        ->whereNotNull('phone')
                                        ->get();
                        }

                        $smsService = new SmsService();
                        $count = 0;

                        foreach ($users as $user) {
                            $message = "EMPOWERMENT PROGRAM: {$record->title}. {$data['message']} Contact us for registration. Code: {$record->program_code}";
                            $result = $smsService->sendSms($user->phone, $message);
                            if ($result['success']) {
                                $count++;
                            }
                        }

                        // Log audit trail
                        self::logActivity('Send_Invitation', $record, null, [
                            'recipients_count' => $count,
                            'message' => $data['message']
                        ]);

                        Notification::make()
                            ->title("Invitations Sent")
                            ->body("Sent {$count} SMS invitations")
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Empowerment $record) =>
                        in_array($record->status, ['Approved', 'Active']) &&
                        checkEmpowermentUpdatePermission()
                    ),

                Tables\Actions\ViewAction::make()
                    ->visible(fn () => checkEmpowermentReadPermission())
                    ->after(function (Empowerment $record) {
                        // Log view activity
                        self::logActivity('View', $record);
                    }),

                Tables\Actions\EditAction::make()
                    ->visible(fn () => checkEmpowermentUpdatePermission())
                    ->mutateFormDataUsing(function (array $data, Empowerment $record): array {
                        // Store old values for audit trail
                        $record->load(['ward', 'coordinator', 'approvedBy']);
                        session(['empowerment_old_values' => $record->toArray()]);
                        return $data;
                    }),

                Tables\Actions\DeleteAction::make()
                    ->visible(fn () => checkEmpowermentDeletePermission())
                    ->before(function (Empowerment $record) {
                        // Log deletion before it happens
                        self::logActivity('Delete', $record, $record->toArray());
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('bulk_approve')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            $count = 0;
                            foreach ($records as $record) {
                                if ($record->status === 'Planning') {
                                    $oldValues = $record->toArray();
                                    $record->update([
                                        'status' => 'Approved',
                                        'approved_by_id' => Auth::id(),
                                    ]);
                                    self::logActivity('Approve', $record, $oldValues, $record->fresh()->toArray());
                                    $count++;
                                }
                            }

                            Notification::make()
                                ->title("Approved {$count} Programs")
                                ->success()
                                ->send();
                        })
                        ->visible(fn () => checkEmpowermentUpdatePermission()),

                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => checkEmpowermentDeletePermission())
                        ->before(function ($records) {
                            // Log bulk deletion
                            foreach ($records as $record) {
                                self::logActivity('Delete', $record, $record->toArray());
                            }
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmpowerments::route('/'),
            'create' => Pages\CreateEmpowerment::route('/create'),
            'view' => Pages\ViewEmpowerment::route('/{record}'),
            'edit' => Pages\EditEmpowerment::route('/{record}/edit'),
        ];
    }

    // Override parent methods to add audit logging
    public static function handleRecordCreation(array $data): Model
    {
        $record = static::getModel()::create($data);

        // Log creation
        self::logActivity('Create', $record, null, $record->toArray());

        return $record;
    }

    public static function handleRecordUpdate(Model $record, array $data): Model
    {
        $oldValues = session('empowerment_old_values', $record->toArray());

        $record->update($data);

        // Log update
        self::logActivity('Update', $record, $oldValues, $record->fresh()->toArray());

        return $record;
    }
}
