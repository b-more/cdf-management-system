<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MonitoringReportResource\Pages;
use App\Models\MonitoringReport;
use App\Models\CommunityProject;
use App\Models\DisasterProject;
use App\Models\Ward;
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

class MonitoringReportResource extends Resource
{
    protected static ?string $model = MonitoringReport::class;
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'Monitoring & Evaluation';
    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return checkMonitoringReportReadPermission();
    }

    public static function canCreate(): bool
    {
        return checkMonitoringReportCreatePermission();
    }

    public static function canEdit($record): bool
    {
        return checkMonitoringReportUpdatePermission();
    }

    public static function canDelete($record): bool
    {
        return checkMonitoringReportDeletePermission();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Monitoring Report')
                    ->tabs([
                        Tabs\Tab::make('Basic Information')
                            ->schema([
                                Section::make('Report Information')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('report_code')
                                                    ->required()
                                                    ->maxLength(50)
                                                    ->unique(ignoreRecord: true)
                                                    ->label('Report Code'),

                                                Forms\Components\Select::make('report_type')
                                                    ->options([
                                                        'Progress' => 'Progress Report',
                                                        'Completion' => 'Completion Report',
                                                        'Financial' => 'Financial Report',
                                                        'Monitoring' => 'Monitoring Visit',
                                                        'Evaluation' => 'Project Evaluation',
                                                        'Issue' => 'Issue Report',
                                                        'Milestone' => 'Milestone Report',
                                                        'Quality' => 'Quality Assessment',
                                                        'Risk' => 'Risk Assessment',
                                                        'Other' => 'Other',
                                                    ])
                                                    ->required()
                                                    ->searchable(),
                                            ]),

                                        Forms\Components\TextInput::make('title')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpanFull()
                                            ->label('Report Title'),

                                        Forms\Components\RichEditor::make('executive_summary')
                                            ->columnSpanFull()
                                            ->label('Executive Summary'),

                                        Forms\Components\RichEditor::make('content')
                                            ->required()
                                            ->columnSpanFull()
                                            ->label('Detailed Report Content'),
                                    ]),

                                Section::make('Project Reference')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\Select::make('reportable_type')
                                                    ->options([
                                                        'App\\Models\\CommunityProject' => 'Community Project',
                                                        'App\\Models\\DisasterProject' => 'Disaster Project',
                                                    ])
                                                    ->required()
                                                    ->reactive()
                                                    ->label('Project Type'),

                                                Forms\Components\Select::make('reportable_id')
                                                    ->options(function (Forms\Get $get) {
                                                        $type = $get('reportable_type');
                                                        if ($type === 'App\\Models\\CommunityProject') {
                                                            return CommunityProject::pluck('title', 'id');
                                                        } elseif ($type === 'App\\Models\\DisasterProject') {
                                                            return DisasterProject::pluck('title', 'id');
                                                        }
                                                        return [];
                                                    })
                                                    ->required()
                                                    ->searchable()
                                                    ->label('Project'),
                                            ]),

                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\Select::make('ward_id')
                                                    ->relationship('ward', 'name')
                                                    ->searchable()
                                                    ->preload()
                                                    ->label('Ward'),

                                                Forms\Components\Select::make('contractor_name')
                                                    ->options([
                                                        'ABC Construction' => 'ABC Construction Ltd',
                                                        'DEF Builders' => 'DEF Builders',
                                                        'GHI Engineering' => 'GHI Engineering',
                                                        'Community Group' => 'Community Group',
                                                        'Other' => 'Other',
                                                    ])
                                                    ->searchable()
                                                    ->label('Contractor/Implementer'),
                                            ]),
                                    ])
                                    ->collapsible(),
                            ]),

                        Tabs\Tab::make('Progress & Quality')
                            ->schema([
                                Section::make('Progress Assessment')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                Forms\Components\TextInput::make('progress_percentage')
                                                    ->numeric()
                                                    ->suffix('%')
                                                    ->required()
                                                    ->default(0)
                                                    ->minValue(0)
                                                    ->maxValue(100)
                                                    ->label('Overall Progress'),

                                                Forms\Components\TextInput::make('physical_progress')
                                                    ->numeric()
                                                    ->suffix('%')
                                                    ->default(0)
                                                    ->minValue(0)
                                                    ->maxValue(100)
                                                    ->label('Physical Progress'),

                                                Forms\Components\TextInput::make('financial_progress')
                                                    ->numeric()
                                                    ->suffix('%')
                                                    ->default(0)
                                                    ->minValue(0)
                                                    ->maxValue(100)
                                                    ->label('Financial Progress'),
                                            ]),

                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\Select::make('status')
                                                    ->options([
                                                        'Draft' => 'Draft',
                                                        'Submitted' => 'Submitted',
                                                        'Under_Review' => 'Under Review',
                                                        'Reviewed' => 'Reviewed',
                                                        'Approved' => 'Approved',
                                                        'Published' => 'Published',
                                                        'Archived' => 'Archived',
                                                    ])
                                                    ->required()
                                                    ->default('Draft'),

                                                Forms\Components\Select::make('overall_rating')
                                                    ->options([
                                                        'Excellent' => 'Excellent',
                                                        'Good' => 'Good',
                                                        'Satisfactory' => 'Satisfactory',
                                                        'Needs_Improvement' => 'Needs Improvement',
                                                        'Poor' => 'Poor',
                                                    ])
                                                    ->label('Overall Rating'),
                                            ]),
                                    ]),

                                Section::make('Quality Assessment')
                                    ->schema([
                                        Grid::make(4)
                                            ->schema([
                                                Forms\Components\Select::make('quality_rating')
                                                    ->options([
                                                        '5' => 'Excellent (5)',
                                                        '4' => 'Good (4)',
                                                        '3' => 'Average (3)',
                                                        '2' => 'Below Average (2)',
                                                        '1' => 'Poor (1)',
                                                    ])
                                                    ->label('Quality Rating'),

                                                Forms\Components\Select::make('safety_rating')
                                                    ->options([
                                                        '5' => 'Excellent (5)',
                                                        '4' => 'Good (4)',
                                                        '3' => 'Average (3)',
                                                        '2' => 'Below Average (2)',
                                                        '1' => 'Poor (1)',
                                                    ])
                                                    ->label('Safety Rating'),

                                                Forms\Components\Select::make('environmental_compliance')
                                                    ->options([
                                                        'Fully_Compliant' => 'Fully Compliant',
                                                        'Mostly_Compliant' => 'Mostly Compliant',
                                                        'Partially_Compliant' => 'Partially Compliant',
                                                        'Non_Compliant' => 'Non Compliant',
                                                    ])
                                                    ->label('Environmental Compliance'),

                                                Forms\Components\Select::make('community_satisfaction')
                                                    ->options([
                                                        'Very_Satisfied' => 'Very Satisfied',
                                                        'Satisfied' => 'Satisfied',
                                                        'Neutral' => 'Neutral',
                                                        'Dissatisfied' => 'Dissatisfied',
                                                        'Very_Dissatisfied' => 'Very Dissatisfied',
                                                    ])
                                                    ->label('Community Satisfaction'),
                                            ]),

                                        Forms\Components\Textarea::make('quality_notes')
                                            ->rows(3)
                                            ->columnSpanFull()
                                            ->label('Quality Assessment Notes'),
                                    ])
                                    ->collapsible(),
                            ]),

                        Tabs\Tab::make('Financial & Timeline')
                            ->schema([
                                Section::make('Financial Information')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                Forms\Components\TextInput::make('budget_allocated')
                                                    ->numeric()
                                                    ->prefix('K')
                                                    ->label('Budget Allocated'),

                                                Forms\Components\TextInput::make('amount_spent')
                                                    ->numeric()
                                                    ->prefix('K')
                                                    ->label('Amount Spent'),

                                                Forms\Components\TextInput::make('remaining_budget')
                                                    ->numeric()
                                                    ->prefix('K')
                                                    ->label('Remaining Budget')
                                                    ->disabled(),
                                            ]),

                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('budget_variance')
                                                    ->numeric()
                                                    ->prefix('K')
                                                    ->label('Budget Variance'),

                                                Forms\Components\Select::make('budget_status')
                                                    ->options([
                                                        'On_Budget' => 'On Budget',
                                                        'Under_Budget' => 'Under Budget',
                                                        'Over_Budget' => 'Over Budget',
                                                        'Budget_Exhausted' => 'Budget Exhausted',
                                                    ])
                                                    ->label('Budget Status'),
                                            ]),
                                    ]),

                                Section::make('Timeline Information')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                Forms\Components\DatePicker::make('reporting_period_start')
                                                    ->required()
                                                    ->label('Reporting Period Start'),

                                                Forms\Components\DatePicker::make('reporting_period_end')
                                                    ->required()
                                                    ->label('Reporting Period End'),

                                                Forms\Components\DatePicker::make('visit_date')
                                                    ->label('Site Visit Date'),
                                            ]),

                                        Grid::make(3)
                                            ->schema([
                                                Forms\Components\DatePicker::make('expected_completion')
                                                    ->label('Expected Completion'),

                                                Forms\Components\DatePicker::make('revised_completion')
                                                    ->label('Revised Completion'),

                                                Forms\Components\TextInput::make('delay_days')
                                                    ->numeric()
                                                    ->suffix('days')
                                                    ->label('Delay (Days)'),
                                            ]),
                                    ])
                                    ->collapsible(),
                            ]),

                        Tabs\Tab::make('Issues & Recommendations')
                            ->schema([
                                Section::make('Issues & Challenges')
                                    ->schema([
                                        Forms\Components\Textarea::make('issues_identified')
                                            ->rows(4)
                                            ->columnSpanFull()
                                            ->label('Issues Identified'),

                                        Forms\Components\Textarea::make('challenges_faced')
                                            ->rows(4)
                                            ->columnSpanFull()
                                            ->label('Challenges Faced'),

                                        Forms\Components\Select::make('risk_level')
                                            ->options([
                                                'Low' => 'Low Risk',
                                                'Medium' => 'Medium Risk',
                                                'High' => 'High Risk',
                                                'Critical' => 'Critical Risk',
                                            ])
                                            ->label('Project Risk Level'),
                                    ]),

                                Section::make('Recommendations & Next Steps')
                                    ->schema([
                                        Forms\Components\Textarea::make('recommendations')
                                            ->rows(4)
                                            ->columnSpanFull()
                                            ->label('Recommendations'),

                                        Forms\Components\Textarea::make('next_steps')
                                            ->rows(3)
                                            ->columnSpanFull()
                                            ->label('Next Steps'),

                                        Forms\Components\Textarea::make('corrective_actions')
                                            ->rows(3)
                                            ->columnSpanFull()
                                            ->label('Corrective Actions Required'),
                                    ]),
                            ]),

                        Tabs\Tab::make('Management')
                            ->schema([
                                Section::make('Report Management')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\Select::make('prepared_by_id')
                                                    ->relationship('preparedBy', 'name')
                                                    ->required()
                                                    ->searchable()
                                                    ->preload()
                                                    ->default(Auth::id())
                                                    ->label('Prepared By'),

                                                Forms\Components\Select::make('reviewed_by_id')
                                                    ->relationship('reviewedBy', 'name')
                                                    ->searchable()
                                                    ->preload()
                                                    ->label('Reviewed By'),
                                            ]),

                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\DatePicker::make('submission_deadline')
                                                    ->label('Submission Deadline'),

                                                Forms\Components\DatePicker::make('review_deadline')
                                                    ->label('Review Deadline'),
                                            ]),
                                    ]),

                                Section::make('Additional Information')
                                    ->schema([
                                        Forms\Components\Textarea::make('lessons_learned')
                                            ->rows(3)
                                            ->columnSpanFull()
                                            ->label('Lessons Learned'),

                                        Forms\Components\Textarea::make('best_practices')
                                            ->rows(3)
                                            ->columnSpanFull()
                                            ->label('Best Practices'),

                                        Forms\Components\Textarea::make('stakeholder_feedback')
                                            ->rows(3)
                                            ->columnSpanFull()
                                            ->label('Stakeholder Feedback'),
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
                Tables\Columns\TextColumn::make('report_code')
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

                Tables\Columns\BadgeColumn::make('report_type')
                    ->colors([
                        'primary' => 'Progress',
                        'success' => 'Completion',
                        'warning' => 'Financial',
                        'info' => 'Monitoring',
                        'danger' => 'Issue',
                        'secondary' => ['Evaluation', 'Milestone', 'Quality', 'Risk', 'Other'],
                    ]),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'Draft',
                        'primary' => 'Submitted',
                        'warning' => ['Under_Review', 'Reviewed'],
                        'success' => ['Approved', 'Published'],
                        'danger' => 'Archived',
                    ]),

                Tables\Columns\TextColumn::make('reportable.title')
                    ->label('Project')
                    ->searchable()
                    ->limit(25),

                Tables\Columns\TextColumn::make('progress_percentage')
                    ->suffix('%')
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state >= 90 => 'success',
                        $state >= 70 => 'warning',
                        $state >= 50 => 'primary',
                        default => 'danger',
                    })
                    ->label('Progress'),

                Tables\Columns\BadgeColumn::make('overall_rating')
                    ->colors([
                        'success' => 'Excellent',
                        'primary' => 'Good',
                        'warning' => 'Satisfactory',
                        'danger' => ['Needs_Improvement', 'Poor'],
                    ])
                    ->label('Rating'),

                Tables\Columns\TextColumn::make('quality_rating')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        '5' => 'success',
                        '4' => 'primary',
                        '3' => 'warning',
                        '2', '1' => 'danger',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn ($state) => $state ? "{$state}/5" : 'N/A')
                    ->label('Quality'),

                Tables\Columns\TextColumn::make('ward.name')
                    ->label('Ward')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('preparedBy.name')
                    ->label('Prepared By')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('reporting_period_start')
                    ->date()
                    ->sortable()
                    ->label('Period Start'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('report_type'),
                Tables\Filters\SelectFilter::make('status'),
                Tables\Filters\SelectFilter::make('overall_rating'),
                Tables\Filters\SelectFilter::make('quality_rating'),
                Tables\Filters\SelectFilter::make('ward')
                    ->relationship('ward', 'name'),

                Tables\Filters\Filter::make('progress_range')
                    ->form([
                        Forms\Components\TextInput::make('min_progress')
                            ->numeric()
                            ->label('Min Progress %'),
                        Forms\Components\TextInput::make('max_progress')
                            ->numeric()
                            ->label('Max Progress %'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['min_progress'],
                                fn (Builder $query, $progress): Builder => $query->where('progress_percentage', '>=', $progress),
                            )
                            ->when(
                                $data['max_progress'],
                                fn (Builder $query, $progress): Builder => $query->where('progress_percentage', '<=', $progress),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('publish')
                    ->icon('heroicon-o-globe-alt')
                    ->color('success')
                    ->action(function (MonitoringReport $record) {
                        $record->update(['status' => 'Published']);

                        Notification::make()
                            ->title('Report Published')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (MonitoringReport $record) =>
                        $record->status === 'Approved' &&
                        checkMonitoringReportUpdatePermission()
                    ),

                Tables\Actions\ViewAction::make()
                    ->visible(fn () => checkMonitoringReportReadPermission()),

                Tables\Actions\EditAction::make()
                    ->visible(fn () => checkMonitoringReportUpdatePermission()),

                Tables\Actions\DeleteAction::make()
                    ->visible(fn () => checkMonitoringReportDeletePermission()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => checkMonitoringReportDeletePermission()),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMonitoringReports::route('/'),
            'create' => Pages\CreateMonitoringReport::route('/create'),
            //'view' => Pages\ViewMonitoringReport::route('/{record}'),
            'edit' => Pages\EditMonitoringReport::route('/{record}/edit'),
        ];
    }
}
