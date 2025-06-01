<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SmsNotificationResource\Pages;
use App\Models\SmsNotification;
use App\Models\User;
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

class SmsNotificationResource extends Resource
{
    protected static ?string $model = SmsNotification::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'Communications';
    protected static ?string $recordTitleAttribute = 'message';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count();
    }

    // public static function shouldRegisterNavigation(): bool
    // {
    //     return checkSmsNotificationReadPermission();
    // }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('SMS Details')
                ->description('Compose and send SMS notifications.')
                ->icon('heroicon-o-device-phone-mobile')
                ->schema([
                    Grid::make(2)->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->label('User (Optional)')
                            ->reactive()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if ($state) {
                                    $user = User::find($state);
                                    if ($user && $user->phone) {
                                        $set('phone', $user->phone);
                                    }
                                }
                            }),
                        Forms\Components\TextInput::make('phone')
                            ->required()
                            ->tel()
                            ->label('Phone Number')
                            ->placeholder('260971234567'),
                        Forms\Components\Select::make('message_type')
                            ->options([
                                'general' => 'General',
                                'approval' => 'Approval',
                                'rejection' => 'Rejection',
                                'reminder' => 'Reminder',
                                'funding' => 'Funding',
                                'emergency' => 'Emergency',
                            ])
                            ->required()
                            ->default('general'),
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'sent' => 'Sent',
                                'failed' => 'Failed',
                                'delivered' => 'Delivered',
                            ])
                            ->default('pending')
                            ->disabled(),
                        Forms\Components\Textarea::make('message')
                            ->required()
                            ->rows(4)
                            ->maxLength(160)
                            ->columnSpanFull()
                            ->hint('Maximum 160 characters'),
                    ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => "260" . substr($state, -9)),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->label('User'),
                Tables\Columns\TextColumn::make('message')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('message_type')
                    ->colors([
                        'primary' => 'general',
                        'success' => 'approval',
                        'danger' => 'rejection',
                        'warning' => 'reminder',
                        'info' => 'funding',
                        'secondary' => 'emergency',
                    ]),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'sent',
                        'danger' => 'failed',
                        'primary' => 'delivered',
                    ]),
                Tables\Columns\TextColumn::make('sent_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'sent' => 'Sent',
                        'failed' => 'Failed',
                        'delivered' => 'Delivered',
                    ])
                    ->multiple(),
                Tables\Filters\SelectFilter::make('message_type')
                    ->options([
                        'general' => 'General',
                        'approval' => 'Approval',
                        'rejection' => 'Rejection',
                        'reminder' => 'Reminder',
                        'funding' => 'Funding',
                        'emergency' => 'Emergency',
                    ])
                    ->multiple(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->color('info'),
                    Tables\Actions\Action::make('send')
                        ->label('Send SMS')
                        ->icon('heroicon-o-paper-airplane')
                        ->color('success')
                        ->visible(fn ($record) => $record->status === 'pending')
                        ->action(function ($record) {
                            $smsService = new SmsService();
                            $result = $smsService->sendSingleSms(
                                $record->phone,
                                $record->message,
                                $record->user_id
                            );

                            if ($result['success']) {
                                Notification::make()
                                    ->title('SMS Sent Successfully')
                                    ->success()
                                    ->send();
                            } else {
                                Notification::make()
                                    ->title('SMS Failed to Send')
                                    ->body($result['message'])
                                    ->danger()
                                    ->send();
                            }
                        }),
                    Tables\Actions\Action::make('retry')
                        ->label('Retry')
                        ->icon('heroicon-o-arrow-path')
                        ->color('warning')
                        ->visible(fn ($record) => $record->status === 'failed')
                        ->action(function ($record) {
                            $smsService = new SmsService();
                            $result = $smsService->retrySms($record->id);

                            if ($result['success']) {
                                Notification::make()
                                    ->title('SMS Retry Successful')
                                    ->success()
                                    ->send();
                            } else {
                                Notification::make()
                                    ->title('SMS Retry Failed')
                                    ->body($result['message'])
                                    ->danger()
                                    ->send();
                            }
                        }),
                    Tables\Actions\DeleteAction::make()
                        ->visible(fn () => checkSmsNotificationDeletePermission()),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => checkSmsNotificationDeletePermission()),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSmsNotifications::route('/'),
            'create' => Pages\CreateSmsNotification::route('/create'),
        ];
    }

    public static function canCreate(): bool
    {
        return checkSmsNotificationCreatePermission();
    }
}
