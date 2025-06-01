<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmpowermentResource\Pages;
use App\Models\Empowerment;
use App\Models\Ward;
use App\Models\User;
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
                                                    ->label('Program Code'),

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
                                                    ->searchable(),

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
                                                    ->default('Planning'),
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
                                                    ->label('Primary Ward'),

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
                                                    ->label('Target Participants'),

                                                Forms\Components\TextInput::make('registered_participants')
                                                    ->numeric()
                                                    ->default(0)
                                                    ->label('Registered Participants'),

                                                Forms\Components\TextInput::make('completed_participants')
                                                    ->numeric()
                                                    ->default(0)
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
                                                    ->label('Duration (Hours)'),

                                                Forms\Components\TextInput::make('duration_days')
                                                    ->numeric()
                                                    ->suffix('days')
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
                                                    ->label('End Date'),

                                                Forms\Components\TimePicker::make('session_time')
                                                    ->label('Session Time'),
                                            ]),

                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\DatePicker::make('registration_deadline')
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
                                                    ->label('Total Budget'),

                                                Forms\Components\TextInput::make('allocated_budget')
                                                    ->numeric()
                                                    ->default(0)
                                                    ->prefix('K')
                                                    ->label('Allocated Budget'),

                                                Forms\Components\TextInput::make('spent_amount')
                                                    ->numeric()
                                                    ->default(0)
                                                    ->prefix('K')
                                                    ->label('Spent Amount'),
                                            ]),

                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('cost_per_participant')
                                                    ->numeric()
                                                    ->prefix('K')
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
                                                    ->label('Target Completion Rate'),

                                                Forms\Components\TextInput::make('satisfaction_target')
                                                    ->numeric()
                                                    ->suffix('%')
                                                    ->default(85)
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
                Tables\Actions\Action::make('send_invitation')
                    ->icon('heroicon-o-envelope')
                    ->color('primary')
                    ->form([
                        Forms\Components\Textarea::make('message')
                            ->required()
                            ->default('You are invited to participate in our empowerment program. Please register before the deadline.')
                            ->label('Invitation Message'),
                    ])
                    ->action(function (Empowerment $record, array $data) {
                        // Send SMS to ward users
                        $users = User::where('ward_id', $record->ward_id)->whereNotNull('phone')->get();
                        $smsService = new SmsService();
                        $count = 0;

                        foreach ($users as $user) {
                            $message = "EMPOWERMENT PROGRAM: {$record->title}. {$data['message']} Contact us for registration.";
                            $smsService->sendSms($user->phone, $message);
                            $count++;
                        }

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
                    ->visible(fn () => checkEmpowermentReadPermission()),

                Tables\Actions\EditAction::make()
                    ->visible(fn () => checkEmpowermentUpdatePermission()),

                Tables\Actions\DeleteAction::make()
                    ->visible(fn () => checkEmpowermentDeletePermission()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => checkEmpowermentDeletePermission()),
                ]),
            ])
            ->defaultSort('start_date', 'desc');
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
}
