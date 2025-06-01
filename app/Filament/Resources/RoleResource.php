<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Models\Role;
use App\Models\Permission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return checkRoleReadPermission();
    }

    public static function canCreate(): bool
    {
        return checkRoleCreatePermission();
    }

    public static function canEdit($record): bool
    {
        return checkRoleUpdatePermission();
    }

    public static function canDelete($record): bool
    {
        return checkRoleDeletePermission();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('is_deleted', 0);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Role Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->label('Role Name'),

                                Forms\Components\Toggle::make('is_deleted')
                                    ->label('Inactive')
                                    ->default(false),
                            ]),

                        Forms\Components\Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull()
                            ->label('Role Description'),
                    ])
                    ->collapsible(),

                Section::make('Role Permissions')
                    ->schema([
                        Forms\Components\Repeater::make('permissions')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('module')
                                    ->options([
                                        'User' => 'User Management',
                                        'Role' => 'Role Management',
                                        'Permission' => 'Permission Management',
                                        'Ward' => 'Ward Management',
                                        'CommunityProject' => 'Community Projects',
                                        'DisasterProject' => 'Disaster Projects',
                                        'FundAllocation' => 'Fund Allocations',
                                        'MonitoringReport' => 'Monitoring Reports',
                                        'EmpowermentGrant' => 'Empowerment Grants',
                                        'SmsNotification' => 'SMS Notifications',
                                        'Document' => 'Document Management',
                                        'AuditTrail' => 'Audit Trails',
                                    ])
                                    ->required()
                                    ->searchable(),

                                Grid::make(4)
                                    ->schema([
                                        Forms\Components\Toggle::make('create')
                                            ->label('Create'),
                                        Forms\Components\Toggle::make('read')
                                            ->label('Read'),
                                        Forms\Components\Toggle::make('update')
                                            ->label('Update'),
                                        Forms\Components\Toggle::make('delete')
                                            ->label('Delete'),
                                    ]),
                            ])
                            ->columns(2)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['module'] ?? null),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 50 ? $state : null;
                    }),

                Tables\Columns\TextColumn::make('users_count')
                    ->counts('users')
                    ->label('Users')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('permissions_count')
                    ->counts('permissions')
                    ->label('Permissions')
                    ->badge()
                    ->color('success'),

                Tables\Columns\IconColumn::make('is_deleted')
                    ->boolean()
                    ->trueIcon('heroicon-o-x-circle')
                    ->falseIcon('heroicon-o-check-circle')
                    ->trueColor('danger')
                    ->falseColor('success')
                    ->label('Status'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_deleted')
                    ->label('Status')
                    ->placeholder('All roles')
                    ->trueLabel('Inactive roles')
                    ->falseLabel('Active roles'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->visible(fn () => checkRoleReadPermission()),
                Tables\Actions\EditAction::make()
                    ->visible(fn () => checkRoleUpdatePermission()),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn () => checkRoleDeletePermission()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => checkRoleDeletePermission()),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            //'view' => Pages\ViewRole::route('/{record}'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
