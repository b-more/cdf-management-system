<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuditTrailResource\Pages;
use App\Models\AuditTrail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AuditTrailResource extends Resource
{
    protected static ?string $model = AuditTrail::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'System Management';
    protected static ?int $navigationSort = 3;

    public static function shouldRegisterNavigation(): bool
    {
        return checkAuditTrailReadPermission();
    }

    public static function canCreate(): bool
    {
        return false; // Audit trails are auto-generated
    }

    public static function canEdit($record): bool
    {
        return false; // Audit trails should not be edited
    }

    public static function canDelete($record): bool
    {
        return checkAuditTrailDeletePermission();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('action')
                    ->colors([
                        'success' => 'Create',
                        'primary' => 'Update',
                        'warning' => 'View',
                        'danger' => 'Delete',
                        'info' => 'Login',
                        'secondary' => 'Other',
                    ]),

                Tables\Columns\TextColumn::make('table_name')
                    ->label('Table')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('record_id')
                    ->label('Record ID')
                    ->searchable(),

                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 50 ? $state : null;
                    }),

                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('user_agent')
                    ->label('User Agent')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Timestamp'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('action')
                    ->options([
                        'Create' => 'Create',
                        'Update' => 'Update',
                        'Delete' => 'Delete',
                        'View' => 'View',
                        'Login' => 'Login',
                        'Logout' => 'Logout',
                    ]),

                Tables\Filters\SelectFilter::make('table_name')
                    ->options([
                        'users' => 'Users',
                        'community_projects' => 'Community Projects',
                        'disaster_projects' => 'Disaster Projects',
                        'fund_allocations' => 'Fund Allocations',
                        'empowerment_grants' => 'Empowerment Grants',
                        'monitoring_reports' => 'Monitoring Reports',
                        'sms_notifications' => 'SMS Notifications',
                        'documents' => 'Documents',
                    ]),

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
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->visible(fn () => checkAuditTrailReadPermission()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => checkAuditTrailDeletePermission()),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuditTrails::route('/'),
            //'view' => Pages\ViewAuditTrail::route('/{record}'),
        ];
    }
}
