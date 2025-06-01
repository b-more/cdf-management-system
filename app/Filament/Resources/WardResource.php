<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WardResource\Pages;
use App\Models\Ward;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Illuminate\Database\Eloquent\Builder;

class WardResource extends Resource
{
    protected static ?string $model = Ward::class;
    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static ?string $navigationGroup = 'Administration';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return checkWardReadPermission();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Ward Information')
                ->description('Enter ward details and location information.')
                ->icon('heroicon-o-map-pin')
                ->schema([
                    Grid::make(2)->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Ward Name'),
                        Forms\Components\TextInput::make('constituency')
                            ->required()
                            ->maxLength(255)
                            ->label('Constituency'),
                        Forms\Components\TextInput::make('district')
                            ->required()
                            ->maxLength(255)
                            ->label('District'),
                        Forms\Components\TextInput::make('province')
                            ->required()
                            ->maxLength(255)
                            ->label('Province'),
                        Forms\Components\TextInput::make('population')
                            ->numeric()
                            ->label('Population'),
                    ]),
                ]),
            Section::make('Geographic Coordinates')
                ->description('Optional GPS coordinates for mapping.')
                ->icon('heroicon-o-globe-americas')
                ->schema([
                    Grid::make(2)->schema([
                        Forms\Components\TextInput::make('latitude')
                            ->numeric()
                            ->step(0.00000001)
                            ->label('Latitude'),
                        Forms\Components\TextInput::make('longitude')
                            ->numeric()
                            ->step(0.00000001)
                            ->label('Longitude'),
                    ]),
                ]),
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
                Tables\Columns\TextColumn::make('constituency')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('district')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('province')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('population')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state)),
                Tables\Columns\TextColumn::make('users_count')
                    ->counts('users')
                    ->label('Users')
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('province')
                    ->options([
                        'Lusaka' => 'Lusaka',
                        'Copperbelt' => 'Copperbelt',
                        'Northern' => 'Northern',
                        'Southern' => 'Southern',
                        'Eastern' => 'Eastern',
                        'Western' => 'Western',
                        'North-Western' => 'North-Western',
                        'Central' => 'Central',
                        'Luapula' => 'Luapula',
                        'Muchinga' => 'Muchinga',
                    ])
                    ->multiple()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->color('info'),
                    Tables\Actions\EditAction::make()
                        ->color('warning')
                        ->visible(fn () => checkWardUpdatePermission()),
                    Tables\Actions\DeleteAction::make()
                        ->visible(fn () => checkWardDeletePermission()),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => checkWardDeletePermission()),
                ]),
            ])
            ->defaultSort('name');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWards::route('/'),
            'create' => Pages\CreateWard::route('/create'),
            'edit' => Pages\EditWard::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return checkWardCreatePermission();
    }
}
