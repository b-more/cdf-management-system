<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DisasterProjectResource\Pages;
use App\Models\DisasterProject;
use App\Services\SmsService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;

class DisasterProjectResource extends Resource
{
    protected static ?string $model = DisasterProject::class;
    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';
    protected static ?string $navigationGroup = 'Project Management';
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    // public static function shouldRegisterNavigation(): bool
    // {
    //     return checkDisasterProjectReadPermission();
    // }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Disaster Project Details')
                ->description('Emergency/disaster response project information.')
                ->icon('heroicon-o-shield-exclamation')
                ->schema([
                    Grid::make(2)->schema([
                        Forms\Components\Select::make('ward_id')
                            ->relationship('ward', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Ward'),
                        Forms\Components\Select::make('applicant_id')
                            ->relationship('applicant', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Applicant'),
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('disaster_type')
                            ->options([
                                'flood' => 'Flood',
                                'drought' => 'Drought',
                                'fire' => 'Fire',
                                'windstorm' => 'Windstorm',
                                'epidemic' => 'Epidemic',
                                'other' => 'Other',
                            ])
                            ->required()
                            ->label('Disaster Type'),
                        Forms\Components\Select::make('urgency_level')
                            ->options([
                                'low' => 'Low',
                                'medium' => 'Medium',
                                'high' => 'High',
                                'critical' => 'Critical',
                            ])
                            ->required()
                            ->default('medium')
                            ->label('Urgency Level'),
                        Forms\Components\TextInput::make('estimated_cost')
                            ->required()
                            ->numeric()
                            ->prefix('K')
                            ->label('Estimated Cost'),
                        Forms\Components\TextInput::make('estimated_population')
                            ->required()
                            ->numeric()
                            ->label('Estimated Population'),
                        Forms\Components\TextInput::make('affected_households')
                            ->required()
                            ->numeric()
                            ->label('Affected Households'),
                        Forms\Components\DatePicker::make('disaster_date')
                            ->required()
                            ->label('Disaster Date'),
                        Forms\Components\DatePicker::make('expected_completion_date')
                            ->label('Expected Completion Date'),
                        Forms\Components\DatePicker::make('actual_completion_date')
                            ->label('Actual Completion Date'),
                    ]),
                ]),

            Section::make('Location')
                ->description('Disaster location coordinates (optional).')
                ->icon('heroicon-o-map-pin')
                ->schema([
                    Grid::make(2)->schema([
                        Forms\Components\TextInput::make('latitude')
                            ->numeric()
                            ->step(0.00000001),
                        Forms\Components\TextInput::make('longitude')
                            ->numeric()
                            ->step(0.00000001),
                    ]),
                ]),

            Section::make('Approval Process')
                ->description('Review and approval status.')
                ->icon('heroicon-o-check-circle')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->options([
                            'submitted' => 'Submitted',
                            'wdc_recommended' => 'WDC Recommended',
                            'cdfc_approved' => 'CDFC Approved',
                            'rejected' => 'Rejected',
                            'completed' => 'Completed',
                        ])
                        ->required()
                        ->default('submitted'),
                    Forms\Components\Textarea::make('wdc_comments')
                        ->label('WDC Comments')
                        ->rows(3)
                        ->visible(fn () => auth()->user()->isWDC() || auth()->user()->isCDFC()),
                    Forms\Components\Textarea::make('cdfc_comments')
                        ->label('CDFC Comments')
                        ->rows(3)
                        ->visible(fn () => auth()->user()->isCDFC()),
                    Forms\Components\Textarea::make('rejection_reason')
                        ->label('Rejection Reason')
                        ->rows(3)
                        ->visible(fn ($get) => $get('status') === 'rejected'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project_code')
                    ->searchable()
                    ->sortable()
                    ->label('Code'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\BadgeColumn::make('disaster_type')
                    ->colors([
                        'danger' => ['flood', 'fire'],
                        'warning' => ['drought', 'windstorm'],
                        'info' => ['epidemic'],
                        'secondary' => 'other',
                    ]),
                Tables\Columns\BadgeColumn::make('urgency_level')
                    ->colors([
                        'success' => 'low',
                        'warning' => 'medium',
                        'danger' => 'high',
                        'primary' => 'critical',
                    ]),
                Tables\Columns\TextColumn::make('affected_households')
                    ->numeric()
                    ->sortable()
                    ->label('Households'),
                Tables\Columns\TextColumn::make('estimated_cost')
                    ->money('ZMW')
                    ->sortable()
                    ->label('Cost'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'submitted',
                        'info' => 'wdc_recommended',
                        'success' => 'cdfc_approved',
                        'danger' => 'rejected',
                        'primary' => 'completed',
                    ]),
                Tables\Columns\TextColumn::make('disaster_date')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('disaster_type')
                    ->options([
                        'flood' => 'Flood',
                        'drought' => 'Drought',
                        'fire' => 'Fire',
                        'windstorm' => 'Windstorm',
                        'epidemic' => 'Epidemic',
                        'other' => 'Other',
                    ])
                    ->multiple(),
                Tables\Filters\SelectFilter::make('urgency_level')
                    ->options([
                        'low' => 'Low',
                        'medium' => 'Medium',
                        'high' => 'High',
                        'critical' => 'Critical',
                    ])
                    ->multiple(),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'submitted' => 'Submitted',
                        'wdc_recommended' => 'WDC Recommended',
                        'cdfc_approved' => 'CDFC Approved',
                        'rejected' => 'Rejected',
                        'completed' => 'Completed',
                    ])
                    ->multiple(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->color('info'),
                    Tables\Actions\EditAction::make()
                        ->color('warning')
                        ->visible(fn () => checkDisasterProjectUpdatePermission()),
                    Tables\Actions\Action::make('recommend')
                        ->label('Recommend')
                        ->icon('heroicon-o-hand-thumb-up')
                        ->color('success')
                        ->visible(fn ($record) => auth()->user()->isWDC() && $record->status === 'submitted')
                        ->action(function ($record) {
                            $record->update([
                                'status' => 'wdc_recommended',
                                'wdc_comments' => 'Emergency response recommended by WDC for immediate CDFC approval.'
                            ]);

                            Notification::make()
                                ->title('Emergency Project Recommended')
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\Action::make('approve')
                        ->label('Approve')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn ($record) => auth()->user()->isCDFC() && $record->status === 'wdc_recommended')
                        ->action(function ($record) {
                            $record->update([
                                'status' => 'cdfc_approved',
                                'cdfc_comments' => 'Emergency response approved by CDFC for immediate implementation.'
                            ]);

                            Notification::make()
                                ->title('Emergency Project Approved')
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\DeleteAction::make()
                        ->visible(fn () => checkDisasterProjectDeletePermission()),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => checkDisasterProjectDeletePermission()),
                ]),
            ])
            ->defaultSort('urgency_level', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // Filter by user role and ward
        if (auth()->user()->isWDC() || auth()->user()->isCDFC()) {
            if (auth()->user()->ward_id) {
                $query->where('ward_id', auth()->user()->ward_id);
            }
        } elseif (auth()->user()->role->name === 'Applicant') {
            $query->where('applicant_id', auth()->id());
        }

        return $query;
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDisasterProjects::route('/'),
            'create' => Pages\CreateDisasterProject::route('/create'),
            'edit' => Pages\EditDisasterProject::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return checkDisasterProjectCreatePermission();
    }
}
