<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmpowermentGrantResource\Pages;
use App\Filament\Resources\EmpowermentGrantResource\RelationManagers;
use App\Models\EmpowermentGrant;
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

class EmpowermentGrantResource extends Resource
{
    protected static ?string $model = EmpowermentGrant::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'Empowerment Grants';

    protected static ?string $modelLabel = 'Empowerment Grant';

    protected static ?string $pluralModelLabel = 'Empowerment Grants';

    protected static ?string $navigationGroup = 'Empowerment Programs';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'Pending')->count();
    }

    public static function canCreate(): bool
    {
        return checkEmpowermentGrantCreatePermission();
    }

    public static function canEdit($record): bool
    {
        return checkEmpowermentGrantUpdatePermission();
    }

    public static function canDelete($record): bool
    {
        return checkEmpowermentGrantDeletePermission();
    }

    public static function canView($record): bool
    {
        return checkEmpowermentGrantReadPermission();
    }

    public static function canViewAny(): bool
    {
        return checkEmpowermentGrantReadPermission();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Grant Information')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('grant_code')
                                    ->label('Grant Code')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->default(function () {
                                        return 'EG-' . date('Y') . '-' . str_pad(EmpowermentGrant::count() + 1, 4, '0', STR_PAD_LEFT);
                                    })
                                    ->readOnly()
                                    ->maxLength(50),

                                Forms\Components\Select::make('empowerment_id')
                                    ->label('Empowerment Program')
                                    ->relationship('empowerment', 'title')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('title')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\Select::make('type')
                                            ->options([
                                                'Skills Training' => 'Skills Training',
                                                'Business Development' => 'Business Development',
                                                'Agricultural Training' => 'Agricultural Training',
                                                'Financial Literacy' => 'Financial Literacy',
                                                'Other' => 'Other',
                                            ])
                                            ->required(),
                                    ]),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('beneficiary_type')
                                    ->label('Beneficiary Type')
                                    ->options([
                                        'Individual' => 'Individual',
                                        'Group' => 'Group',
                                        'Cooperative' => 'Cooperative',
                                        'Association' => 'Association',
                                        'Youth Group' => 'Youth Group',
                                        'Women Group' => 'Women Group',
                                    ])
                                    ->required()
                                    ->native(false),

                                Forms\Components\Select::make('ward_id')
                                    ->label('Ward')
                                    ->relationship('ward', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                            ]),
                    ]),

                Forms\Components\Section::make('Beneficiary Details')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('beneficiary_name')
                                    ->label('Beneficiary Name')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('beneficiary_phone')
                                    ->label('Phone Number')
                                    ->tel()
                                    ->required()
                                    ->maxLength(20),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('beneficiary_email')
                                    ->label('Email Address')
                                    ->email()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('id_number')
                                    ->label('National ID Number')
                                    ->required()
                                    ->maxLength(50),
                            ]),

                        Forms\Components\Textarea::make('beneficiary_address')
                            ->label('Address')
                            ->required()
                            ->rows(3)
                            ->maxLength(500),
                    ]),

                Forms\Components\Section::make('Grant Details')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('grant_amount')
                                    ->label('Grant Amount (ZMW)')
                                    ->numeric()
                                    ->prefix('K')
                                    ->required()
                                    ->minValue(100)
                                    ->maxValue(50000),

                                Forms\Components\Select::make('grant_type')
                                    ->label('Grant Type')
                                    ->options([
                                        'Cash Grant' => 'Cash Grant',
                                        'Equipment Grant' => 'Equipment Grant',
                                        'Training Voucher' => 'Training Voucher',
                                        'Material Support' => 'Material Support',
                                        'Mixed Grant' => 'Mixed Grant',
                                    ])
                                    ->required()
                                    ->native(false),

                                Forms\Components\Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'Pending' => 'Pending',
                                        'Under Review' => 'Under Review',
                                        'Approved' => 'Approved',
                                        'Disbursed' => 'Disbursed',
                                        'Rejected' => 'Rejected',
                                        'Completed' => 'Completed',
                                    ])
                                    ->default('Pending')
                                    ->required()
                                    ->native(false),
                            ]),

                        Forms\Components\Textarea::make('purpose')
                            ->label('Grant Purpose')
                            ->required()
                            ->rows(3)
                            ->placeholder('Describe how the grant will be used...')
                            ->maxLength(1000),

                        Forms\Components\Textarea::make('expected_outcomes')
                            ->label('Expected Outcomes')
                            ->required()
                            ->rows(3)
                            ->placeholder('What are the expected outcomes of this grant?')
                            ->maxLength(1000),
                    ]),

                Forms\Components\Section::make('Dates & Timeline')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\DatePicker::make('application_date')
                                    ->label('Application Date')
                                    ->default(now())
                                    ->required(),

                                Forms\Components\DatePicker::make('approval_date')
                                    ->label('Approval Date')
                                    ->visible(fn ($get) => in_array($get('status'), ['Approved', 'Disbursed', 'Completed'])),

                                Forms\Components\DatePicker::make('disbursement_date')
                                    ->label('Disbursement Date')
                                    ->visible(fn ($get) => in_array($get('status'), ['Disbursed', 'Completed'])),
                            ]),
                    ]),

                Forms\Components\Section::make('Additional Information')
                    ->schema([
                        Forms\Components\Textarea::make('requirements')
                            ->label('Grant Requirements')
                            ->placeholder('List any specific requirements or conditions...')
                            ->rows(3)
                            ->maxLength(1000),

                        Forms\Components\Textarea::make('monitoring_notes')
                            ->label('Monitoring Notes')
                            ->placeholder('Notes on grant monitoring and follow-up...')
                            ->rows(3)
                            ->maxLength(1000),

                        Forms\Components\Textarea::make('remarks')
                            ->label('Additional Remarks')
                            ->placeholder('Any additional comments or notes...')
                            ->rows(3)
                            ->maxLength(1000),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('grant_code')
                    ->label('Grant Code')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('beneficiary_name')
                    ->label('Beneficiary')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('empowerment.title')
                    ->label('Program')
                    ->searchable()
                    ->limit(25)
                    ->tooltip(function ($record) {
                        return $record->empowerment?->title;
                    }),

                Tables\Columns\TextColumn::make('beneficiary_type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Individual' => 'blue',
                        'Group' => 'green',
                        'Cooperative' => 'purple',
                        'Association' => 'orange',
                        'Youth Group' => 'yellow',
                        'Women Group' => 'pink',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('ward.name')
                    ->label('Ward')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('grant_amount')
                    ->label('Amount')
                    ->money('ZMW')
                    ->sortable(),

                Tables\Columns\TextColumn::make('grant_type')
                    ->label('Grant Type')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pending' => 'warning',
                        'Under Review' => 'info',
                        'Approved' => 'success',
                        'Disbursed' => 'primary',
                        'Rejected' => 'danger',
                        'Completed' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('beneficiary_phone')
                    ->label('Phone')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('application_date')
                    ->label('Applied')
                    ->date('M j, Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('disbursement_date')
                    ->label('Disbursed')
                    ->date('M j, Y')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'Under Review' => 'Under Review',
                        'Approved' => 'Approved',
                        'Disbursed' => 'Disbursed',
                        'Rejected' => 'Rejected',
                        'Completed' => 'Completed',
                    ])
                    ->multiple(),

                Tables\Filters\SelectFilter::make('beneficiary_type')
                    ->options([
                        'Individual' => 'Individual',
                        'Group' => 'Group',
                        'Cooperative' => 'Cooperative',
                        'Association' => 'Association',
                        'Youth Group' => 'Youth Group',
                        'Women Group' => 'Women Group',
                    ])
                    ->multiple(),

                Tables\Filters\SelectFilter::make('grant_type')
                    ->options([
                        'Cash Grant' => 'Cash Grant',
                        'Equipment Grant' => 'Equipment Grant',
                        'Training Voucher' => 'Training Voucher',
                        'Material Support' => 'Material Support',
                        'Mixed Grant' => 'Mixed Grant',
                    ])
                    ->multiple(),

                Tables\Filters\SelectFilter::make('ward')
                    ->relationship('ward', 'name')
                    ->multiple()
                    ->preload(),

                Tables\Filters\SelectFilter::make('empowerment')
                    ->relationship('empowerment', 'title')
                    ->multiple()
                    ->preload(),

                Tables\Filters\Filter::make('amount_range')
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('amount_from')
                                    ->label('Amount From (ZMW)')
                                    ->numeric()
                                    ->prefix('K'),
                                Forms\Components\TextInput::make('amount_to')
                                    ->label('Amount To (ZMW)')
                                    ->numeric()
                                    ->prefix('K'),
                            ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['amount_from'],
                                fn (Builder $query, $amount): Builder => $query->where('grant_amount', '>=', $amount)
                            )
                            ->when(
                                $data['amount_to'],
                                fn (Builder $query, $amount): Builder => $query->where('grant_amount', '<=', $amount)
                            );
                    }),

                Tables\Filters\Filter::make('recent_applications')
                    ->label('Recent Applications (Last 30 days)')
                    ->query(fn (Builder $query): Builder =>
                        $query->where('application_date', '>=', now()->subDays(30))
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->visible(fn ($record) => self::canView($record))
                    ->before(function ($record) {
                        // Log view action
                        self::logActivity('view', $record, "Viewed empowerment grant: {$record->grant_code}");
                    }),

                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => self::canEdit($record))
                    ->before(function ($record) {
                        // Store original values for audit
                        session(['edit_original_' . $record->id => $record->toArray()]);
                    })
                    ->after(function ($record) {
                        // Log edit action
                        $original = session('edit_original_' . $record->id);
                        session()->forget('edit_original_' . $record->id);

                        self::logActivity(
                            'update',
                            $record,
                            "Updated empowerment grant: {$record->grant_code}",
                            $original,
                            $record->toArray()
                        );
                    }),

                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $oldStatus = $record->status;
                        $record->update([
                            'status' => 'Approved',
                            'approval_date' => now(),
                        ]);

                        self::logActivity(
                            'status_change',
                            $record,
                            "Approved empowerment grant: {$record->grant_code}",
                            ['status' => $oldStatus],
                            ['status' => 'Approved', 'approval_date' => now()]
                        );

                        Notification::make()
                            ->title('Grant Approved')
                            ->body("Grant {$record->grant_code} has been approved successfully")
                            ->success()
                            ->send();
                    })
                    ->visible(fn ($record) => $record->status === 'Under Review' && checkEmpowermentGrantUpdatePermission()),

                Tables\Actions\Action::make('disburse')
                    ->label('Mark as Disbursed')
                    ->icon('heroicon-o-banknotes')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $oldStatus = $record->status;
                        $record->update([
                            'status' => 'Disbursed',
                            'disbursement_date' => now(),
                        ]);

                        self::logActivity(
                            'disbursement',
                            $record,
                            "Disbursed empowerment grant: {$record->grant_code}",
                            ['status' => $oldStatus],
                            ['status' => 'Disbursed', 'disbursement_date' => now()]
                        );

                        Notification::make()
                            ->title('Grant Disbursed')
                            ->body("Grant {$record->grant_code} has been marked as disbursed")
                            ->success()
                            ->send();
                    })
                    ->visible(fn ($record) => $record->status === 'Approved' && checkEmpowermentGrantUpdatePermission()),

                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->form([
                        Forms\Components\Textarea::make('rejection_reason')
                            ->label('Rejection Reason')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(function ($record, array $data) {
                        $oldStatus = $record->status;
                        $record->update([
                            'status' => 'Rejected',
                            'remarks' => $data['rejection_reason'],
                        ]);

                        self::logActivity(
                            'rejection',
                            $record,
                            "Rejected empowerment grant: {$record->grant_code}. Reason: {$data['rejection_reason']}",
                            ['status' => $oldStatus],
                            ['status' => 'Rejected', 'remarks' => $data['rejection_reason']]
                        );

                        Notification::make()
                            ->title('Grant Rejected')
                            ->body("Grant {$record->grant_code} has been rejected")
                            ->success()
                            ->send();
                    })
                    ->visible(fn ($record) => in_array($record->status, ['Pending', 'Under Review']) && checkEmpowermentGrantUpdatePermission()),

                Tables\Actions\Action::make('complete')
                    ->label('Mark Complete')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->form([
                        Forms\Components\Textarea::make('completion_notes')
                            ->label('Completion Notes')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(function ($record, array $data) {
                        $oldStatus = $record->status;
                        $record->update([
                            'status' => 'Completed',
                            'monitoring_notes' => ($record->monitoring_notes ? $record->monitoring_notes . "\n\n" : '') .
                                                'COMPLETION: ' . $data['completion_notes'],
                        ]);

                        self::logActivity(
                            'completion',
                            $record,
                            "Completed empowerment grant: {$record->grant_code}",
                            ['status' => $oldStatus],
                            ['status' => 'Completed']
                        );

                        Notification::make()
                            ->title('Grant Completed')
                            ->body("Grant {$record->grant_code} has been marked as completed")
                            ->success()
                            ->send();
                    })
                    ->visible(fn ($record) => $record->status === 'Disbursed' && checkEmpowermentGrantUpdatePermission()),

                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => self::canDelete($record))
                    ->before(function ($record) {
                        // Log deletion
                        self::logActivity(
                            'delete',
                            $record,
                            "Deleted empowerment grant: {$record->grant_code}",
                            $record->toArray(),
                            null
                        );
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('bulk_approve')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $count = 0;
                            foreach ($records as $record) {
                                if ($record->status === 'Under Review') {
                                    $oldStatus = $record->status;
                                    $record->update([
                                        'status' => 'Approved',
                                        'approval_date' => now(),
                                    ]);

                                    self::logActivity(
                                        'bulk_approve',
                                        $record,
                                        "Bulk approved empowerment grant: {$record->grant_code}",
                                        ['status' => $oldStatus],
                                        ['status' => 'Approved']
                                    );
                                    $count++;
                                }
                            }

                            Notification::make()
                                ->title('Grants Approved')
                                ->body("Successfully approved {$count} grants")
                                ->success()
                                ->send();
                        })
                        ->visible(fn () => checkEmpowermentGrantUpdatePermission())
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\BulkAction::make('mark_under_review')
                        ->label('Mark Under Review')
                        ->icon('heroicon-o-eye')
                        ->color('warning')
                        ->action(function ($records) {
                            $count = 0;
                            foreach ($records as $record) {
                                if ($record->status === 'Pending') {
                                    $record->update(['status' => 'Under Review']);

                                    self::logActivity(
                                        'bulk_review',
                                        $record,
                                        "Bulk moved to review: {$record->grant_code}",
                                        ['status' => 'Pending'],
                                        ['status' => 'Under Review']
                                    );
                                    $count++;
                                }
                            }

                            Notification::make()
                                ->title('Status Updated')
                                ->body("Moved {$count} grants to Under Review")
                                ->success()
                                ->send();
                        })
                        ->visible(fn () => checkEmpowermentGrantUpdatePermission())
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => checkEmpowermentGrantDeletePermission())
                        ->before(function ($records) {
                            foreach ($records as $record) {
                                self::logActivity(
                                    'bulk_delete',
                                    $record,
                                    "Bulk deleted empowerment grant: {$record->grant_code}",
                                    $record->toArray(),
                                    null
                                );
                            }
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // Apply role-based filtering
        $user = Auth::user();
        if (!$user) return $query->whereRaw('1 = 0');

        // Super Admin sees all
        if ($user->hasRole('Super Admin')) {
            return $query;
        }

        // Ward officials see only their ward's grants
        if ($user->hasRole('Ward Official')) {
            return $query->where('ward_id', $user->ward_id);
        }

        // Other roles see all (admins, CDFC, etc.)
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
            'index' => Pages\ListEmpowermentGrants::route('/'),
            'create' => Pages\CreateEmpowermentGrant::route('/create'),
            //'view' => Pages\ViewEmpowermentGrant::route('/{record}'),
            'edit' => Pages\EditEmpowermentGrant::route('/{record}/edit'),
        ];
    }

    /**
     * Log activity to audit trail
     */
    private static function logActivity(string $action, $record, string $description, array $oldValues = null, array $newValues = null): void
    {
        try {
            AuditTrail::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'model_type' => 'EmpowermentGrant',
                'model_id' => $record->id,
                'description' => $description,
                'old_values' => $oldValues ? json_encode($oldValues) : null,
                'new_values' => $newValues ? json_encode($newValues) : null,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to log audit trail: ' . $e->getMessage());
        }
    }
}
