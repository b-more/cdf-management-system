<?php

// ===============================================
// BudgetLineResource.php
// ===============================================

namespace App\Filament\Resources;

use App\Filament\Resources\BudgetLineResource\Pages;
use App\Models\BudgetLine;
use App\Models\FundAllocation;
use App\Models\CommunityProject;
use App\Models\DisasterProject;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class BudgetLineResource extends Resource
{
    protected static ?string $model = BudgetLine::class;
    protected static ?string $navigationIcon = 'heroicon-o-calculator';
    protected static ?string $navigationGroup = 'Financial Management';
    protected static ?int $navigationSort = 4;

    public static function shouldRegisterNavigation(): bool
    {
        return checkBudgetLineReadPermission();
    }

    public static function canCreate(): bool
    {
        return checkBudgetLineCreatePermission();
    }

    public static function canEdit($record): bool
    {
        return checkBudgetLineUpdatePermission();
    }

    public static function canDelete($record): bool
    {
        return checkBudgetLineDeletePermission();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Budget Line')
                    ->tabs([
                        Tabs\Tab::make('Basic Information')
                            ->schema([
                                Section::make('Budget Line Information')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('budget_code')
                                                    ->required()
                                                    ->maxLength(50)
                                                    ->unique(ignoreRecord: true)
                                                    ->label('Budget Code'),

                                                Forms\Components\TextInput::make('line_item')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->label('Budget Line Item'),
                                            ]),

                                        Forms\Components\Textarea::make('description')
                                            ->required()
                                            ->rows(3)
                                            ->columnSpanFull()
                                            ->label('Description'),

                                        Grid::make(3)
                                            ->schema([
                                                Forms\Components\Select::make('category')
                                                    ->options([
                                                        'Personnel' => 'Personnel Costs',
                                                        'Materials' => 'Materials & Supplies',
                                                        'Equipment' => 'Equipment',
                                                        'Services' => 'Services',
                                                        'Travel' => 'Travel & Transport',
                                                        'Utilities' => 'Utilities',
                                                        'Maintenance' => 'Maintenance',
                                                        'Training' => 'Training & Capacity Building',
                                                        'Overhead' => 'Overhead Costs',
                                                        'Contingency' => 'Contingency',
                                                        'Other' => 'Other',
                                                    ])
                                                    ->required()
                                                    ->searchable(),

                                                Forms\Components\Select::make('priority')
                                                    ->options([
                                                        'Essential' => 'Essential',
                                                        'Important' => 'Important',
                                                        'Optional' => 'Optional',
                                                        'Contingent' => 'Contingent',
                                                    ])
                                                    ->required()
                                                    ->default('Important'),

                                                Forms\Components\Select::make('status')
                                                    ->options([
                                                        'Draft' => 'Draft',
                                                        'Approved' => 'Approved',
                                                        'Active' => 'Active',
                                                        'Completed' => 'Completed',
                                                        'On_Hold' => 'On Hold',
                                                        'Cancelled' => 'Cancelled',
                                                    ])
                                                    ->required()
                                                    ->default('Draft'),
                                            ]),
                                    ]),

                                Section::make('Project/Fund Reference')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\Select::make('fund_allocation_id')
                                                    ->relationship('fundAllocation', 'title')
                                                    ->searchable()
                                                    ->preload()
                                    ->label('Fund Allocation'),

                                Forms\Components\Select::make('budgetable_type')
                                    ->options([
                                        'App\\Models\\CommunityProject' => 'Community Project',
                                        'App\\Models\\DisasterProject' => 'Disaster Project',
                                        'App\\Models\\EmpowermentGrant' => 'Empowerment Grant',
                                    ])
                                    ->reactive()
                                    ->label('Budget For'),
                            ]),

                        Forms\Components\Select::make('budgetable_id')
                            ->options(function (Forms\Get $get) {
                                $type = $get('budgetable_type');
                                if ($type === 'App\\Models\\CommunityProject') {
                                    return CommunityProject::pluck('title', 'id');
                                } elseif ($type === 'App\\Models\\DisasterProject') {
                                    return DisasterProject::pluck('title', 'id');
                                }
                                return [];
                            })
                            ->searchable()
                            ->label('Select Project/Grant')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]),

            Tabs\Tab::make('Financial Details')
                ->schema([
                    Section::make('Budget Amounts')
                        ->schema([
                            Grid::make(3)
                                ->schema([
                                    Forms\Components\TextInput::make('budgeted_amount')
                                        ->numeric()
                                        ->required()
                                        ->prefix('K')
                                        ->label('Budgeted Amount'),

                                    Forms\Components\TextInput::make('allocated_amount')
                                        ->numeric()
                                        ->default(0)
                                        ->prefix('K')
                                        ->label('Allocated Amount'),

                                    Forms\Components\TextInput::make('spent_amount')
                                        ->numeric()
                                        ->default(0)
                                        ->prefix('K')
                                        ->label('Spent Amount'),
                                ]),

                            Grid::make(3)
                                ->schema([
                                    Forms\Components\TextInput::make('committed_amount')
                                        ->numeric()
                                        ->default(0)
                                        ->prefix('K')
                                        ->label('Committed Amount'),

                                    Forms\Components\TextInput::make('available_amount')
                                        ->numeric()
                                        ->prefix('K')
                                        ->label('Available Amount')
                                        ->disabled(),

                                    Forms\Components\TextInput::make('variance_amount')
                                        ->numeric()
                                        ->prefix('K')
                                        ->label('Variance Amount')
                                        ->disabled(),
                                ]),
                        ]),

                    Section::make('Budget Control')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    Forms\Components\TextInput::make('unit_cost')
                                        ->numeric()
                                        ->prefix('K')
                                        ->label('Unit Cost'),

                                    Forms\Components\TextInput::make('quantity')
                                        ->numeric()
                                        ->default(1)
                                        ->label('Quantity'),
                                ]),

                            Grid::make(3)
                                ->schema([
                                    Forms\Components\TextInput::make('budget_percentage')
                                        ->numeric()
                                        ->suffix('%')
                                        ->label('Budget Percentage'),

                                    Forms\Components\TextInput::make('utilization_rate')
                                        ->numeric()
                                        ->suffix('%')
                                        ->label('Utilization Rate')
                                        ->disabled(),

                                    Forms\Components\Select::make('variance_type')
                                        ->options([
                                            'Favorable' => 'Favorable',
                                            'Unfavorable' => 'Unfavorable',
                                            'Neutral' => 'Neutral',
                                        ])
                                        ->label('Variance Type'),
                                ]),
                        ])
                        ->collapsible(),
                ]),

            Tabs\Tab::make('Timeline & Approval')
                ->schema([
                    Section::make('Timeline')
                        ->schema([
                            Grid::make(3)
                                ->schema([
                                    Forms\Components\DatePicker::make('budget_period_start')
                                        ->required()
                                        ->label('Budget Period Start'),

                                    Forms\Components\DatePicker::make('budget_period_end')
                                        ->required()
                                        ->label('Budget Period End'),

                                    Forms\Components\DatePicker::make('approval_date')
                                        ->label('Approval Date'),
                                ]),

                            Grid::make(2)
                                ->schema([
                                    Forms\Components\DatePicker::make('first_expenditure_date')
                                        ->label('First Expenditure Date'),

                                    Forms\Components\DatePicker::make('last_expenditure_date')
                                        ->label('Last Expenditure Date'),
                                ]),
                        ]),

                    Section::make('Management & Approval')
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

                                    Forms\Components\Select::make('approved_by_id')
                                        ->relationship('approvedBy', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->label('Approved By'),
                                ]),

                            Forms\Components\Textarea::make('approval_notes')
                                ->rows(3)
                                ->columnSpanFull()
                                ->label('Approval Notes'),

                            Forms\Components\Textarea::make('revision_notes')
                                ->rows(3)
                                ->columnSpanFull()
                                ->label('Revision Notes'),
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
            Tables\Columns\TextColumn::make('budget_code')
                ->searchable()
                ->sortable()
                ->weight('bold')
                ->copyable(),

            Tables\Columns\TextColumn::make('line_item')
                ->searchable()
                ->limit(30)
                ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                    $state = $column->getState();
                    return strlen($state) > 30 ? $state : null;
                }),

            Tables\Columns\BadgeColumn::make('category')
                ->colors([
                    'primary' => 'Personnel',
                    'success' => 'Materials',
                    'info' => 'Equipment',
                    'warning' => 'Services',
                    'danger' => 'Travel',
                    'secondary' => ['Utilities', 'Maintenance', 'Training', 'Overhead', 'Contingency', 'Other'],
                ]),

            Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'secondary' => 'Draft',
                    'warning' => 'Approved',
                    'success' => ['Active', 'Completed'],
                    'danger' => ['On_Hold', 'Cancelled'],
                ]),

            Tables\Columns\TextColumn::make('budgeted_amount')
                ->money('ZMW')
                ->sortable()
                ->label('Budgeted'),

            Tables\Columns\TextColumn::make('spent_amount')
                ->money('ZMW')
                ->sortable()
                ->label('Spent'),

            Tables\Columns\TextColumn::make('available_amount')
                ->money('ZMW')
                ->getStateUsing(fn ($record) => $record->allocated_amount - $record->spent_amount - $record->committed_amount)
                ->color(fn ($state) => $state > 0 ? 'success' : 'danger')
                ->label('Available'),

            Tables\Columns\TextColumn::make('utilization_rate')
                ->suffix('%')
                ->getStateUsing(fn ($record) => $record->budgeted_amount > 0 ?
                    round(($record->spent_amount / $record->budgeted_amount) * 100, 1) : 0)
                ->badge()
                ->color(fn ($state) => match (true) {
                    $state <= 50 => 'success',
                    $state <= 80 => 'warning',
                    $state <= 100 => 'primary',
                    default => 'danger',
                })
                ->label('Utilization'),

            Tables\Columns\BadgeColumn::make('priority')
                ->colors([
                    'danger' => 'Essential',
                    'warning' => 'Important',
                    'primary' => 'Optional',
                    'secondary' => 'Contingent',
                ]),

            Tables\Columns\TextColumn::make('budgetable.title')
                ->label('Project/Grant')
                ->limit(25)
                ->toggleable(),

            Tables\Columns\TextColumn::make('budget_period_start')
                ->date()
                ->sortable()
                ->label('Period Start'),

            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('category'),
            Tables\Filters\SelectFilter::make('status'),
            Tables\Filters\SelectFilter::make('priority'),

            Tables\Filters\Filter::make('over_budget')
                ->query(fn (Builder $query): Builder =>
                    $query->whereRaw('spent_amount > budgeted_amount')
                )
                ->label('Over Budget'),

            Tables\Filters\Filter::make('under_utilized')
                ->query(fn (Builder $query): Builder =>
                    $query->whereRaw('(spent_amount / budgeted_amount * 100) < 50')
                )
                ->label('Under Utilized'),
        ])
        ->actions([
            Tables\Actions\ViewAction::make()
                ->visible(fn () => checkBudgetLineReadPermission()),

            Tables\Actions\EditAction::make()
                ->visible(fn () => checkBudgetLineUpdatePermission()),

            Tables\Actions\DeleteAction::make()
                ->visible(fn () => checkBudgetLineDeletePermission()),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make()
                    ->visible(fn () => checkBudgetLineDeletePermission()),
            ]),
        ])
        ->defaultSort('budget_period_start', 'desc');
}

public static function getPages(): array
{
    return [
        'index' => Pages\ListBudgetLines::route('/'),
        'create' => Pages\CreateBudgetLine::route('/create'),
        //'view' => Pages\ViewBudgetLine::route('/{record}'),
        'edit' => Pages\EditBudgetLine::route('/{record}/edit'),
    ];
}
}
