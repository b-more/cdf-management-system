<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectTimelineResource\Pages;
use App\Models\ProjectTimeline;
use App\Models\CommunityProject;
use App\Models\DisasterProject;
use App\Models\User;
use App\Models\AuditTrail;
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
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;

class ProjectTimelineResource extends Resource
{
    protected static ?string $model = ProjectTimeline::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Project Timelines';

    protected static ?string $modelLabel = 'Project Timeline';

    protected static ?string $pluralModelLabel = 'Project Timelines';

    protected static ?string $navigationGroup = 'Project Management';

    protected static ?int $navigationSort = 3;

    public static function shouldRegisterNavigation(): bool
    {
        return checkProjectTimelineReadPermission();
    }

    public static function canCreate(): bool
    {
        return checkProjectTimelineCreatePermission();
    }

    public static function canEdit($record): bool
    {
        return checkProjectTimelineUpdatePermission();
    }

    public static function canDelete($record): bool
    {
        return checkProjectTimelineDeletePermission();
    }

    public static function canView($record): bool
    {
        return checkProjectTimelineReadPermission();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Timeline Details')
                    ->tabs([
                        Tabs\Tab::make('Basic Information')
                            ->schema([
                                Section::make('Milestone Details')
                                    ->schema([
                                        Forms\Components\TextInput::make('milestone_code')
                                            ->label('Milestone Code')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->default(function () {
                                                return 'MS-' . strtoupper(uniqid());
                                            })
                                            ->maxLength(50)
                                            ->columnSpan(1),

                                        Forms\Components\Select::make('priority')
                                            ->label('Priority Level')
                                            ->options([
                                                'Low' => 'Low',
                                                'Medium' => 'Medium',
                                                'High' => 'High',
                                                'Critical' => 'Critical',
                                            ])
                                            ->default('Medium')
                                            ->required()
                                            ->columnSpan(1),

                                        Forms\Components\TextInput::make('title')
                                            ->label('Milestone Title')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpanFull(),

                                        Forms\Components\Textarea::make('description')
                                            ->label('Description')
                                            ->rows(3)
                                            ->maxLength(1000)
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2),

                                Section::make('Project Association')
                                    ->schema([
                                        Forms\Components\Select::make('project_type')
                                            ->label('Project Type')
                                            ->options([
                                                'App\\Models\\CommunityProject' => 'Community Project',
                                                'App\\Models\\DisasterProject' => 'Disaster Project',
                                            ])
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated(fn (Forms\Set $set) => $set('project_id', null)),

                                        Forms\Components\Select::make('project_id')
                                            ->label('Project')
                                            ->options(function (Forms\Get $get) {
                                                $projectType = $get('project_type');
                                                if ($projectType === 'App\\Models\\CommunityProject') {
                                                    return CommunityProject::pluck('title', 'id');
                                                } elseif ($projectType === 'App\\Models\\DisasterProject') {
                                                    return DisasterProject::pluck('title', 'id');
                                                }
                                                return [];
                                            })
                                            ->required()
                                            ->searchable()
                                            ->preload(),
                                    ])
                                    ->columns(2),
                            ]),

                        Tabs\Tab::make('Timeline & Progress')
                            ->schema([
                                Section::make('Planned Timeline')
                                    ->schema([
                                        Forms\Components\DatePicker::make('planned_start_date')
                                            ->label('Planned Start Date')
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get, $state) {
                                                $endDate = $get('planned_end_date');
                                                if ($state && $endDate) {
                                                    $duration = \Carbon\Carbon::parse($state)->diffInDays(\Carbon\Carbon::parse($endDate)) + 1;
                                                    $set('planned_duration', $duration);
                                                }
                                            }),

                                        Forms\Components\DatePicker::make('planned_end_date')
                                            ->label('Planned End Date')
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get, $state) {
                                                $startDate = $get('planned_start_date');
                                                if ($startDate && $state) {
                                                    $duration = \Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($state)) + 1;
                                                    $set('planned_duration', $duration);
                                                }
                                            })
                                            ->after('planned_start_date'),

                                        Forms\Components\TextInput::make('planned_duration')
                                            ->label('Planned Duration (Days)')
                                            ->numeric()
                                            ->readonly()
                                            ->dehydrated(true),
                                    ])
                                    ->columns(3),

                                Section::make('Actual Timeline')
                                    ->schema([
                                        Forms\Components\DatePicker::make('actual_start_date')
                                            ->label('Actual Start Date')
                                            ->live()
                                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get, $state) {
                                                $endDate = $get('actual_end_date');
                                                if ($state && $endDate) {
                                                    $duration = \Carbon\Carbon::parse($state)->diffInDays(\Carbon\Carbon::parse($endDate)) + 1;
                                                    $set('actual_duration', $duration);

                                                    // Calculate variance
                                                    $plannedDuration = $get('planned_duration');
                                                    if ($plannedDuration) {
                                                        $variance = $duration - $plannedDuration;
                                                        $set('variance_days', $variance);
                                                    }
                                                }
                                            }),

                                        Forms\Components\DatePicker::make('actual_end_date')
                                            ->label('Actual End Date')
                                            ->live()
                                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get, $state) {
                                                $startDate = $get('actual_start_date');
                                                if ($startDate && $state) {
                                                    $duration = \Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($state)) + 1;
                                                    $set('actual_duration', $duration);

                                                    // Calculate variance
                                                    $plannedDuration = $get('planned_duration');
                                                    if ($plannedDuration) {
                                                        $variance = $duration - $plannedDuration;
                                                        $set('variance_days', $variance);
                                                    }
                                                }
                                            })
                                            ->after('actual_start_date'),

                                        Forms\Components\TextInput::make('actual_duration')
                                            ->label('Actual Duration (Days)')
                                            ->numeric()
                                            ->readonly()
                                            ->dehydrated(true),

                                        Forms\Components\TextInput::make('variance_days')
                                            ->label('Variance (Days)')
                                            ->numeric()
                                            ->readonly()
                                            ->dehydrated(true)
                                            ->helperText('Positive = Over schedule, Negative = Ahead of schedule'),
                                    ])
                                    ->columns(2),

                                Section::make('Progress & Status')
                                    ->schema([
                                        Forms\Components\Select::make('status')
                                            ->label('Status')
                                            ->options([
                                                'Planned' => 'Planned',
                                                'In Progress' => 'In Progress',
                                                'Completed' => 'Completed',
                                                'Delayed' => 'Delayed',
                                                'On Hold' => 'On Hold',
                                                'Cancelled' => 'Cancelled',
                                            ])
                                            ->default('Planned')
                                            ->required()
                                            ->live(),

                                        Forms\Components\TextInput::make('completion_percentage')
                                            ->label('Completion %')
                                            ->numeric()
                                            ->minValue(0)
                                            ->maxValue(100)
                                            ->default(0)
                                            ->suffix('%')
                                            ->live(),

                                        Forms\Components\Select::make('milestone_type')
                                            ->label('Milestone Type')
                                            ->options([
                                                'Planning' => 'Planning',
                                                'Design' => 'Design',
                                                'Procurement' => 'Procurement',
                                                'Implementation' => 'Implementation',
                                                'Testing' => 'Testing',
                                                'Delivery' => 'Delivery',
                                                'Review' => 'Review',
                                                'Approval' => 'Approval',
                                                'Other' => 'Other',
                                            ])
                                            ->default('Implementation')
                                            ->required(),

                                        Forms\Components\Toggle::make('is_critical_path')
                                            ->label('Critical Path Milestone')
                                            ->helperText('Mark if this milestone is on the critical path'),
                                    ])
                                    ->columns(2),
                            ]),

                        Tabs\Tab::make('Resources & Budget')
                            ->schema([
                                Section::make('Financial Information')
                                    ->schema([
                                        Forms\Components\TextInput::make('budgeted_cost')
                                            ->label('Budgeted Cost')
                                            ->numeric()
                                            ->prefix('ZMW')
                                            ->live()
                                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get, $state) {
                                                $actualCost = $get('actual_cost');
                                                if ($state && $actualCost) {
                                                    $variance = $actualCost - $state;
                                                    $set('cost_variance', $variance);
                                                }
                                            }),

                                        Forms\Components\TextInput::make('actual_cost')
                                            ->label('Actual Cost')
                                            ->numeric()
                                            ->prefix('ZMW')
                                            ->live()
                                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get, $state) {
                                                $budgetedCost = $get('budgeted_cost');
                                                if ($budgetedCost && $state) {
                                                    $variance = $state - $budgetedCost;
                                                    $set('cost_variance', $variance);
                                                }
                                            }),

                                        Forms\Components\TextInput::make('cost_variance')
                                            ->label('Cost Variance')
                                            ->numeric()
                                            ->prefix('ZMW')
                                            ->readonly()
                                            ->dehydrated(true)
                                            ->helperText('Positive = Over budget, Negative = Under budget'),
                                    ])
                                    ->columns(3),

                                Section::make('Resources & Dependencies')
                                    ->schema([
                                        Forms\Components\Textarea::make('required_resources')
                                            ->label('Required Resources')
                                            ->rows(3)
                                            ->maxLength(1000)
                                            ->placeholder('List equipment, materials, personnel required...'),

                                        Forms\Components\Textarea::make('dependencies')
                                            ->label('Dependencies')
                                            ->rows(3)
                                            ->maxLength(1000)
                                            ->placeholder('List other milestones or external dependencies...'),

                                        Forms\Components\Textarea::make('deliverables')
                                            ->label('Expected Deliverables')
                                            ->rows(3)
                                            ->maxLength(1000)
                                            ->placeholder('List expected outputs and deliverables...'),
                                    ])
                                    ->columns(1),
                            ]),

                        Tabs\Tab::make('Management & Notes')
                            ->schema([
                                Section::make('Assignment')
                                    ->schema([
                                        Forms\Components\Select::make('assigned_to_id')
                                            ->label('Assigned To')
                                            ->relationship('assignedTo', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('name')
                                                    ->required()
                                                    ->maxLength(255),
                                                Forms\Components\TextInput::make('email')
                                                    ->email()
                                                    ->required()
                                                    ->maxLength(255),
                                            ]),

                                        Forms\Components\Hidden::make('created_by_id')
                                            ->default(Auth::id()),
                                    ])
                                    ->columns(1),

                                Section::make('Notes & Issues')
                                    ->schema([
                                        Forms\Components\Textarea::make('notes')
                                            ->label('Progress Notes')
                                            ->rows(4)
                                            ->maxLength(2000)
                                            ->placeholder('Add progress updates, observations, and general notes...'),

                                        Forms\Components\Textarea::make('risks_issues')
                                            ->label('Risks & Issues')
                                            ->rows(4)
                                            ->maxLength(2000)
                                            ->placeholder('Document identified risks, issues, and mitigation strategies...'),
                                    ])
                                    ->columns(1),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('milestone_code')
                    ->label('Code')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Milestone Title')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->tooltip(function ($record) {
                        return $record->title;
                    }),

                Tables\Columns\TextColumn::make('project_type')
                    ->label('Project Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'App\\Models\\CommunityProject' => 'success',
                        'App\\Models\\DisasterProject' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'App\\Models\\CommunityProject' => 'Community',
                        'App\\Models\\DisasterProject' => 'Disaster',
                        default => 'Unknown',
                    }),

                Tables\Columns\TextColumn::make('priority')
                    ->label('Priority')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Low' => 'gray',
                        'Medium' => 'warning',
                        'High' => 'danger',
                        'Critical' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Planned' => 'gray',
                        'In Progress' => 'info',
                        'Completed' => 'success',
                        'Delayed' => 'warning',
                        'On Hold' => 'warning',
                        'Cancelled' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('completion_percentage')
                    ->label('Progress')
                    ->suffix('%')
                    ->color(fn ($state): string => match (true) {
                        $state >= 100 => 'success',
                        $state >= 75 => 'info',
                        $state >= 50 => 'warning',
                        $state >= 25 => 'danger',
                        default => 'gray',
                    })
                    ->weight('bold'),

                Tables\Columns\IconColumn::make('is_critical_path')
                    ->label('Critical')
                    ->boolean()
                    ->trueIcon('heroicon-o-exclamation-triangle')
                    ->falseIcon('heroicon-o-minus')
                    ->trueColor('danger')
                    ->falseColor('gray'),

                Tables\Columns\TextColumn::make('planned_start_date')
                    ->label('Start Date')
                    ->date('M j, Y')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('planned_end_date')
                    ->label('End Date')
                    ->date('M j, Y')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('variance_days')
                    ->label('Variance')
                    ->suffix(' days')
                    ->color(fn ($state): string => match (true) {
                        $state > 0 => 'danger',  // Over schedule
                        $state < 0 => 'success', // Ahead of schedule
                        default => 'gray',       // On schedule
                    })
                    ->weight(fn ($state): string => $state != 0 ? 'bold' : 'normal')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('budgeted_cost')
                    ->label('Budget')
                    ->money('ZMW')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('assignedTo.name')
                    ->label('Assigned To')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Planned' => 'Planned',
                        'In Progress' => 'In Progress',
                        'Completed' => 'Completed',
                        'Delayed' => 'Delayed',
                        'On Hold' => 'On Hold',
                        'Cancelled' => 'Cancelled',
                    ])
                    ->multiple(),

                Tables\Filters\SelectFilter::make('priority')
                    ->options([
                        'Low' => 'Low',
                        'Medium' => 'Medium',
                        'High' => 'High',
                        'Critical' => 'Critical',
                    ])
                    ->multiple(),

                Tables\Filters\SelectFilter::make('project_type')
                    ->label('Project Type')
                    ->options([
                        'App\\Models\\CommunityProject' => 'Community Project',
                        'App\\Models\\DisasterProject' => 'Disaster Project',
                    ]),

                Tables\Filters\Filter::make('critical_path')
                    ->label('Critical Path Only')
                    ->query(fn (Builder $query): Builder => $query->where('is_critical_path', true)),

                Tables\Filters\Filter::make('delayed')
                    ->label('Delayed Milestones')
                    ->query(fn (Builder $query): Builder =>
                        $query->where('status', 'Delayed')
                              ->orWhere('variance_days', '>', 0)
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->visible(fn ($record) => checkProjectTimelineReadPermission())
                    ->after(function ($record) {
                        self::logActivity('View', $record, 'Viewed project timeline: ' . $record->title);
                    }),

                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => checkProjectTimelineUpdatePermission())
                    ->mutateFormDataUsing(function (array $data, $record): array {
                        self::logActivity('Update', $record,
                            'Updated project timeline: ' . $record->title,
                            $record->toArray(),
                            $data
                        );
                        return $data;
                    }),

                Tables\Actions\Action::make('mark_completed')
                    ->label('Mark Complete')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Mark Milestone as Completed')
                    ->modalDescription('This will set the completion percentage to 100% and status to Completed.')
                    ->action(function ($record) {
                        $oldData = $record->toArray();
                        $record->update([
                            'status' => 'Completed',
                            'completion_percentage' => 100,
                            'actual_end_date' => now()->toDateString(),
                        ]);

                        self::logActivity('Complete', $record,
                            'Marked timeline as completed: ' . $record->title,
                            $oldData,
                            $record->fresh()->toArray()
                        );

                        Notification::make()
                            ->title('Milestone Completed')
                            ->body('Timeline milestone has been marked as completed.')
                            ->success()
                            ->send();
                    })
                    ->visible(fn ($record) =>
                        checkProjectTimelineUpdatePermission() &&
                        $record->status !== 'Completed'
                    ),

                Tables\Actions\Action::make('update_progress')
                    ->label('Update Progress')
                    ->icon('heroicon-o-arrow-trending-up')
                    ->color('info')
                    ->form([
                        Forms\Components\TextInput::make('completion_percentage')
                            ->label('Completion Percentage')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%')
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'Planned' => 'Planned',
                                'In Progress' => 'In Progress',
                                'Completed' => 'Completed',
                                'Delayed' => 'Delayed',
                                'On Hold' => 'On Hold',
                            ])
                            ->required(),

                        Forms\Components\Textarea::make('progress_notes')
                            ->label('Progress Notes')
                            ->rows(3)
                            ->placeholder('Add notes about the progress update...'),
                    ])
                    ->action(function ($record, array $data) {
                        $oldData = $record->toArray();

                        $updateData = [
                            'completion_percentage' => $data['completion_percentage'],
                            'status' => $data['status'],
                        ];

                        if (!empty($data['progress_notes'])) {
                            $updateData['notes'] = $record->notes . "\n\n" . now()->format('Y-m-d H:i') . ": " . $data['progress_notes'];
                        }

                        if ($data['completion_percentage'] == 100) {
                            $updateData['actual_end_date'] = now()->toDateString();
                            $updateData['status'] = 'Completed';
                        }

                        $record->update($updateData);

                        self::logActivity('Progress Update', $record,
                            'Updated progress for timeline: ' . $record->title . ' to ' . $data['completion_percentage'] . '%',
                            $oldData,
                            $record->fresh()->toArray()
                        );

                        Notification::make()
                            ->title('Progress Updated')
                            ->body('Timeline progress has been updated to ' . $data['completion_percentage'] . '%.')
                            ->success()
                            ->send();
                    })
                    ->visible(fn ($record) => checkProjectTimelineUpdatePermission()),

                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => checkProjectTimelineDeletePermission())
                    ->before(function ($record) {
                        self::logActivity('Delete', $record, 'Deleted project timeline: ' . $record->title);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('bulk_update_status')
                        ->label('Update Status')
                        ->icon('heroicon-o-arrow-path')
                        ->color('info')
                        ->form([
                            Forms\Components\Select::make('status')
                                ->label('New Status')
                                ->options([
                                    'Planned' => 'Planned',
                                    'In Progress' => 'In Progress',
                                    'Completed' => 'Completed',
                                    'Delayed' => 'Delayed',
                                    'On Hold' => 'On Hold',
                                    'Cancelled' => 'Cancelled',
                                ])
                                ->required(),
                        ])
                        ->action(function ($records, array $data) {
                            $updatedCount = 0;
                            foreach ($records as $record) {
                                if (checkProjectTimelineUpdatePermission()) {
                                    $oldData = $record->toArray();
                                    $record->update(['status' => $data['status']]);

                                    self::logActivity('Bulk Status Update', $record,
                                        'Bulk updated status to: ' . $data['status'],
                                        $oldData,
                                        $record->fresh()->toArray()
                                    );
                                    $updatedCount++;
                                }
                            }

                            Notification::make()
                                ->title('Status Updated')
                                ->body($updatedCount . ' timeline(s) status updated to ' . $data['status'])
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => checkProjectTimelineDeletePermission())
                        ->before(function ($records) {
                            foreach ($records as $record) {
                                self::logActivity('Bulk Delete', $record, 'Bulk deleted project timeline: ' . $record->title);
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
                case 'Applicant':
                    // Only see timelines for their projects
                    $query->where(function ($q) use ($user) {
                        $q->where('project_type', 'App\\Models\\CommunityProject')
                          ->whereHas('project', function ($projectQuery) use ($user) {
                              $projectQuery->where('applicant_id', $user->id);
                          })
                          ->orWhere('project_type', 'App\\Models\\DisasterProject')
                          ->whereHas('project', function ($projectQuery) use ($user) {
                              $projectQuery->where('reported_by_id', $user->id);
                          });
                    });
                    break;

                case 'Ward Development Committee':
                case 'Constituency Officer':
                    // Only see timelines for projects in their ward
                    if ($user->ward_id) {
                        $query->where(function ($q) use ($user) {
                            $q->where('project_type', 'App\\Models\\CommunityProject')
                              ->whereHas('project', function ($projectQuery) use ($user) {
                                  $projectQuery->where('ward_id', $user->ward_id);
                              })
                              ->orWhere('project_type', 'App\\Models\\DisasterProject')
                              ->whereHas('project', function ($projectQuery) use ($user) {
                                  $projectQuery->where('ward_id', $user->ward_id);
                              });
                        });
                    }
                    break;

                case 'CDFC Member':
                case 'Admin':
                case 'Super Admin':
                    // Can see all timelines
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
            'index' => Pages\ListProjectTimelines::route('/'),
            'create' => Pages\CreateProjectTimeline::route('/create'),
            'view' => Pages\ViewProjectTimeline::route('/{record}'),
            'edit' => Pages\EditProjectTimeline::route('/{record}/edit'),
        ];
    }

    // Audit Trail Logging Method
    private static function logActivity(string $action, $record, string $description, array $oldValues = [], array $newValues = []): void
    {
        try {
            AuditTrail::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'table_name' => 'project_timelines',
                'record_id' => $record->id,
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
