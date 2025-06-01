<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FundAllocationResource\Pages;
use App\Models\FundAllocation;
use App\Models\Ward;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class FundAllocationResource extends Resource
{
    protected static ?string $model = FundAllocation::class;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Financial Management';
    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return checkFundAllocationReadPermission();
    }

    public static function canCreate(): bool
    {
        return checkFundAllocationCreatePermission();
    }

    public static function canEdit($record): bool
    {
        return checkFundAllocationUpdatePermission();
    }

    public static function canDelete($record): bool
    {
        return checkFundAllocationDeletePermission();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Allocation Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('allocation_code')
                                    ->required()
                                    ->maxLength(50)
                                    ->unique(ignoreRecord: true)
                                    ->label('Allocation Code'),

                                Forms\Components\Select::make('financial_year')
                                    ->options([
                                        '2024' => '2024',
                                        '2025' => '2025',
                                        '2026' => '2026',
                                        '2027' => '2027',
                                        '2028' => '2028',
                                    ])
                                    ->required()
                                    ->default(date('Y'))
                                    ->label('Financial Year'),
                            ]),

                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->label('Allocation Title'),

                        Forms\Components\Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull()
                            ->label('Description'),
                    ]),

                Section::make('Fund Details')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('total_amount')
                                    ->numeric()
                                    ->required()
                                    ->prefix('K')
                                    ->label('Total Amount'),

                                Forms\Components\TextInput::make('allocated_amount')
                                    ->numeric()
                                    ->required()
                                    ->default(0)
                                    ->prefix('K')
                                    ->label('Allocated Amount'),

                                Forms\Components\TextInput::make('disbursed_amount')
                                    ->numeric()
                                    ->default(0)
                                    ->prefix('K')
                                    ->label('Disbursed Amount'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('fund_type')
                                    ->options([
                                        'CDF' => 'Constituency Development Fund',
                                        'Emergency' => 'Emergency Fund',
                                        'Disaster' => 'Disaster Relief Fund',
                                        'Empowerment' => 'Empowerment Fund',
                                        'Infrastructure' => 'Infrastructure Fund',
                                        'Other' => 'Other',
                                    ])
                                    ->required()
                                    ->searchable(),

                                Forms\Components\Select::make('status')
                                    ->options([
                                        'Pending' => 'Pending',
                                        'Approved' => 'Approved',
                                        'Active' => 'Active',
                                        'Completed' => 'Completed',
                                        'Cancelled' => 'Cancelled',
                                    ])
                                    ->required()
                                    ->default('Pending'),
                            ]),
                    ]),

                Section::make('Ward Assignment')
                    ->schema([
                        Forms\Components\Select::make('ward_id')
                            ->relationship('ward', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Specific Ward (Optional)')
                            ->helperText('Leave empty for constituency-wide allocation'),
                    ])
                    ->collapsible(),

                Section::make('Timeline')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Forms\Components\DatePicker::make('allocation_date')
                                    ->required()
                                    ->default(now())
                                    ->label('Allocation Date'),

                                Forms\Components\DatePicker::make('start_date')
                                    ->required()
                                    ->label('Start Date'),

                                Forms\Components\DatePicker::make('end_date')
                                    ->required()
                                    ->label('End Date'),
                            ]),
                    ])
                    ->collapsible(),

                Section::make('Management')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('allocated_by_id')
                                    ->relationship('allocatedBy', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->default(Auth::id())
                                    ->label('Allocated By'),

                                Forms\Components\Select::make('approved_by_id')
                                    ->relationship('approvedBy', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->label('Approved By'),
                            ]),

                        Forms\Components\Textarea::make('remarks')
                            ->rows(3)
                            ->columnSpanFull()
                            ->label('Remarks'),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('allocation_code')
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

                Tables\Columns\BadgeColumn::make('fund_type')
                    ->colors([
                        'primary' => 'CDF',
                        'danger' => 'Emergency',
                        'warning' => 'Disaster',
                        'success' => 'Empowerment',
                        'info' => 'Infrastructure',
                        'secondary' => 'Other',
                    ]),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'Pending',
                        'warning' => 'Approved',
                        'success' => ['Active', 'Completed'],
                        'danger' => 'Cancelled',
                    ]),

                Tables\Columns\TextColumn::make('total_amount')
                    ->money('ZMW')
                    ->sortable()
                    ->label('Total'),

                Tables\Columns\TextColumn::make('allocated_amount')
                    ->money('ZMW')
                    ->sortable()
                    ->label('Allocated'),

                Tables\Columns\TextColumn::make('disbursed_amount')
                    ->money('ZMW')
                    ->sortable()
                    ->label('Disbursed'),

                Tables\Columns\TextColumn::make('remaining_amount')
                    ->money('ZMW')
                    ->getStateUsing(fn ($record) => $record->allocated_amount - $record->disbursed_amount)
                    ->label('Remaining')
                    ->color(fn ($state) => $state > 0 ? 'success' : 'danger'),

                Tables\Columns\TextColumn::make('ward.name')
                    ->label('Ward')
                    ->searchable()
                    ->default('All Wards')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('financial_year')
                    ->badge()
                    ->color('primary')
                    ->sortable(),

                Tables\Columns\TextColumn::make('allocation_date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('fund_type')
                    ->options([
                        'CDF' => 'Constituency Development Fund',
                        'Emergency' => 'Emergency Fund',
                        'Disaster' => 'Disaster Relief Fund',
                        'Empowerment' => 'Empowerment Fund',
                        'Infrastructure' => 'Infrastructure Fund',
                        'Other' => 'Other',
                    ]),

                Tables\Filters\SelectFilter::make('status'),

                Tables\Filters\SelectFilter::make('financial_year'),

                Tables\Filters\SelectFilter::make('ward')
                    ->relationship('ward', 'name'),

                Tables\Filters\Filter::make('date_range')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('From Date'),
                        Forms\Components\DatePicker::make('until')
                            ->label('Until Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('allocation_date', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('allocation_date', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->visible(fn () => checkFundAllocationReadPermission()),

                Tables\Actions\EditAction::make()
                    ->visible(fn () => checkFundAllocationUpdatePermission()),

                Tables\Actions\DeleteAction::make()
                    ->visible(fn () => checkFundAllocationDeletePermission()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => checkFundAllocationDeletePermission()),
                ]),
            ])
            ->defaultSort('allocation_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFundAllocations::route('/'),
            'create' => Pages\CreateFundAllocation::route('/create'),
            //'view' => Pages\ViewFundAllocation::route('/{record}'),
            'edit' => Pages\EditFundAllocation::route('/{record}/edit'),
        ];
    }
}
