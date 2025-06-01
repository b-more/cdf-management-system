<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommunityProjectResource\Pages;
use App\Models\CommunityProject;
use App\Models\Ward;
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

class CommunityProjectResource extends Resource
{
    protected static ?string $model = CommunityProject::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = 'Project Management';
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return checkCommunityProjectReadPermission();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Project Details')
                ->description('Basic project information.')
                ->icon('heroicon-o-document-text')
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
                        Forms\Components\TextInput::make('estimated_cost')
                            ->required()
                            ->numeric()
                            ->prefix('K')
                            ->label('Estimated Cost'),
                        Forms\Components\TextInput::make('estimated_population')
                            ->required()
                            ->numeric()
                            ->label('Estimated Population'),
                    ]),
                ]),

            Section::make('Beneficiaries')
                ->description('Select target beneficiary groups.')
                ->icon('heroicon-o-user-group')
                ->schema([
                    Forms\Components\CheckboxList::make('beneficiaries')
                        ->options([
                            'youth' => 'Youth',
                            'women' => 'Women',
                            'disabled' => 'Persons with Disabilities',
                            'elderly' => 'Elderly',
                            'general' => 'General Population',
                        ])
                        ->columns(3)
                        ->required(),
                ]),

            Section::make('Project Timeline')
                ->description('Expected project dates.')
                ->icon('heroicon-o-calendar')
                ->schema([
                    Grid::make(2)->schema([
                        Forms\Components\DatePicker::make('expected_start_date')
                            ->label('Expected Start Date'),
                        Forms\Components\DatePicker::make('expected_completion_date')
                            ->label('Expected Completion Date'),
                        Forms\Components\DatePicker::make('actual_start_date')
                            ->label('Actual Start Date'),
                        Forms\Components\DatePicker::make('actual_completion_date')
                            ->label('Actual Completion Date'),
                    ]),
                ]),

            Section::make('Location')
                ->description('Project GPS coordinates (optional).')
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
                        ->default('submitted')
                        ->disabled(fn () => !auth()->user()->isCDFC() && !auth()->user()->isWDC()),
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
                Tables\Columns\TextColumn::make('ward.name')
                    ->searchable()
                    ->sortable()
                    ->label('Ward'),
                Tables\Columns\TextColumn::make('applicant.name')
                    ->searchable()
                    ->sortable()
                    ->label('Applicant'),
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
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'submitted' => 'Submitted',
                        'wdc_recommended' => 'WDC Recommended',
                        'cdfc_approved' => 'CDFC Approved',
                        'rejected' => 'Rejected',
                        'completed' => 'Completed',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'submitted' => 'Submitted',
                        'wdc_recommended' => 'WDC Recommended',
                        'cdfc_approved' => 'CDFC Approved',
                        'rejected' => 'Rejected',
                        'completed' => 'Completed',
                    ])
                    ->multiple(),
                Tables\Filters\SelectFilter::make('ward')
                    ->relationship('ward', 'name')
                    ->multiple()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->color('info'),
                    Tables\Actions\EditAction::make()
                        ->color('warning')
                        ->visible(fn () => checkCommunityProjectUpdatePermission()),
                    Tables\Actions\Action::make('recommend')
                        ->label('Recommend')
                        ->icon('heroicon-o-hand-thumb-up')
                        ->color('success')
                        ->visible(fn ($record) => auth()->user()->isWDC() && $record->status === 'submitted')
                        ->action(function ($record) {
                            $record->update([
                                'status' => 'wdc_recommended',
                                'wdc_comments' => 'Recommended by WDC for CDFC approval.'
                            ]);

                            // Send SMS notification
                            $smsService = new SmsService();
                            $smsService->sendProjectApprovalSms(
                                $record->applicant->phone,
                                $record->title,
                                'wdc_recommended',
                                $record->applicant->id
                            );

                            Notification::make()
                                ->title('Project Recommended')
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
                                'cdfc_comments' => 'Approved by CDFC for implementation.'
                            ]);

                            // Send SMS notification
                            $smsService = new SmsService();
                            $smsService->sendProjectApprovalSms(
                                $record->applicant->phone,
                                $record->title,
                                'cdfc_approved',
                                $record->applicant->id
                            );

                            Notification::make()
                                ->title('Project Approved')
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\DeleteAction::make()
                        ->visible(fn () => checkCommunityProjectDeletePermission()),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => checkCommunityProjectDeletePermission()),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListCommunityProjects::route('/'),
            'create' => Pages\CreateCommunityProject::route('/create'),
            'edit' => Pages\EditCommunityProject::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return checkCommunityProjectCreatePermission();
    }
}

