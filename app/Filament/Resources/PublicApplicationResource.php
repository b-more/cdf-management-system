<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublicApplicationResource\Pages;
use App\Models\CommunityProject;
use App\Models\DisasterProject;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PublicApplicationResource extends Resource
{
    protected static ?string $model = CommunityProject::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    protected static ?string $navigationLabel = 'Public Applications';

    protected static ?string $modelLabel = 'Public Application';

    protected static ?string $pluralModelLabel = 'Public Applications';

    protected static ?string $navigationGroup = 'Applications';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereNotNull('applicant_name')
            ->where('status', 'Submitted')
            ->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Applicant Information')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('applicant_name')
                                    ->label('Applicant Name')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('applicant_phone')
                                    ->label('Phone Number')
                                    ->tel()
                                    ->required(),

                                Forms\Components\TextInput::make('applicant_email')
                                    ->label('Email')
                                    ->email(),

                                Forms\Components\TextInput::make('applicant_id_number')
                                    ->label('National ID')
                                    ->required(),
                            ]),

                        Forms\Components\Textarea::make('applicant_address')
                            ->label('Address')
                            ->required()
                            ->rows(3),
                    ]),

                Forms\Components\Section::make('Project Information')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('project_code')
                                    ->label('Application ID')
                                    ->required()
                                    ->unique(ignoreRecord: true),

                                Forms\Components\Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'Submitted' => 'Submitted',
                                        'Under Review' => 'Under Review',
                                        'WDC Review' => 'WDC Review',
                                        'CDFC Review' => 'CDFC Review',
                                        'Approved' => 'Approved',
                                        'Rejected' => 'Rejected',
                                        'In Progress' => 'In Progress',
                                        'Completed' => 'Completed',
                                    ])
                                    ->required()
                                    ->native(false),
                            ]),

                        Forms\Components\TextInput::make('title')
                            ->label('Project Title')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('description')
                            ->label('Project Description')
                            ->required()
                            ->rows(4),

                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('category')
                                    ->label('Category')
                                    ->options([
                                        'Infrastructure' => 'Infrastructure',
                                        'Education' => 'Education',
                                        'Health' => 'Health',
                                        'Water & Sanitation' => 'Water & Sanitation',
                                        'Agriculture' => 'Agriculture',
                                        'Youth Development' => 'Youth Development',
                                        'Women Empowerment' => 'Women Empowerment',
                                        'Sports & Culture' => 'Sports & Culture',
                                        'Environment' => 'Environment',
                                        'Other' => 'Other',
                                    ])
                                    ->required()
                                    ->native(false),

                                Forms\Components\Select::make('priority')
                                    ->label('Priority')
                                    ->options([
                                        'Low' => 'Low',
                                        'Medium' => 'Medium',
                                        'High' => 'High',
                                        'Critical' => 'Critical',
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

                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('requested_amount')
                                    ->label('Requested Amount (ZMW)')
                                    ->numeric()
                                    ->prefix('K')
                                    ->required(),

                                Forms\Components\TextInput::make('beneficiaries_count')
                                    ->label('Beneficiaries')
                                    ->numeric()
                                    ->required(),

                                Forms\Components\TextInput::make('location')
                                    ->label('Project Location')
                                    ->required(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project_code')
                    ->label('Application ID')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('applicant_name')
                    ->label('Applicant')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Project Title')
                    ->searchable()
                    ->limit(30)
                    ->tooltip(function ($record) {
                        return $record->title;
                    }),

                Tables\Columns\TextColumn::make('category')
                    ->label('Category')
                    ->badge()
                    ->color('primary')
                    ->searchable(),

                Tables\Columns\TextColumn::make('ward.name')
                    ->label('Ward')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('requested_amount')
                    ->label('Amount')
                    ->money('ZMW')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Submitted' => 'warning',
                        'Under Review' => 'info',
                        'WDC Review' => 'primary',
                        'CDFC Review' => 'secondary',
                        'Approved' => 'success',
                        'Rejected' => 'danger',
                        'In Progress' => 'info',
                        'Completed' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('applicant_phone')
                    ->label('Phone')
                    ->copyable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime('M j, Y g:i A')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Submitted' => 'Submitted',
                        'Under Review' => 'Under Review',
                        'WDC Review' => 'WDC Review',
                        'CDFC Review' => 'CDFC Review',
                        'Approved' => 'Approved',
                        'Rejected' => 'Rejected',
                        'In Progress' => 'In Progress',
                        'Completed' => 'Completed',
                    ])
                    ->multiple(),

                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'Infrastructure' => 'Infrastructure',
                        'Education' => 'Education',
                        'Health' => 'Health',
                        'Water & Sanitation' => 'Water & Sanitation',
                        'Agriculture' => 'Agriculture',
                        'Youth Development' => 'Youth Development',
                        'Other' => 'Other',
                    ])
                    ->multiple(),

                Tables\Filters\SelectFilter::make('ward')
                    ->relationship('ward', 'name')
                    ->multiple()
                    ->preload(),

                Tables\Filters\Filter::make('new_applications')
                    ->label('New Applications (Last 7 days)')
                    ->query(fn (Builder $query): Builder =>
                        $query->where('created_at', '>=', now()->subDays(7))
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),

                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update(['status' => 'Approved']);

                        // Send SMS notification
                        self::sendStatusUpdateSMS($record->applicant_phone, $record->project_code, 'Approved');

                        Notification::make()
                            ->title('Application Approved')
                            ->body('SMS notification sent to applicant')
                            ->success()
                            ->send();
                    })
                    ->visible(fn ($record) => in_array($record->status, ['Submitted', 'Under Review', 'WDC Review', 'CDFC Review'])),

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
                        $record->update([
                            'status' => 'Rejected',
                            'remarks' => $data['rejection_reason']
                        ]);

                        // Send SMS notification
                        $message = "CDF UPDATE: Your application {$record->project_code} has been rejected. Reason: {$data['rejection_reason']}";
                        self::sendSMS($record->applicant_phone, $message);

                        Notification::make()
                            ->title('Application Rejected')
                            ->body('SMS notification sent to applicant')
                            ->success()
                            ->send();
                    })
                    ->visible(fn ($record) => $record->status !== 'Rejected'),

                Tables\Actions\Action::make('send_update')
                    ->label('Send Update')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('info')
                    ->form([
                        Forms\Components\Textarea::make('message')
                            ->label('Update Message')
                            ->required()
                            ->placeholder('Enter your update message...')
                            ->rows(3),
                    ])
                    ->action(function ($record, array $data) {
                        $message = "CDF UPDATE: Your application {$record->project_code} - {$data['message']}";
                        self::sendSMS($record->applicant_phone, $message);

                        Notification::make()
                            ->title('Update Sent')
                            ->body('SMS update sent to applicant')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('approve_selected')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $count = 0;
                            foreach ($records as $record) {
                                if (in_array($record->status, ['Submitted', 'Under Review', 'WDC Review', 'CDFC Review'])) {
                                    $record->update(['status' => 'Approved']);
                                    self::sendStatusUpdateSMS($record->applicant_phone, $record->project_code, 'Approved');
                                    $count++;
                                }
                            }

                            Notification::make()
                                ->title('Applications Approved')
                                ->body("Approved {$count} applications. SMS notifications sent.")
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\BulkAction::make('mark_under_review')
                        ->label('Mark Under Review')
                        ->icon('heroicon-o-eye')
                        ->color('warning')
                        ->action(function ($records) {
                            $count = 0;
                            foreach ($records as $record) {
                                if ($record->status === 'Submitted') {
                                    $record->update(['status' => 'Under Review']);
                                    self::sendStatusUpdateSMS($record->applicant_phone, $record->project_code, 'Under Review');
                                    $count++;
                                }
                            }

                            Notification::make()
                                ->title('Status Updated')
                                ->body("Updated {$count} applications to Under Review.")
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        // Only show applications that came from the public portal
        return parent::getEloquentQuery()->whereNotNull('applicant_name');
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
            'index' => Pages\ListPublicApplications::route('/'),
            'create' => Pages\CreatePublicApplication::route('/create'),
            'view' => Pages\ViewPublicApplication::route('/{record}'),
            'edit' => Pages\EditPublicApplication::route('/{record}/edit'),
        ];
    }

    // SMS Helper Methods
    private static function sendStatusUpdateSMS($phone, $applicationId, $status)
    {
        $message = "CDF UPDATE: Your application {$applicationId} status has been updated to: {$status}. Thank you for your patience.";
        return self::sendSMS($phone, $message);
    }

    private static function sendSMS($phone, $message)
    {
        try {
            $encodedMessage = urlencode($message);
            $url = "https://www.cloudservicezm.com/smsservice/httpapi?username=Blessmore&password=Blessmore&msg={$encodedMessage}&shortcode=2343&sender_id=BLESSMORE&phone={$phone}&api_key=121231313213123123";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Cookie: MUTUMIKI=us0kovmvlpga3vpdf5dl1uclih'
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            curl_close($ch);

            return $response;
        } catch (\Exception $e) {
            \Log::error('SMS Error: ' . $e->getMessage());
            return false;
        }
    }
}
