<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GrantRepaymentResource\Pages;
use App\Models\GrantRepayment;
use App\Models\EmpowermentGrant;
use App\Models\AuditTrail;
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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GrantRepaymentResource extends Resource
{
    protected static ?string $model = GrantRepayment::class;
    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';
    protected static ?string $navigationGroup = 'Financial Management';
    protected static ?int $navigationSort = 3;

    public static function shouldRegisterNavigation(): bool
    {
        return checkGrantRepaymentReadPermission();
    }

    public static function canCreate(): bool
    {
        return checkGrantRepaymentCreatePermission();
    }

    public static function canEdit($record): bool
    {
        return checkGrantRepaymentUpdatePermission();
    }

    public static function canDelete($record): bool
    {
        return checkGrantRepaymentDeletePermission();
    }

    public static function canView($record): bool
    {
        return checkGrantRepaymentReadPermission();
    }

    // Audit Trail Logging Methods
    protected static function logActivity(string $action, Model $record, ?array $oldValues = null, ?array $newValues = null): void
    {
        $user = Auth::user();
        if (!$user) return;

        AuditTrail::create([
            'user_id' => $user->id,
            'action' => $action,
            'table_name' => 'grant_repayments',
            'record_id' => $record->id,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'description' => self::getActionDescription($action, $record),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    protected static function getActionDescription(string $action, Model $record): string
    {
        $grantTitle = $record->empowermentGrant ? $record->empowermentGrant->title : 'Unknown Grant';
        return match($action) {
            'Create' => "Created repayment record for: {$grantTitle} - Installment #{$record->installment_number}",
            'Update' => "Updated repayment record for: {$grantTitle} - Installment #{$record->installment_number}",
            'Delete' => "Deleted repayment record for: {$grantTitle} - Installment #{$record->installment_number}",
            'View' => "Viewed repayment record for: {$grantTitle} - Installment #{$record->installment_number}",
            'Record_Payment' => "Recorded payment of K{$record->paid_amount} for: {$grantTitle}",
            'Send_Reminder' => "Sent payment reminder for: {$grantTitle} - Installment #{$record->installment_number}",
            'Extend_Due_Date' => "Extended due date for: {$grantTitle} - Installment #{$record->installment_number}",
            'Waive_Payment' => "Waived payment for: {$grantTitle} - Installment #{$record->installment_number}",
            default => "Performed {$action} on repayment: {$record->repayment_code}",
        };
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Repayment Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('repayment_code')
                                    ->required()
                                    ->maxLength(50)
                                    ->unique(ignoreRecord: true)
                                    ->label('Repayment Code')
                                    ->default(fn () => 'REP-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT)),

                                Forms\Components\Select::make('empowerment_grant_id')
                                    ->relationship('empowermentGrant', 'title')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->label('Grant/Loan')
                                    ->live()
                                    ->afterStateUpdated(function (Forms\Set $set, $state) {
                                        if ($state) {
                                            $grant = EmpowermentGrant::find($state);
                                            if ($grant && $grant->requires_repayment) {
                                                $set('scheduled_amount', $grant->approved_amount / ($grant->repayment_period ?? 12));
                                            }
                                        }
                                    }),
                            ]),

                        Forms\Components\Textarea::make('description')
                            ->rows(2)
                            ->columnSpanFull()
                            ->label('Repayment Description'),
                    ]),

                Section::make('Repayment Details')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('scheduled_amount')
                                    ->numeric()
                                    ->required()
                                    ->prefix('K')
                                    ->minValue(0)
                                    ->label('Scheduled Amount'),

                                Forms\Components\TextInput::make('paid_amount')
                                    ->numeric()
                                    ->default(0)
                                    ->prefix('K')
                                    ->minValue(0)
                                    ->label('Paid Amount')
                                    ->live()
                                    ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get, $state) {
                                        $scheduled = $get('scheduled_amount') ?? 0;
                                        $penalty = $get('penalty_amount') ?? 0;
                                        $interest = $get('interest_amount') ?? 0;

                                        $outstanding = max(0, $scheduled + $penalty + $interest - ($state ?? 0));
                                        $set('outstanding_amount', $outstanding);
                                        $set('total_due', $scheduled + $penalty + $interest);
                                    }),

                                Forms\Components\TextInput::make('outstanding_amount')
                                    ->numeric()
                                    ->prefix('K')
                                    ->label('Outstanding Amount')
                                    ->disabled()
                                    ->dehydrated(),
                            ]),

                        Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('penalty_amount')
                                    ->numeric()
                                    ->default(0)
                                    ->prefix('K')
                                    ->minValue(0)
                                    ->label('Penalty Amount')
                                    ->live(),

                                Forms\Components\TextInput::make('interest_amount')
                                    ->numeric()
                                    ->default(0)
                                    ->prefix('K')
                                    ->minValue(0)
                                    ->label('Interest Amount')
                                    ->live(),

                                Forms\Components\TextInput::make('total_due')
                                    ->numeric()
                                    ->prefix('K')
                                    ->label('Total Due')
                                    ->disabled()
                                    ->dehydrated(),
                            ]),
                    ]),

                Section::make('Schedule & Status')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Forms\Components\DatePicker::make('due_date')
                                    ->required()
                                    ->label('Due Date')
                                    ->live()
                                    ->afterStateUpdated(function (Forms\Set $set, $state) {
                                        if ($state && $state < now()->toDateString()) {
                                            $set('status', 'Overdue');
                                        }
                                    }),

                                Forms\Components\DatePicker::make('paid_date')
                                    ->label('Paid Date')
                                    ->live()
                                    ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get, $state) {
                                        if ($state) {
                                            $paidAmount = $get('paid_amount') ?? 0;
                                            $scheduledAmount = $get('scheduled_amount') ?? 0;

                                            if ($paidAmount >= $scheduledAmount) {
                                                $set('status', 'Paid');
                                            } elseif ($paidAmount > 0) {
                                                $set('status', 'Partial');
                                            }
                                        }
                                    }),

                                Forms\Components\TextInput::make('installment_number')
                                    ->numeric()
                                    ->required()
                                    ->default(1)
                                    ->minValue(1)
                                    ->label('Installment Number'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'Pending' => 'Pending',
                                        'Paid' => 'Paid',
                                        'Partial' => 'Partial Payment',
                                        'Overdue' => 'Overdue',
                                        'Defaulted' => 'Defaulted',
                                        'Waived' => 'Waived',
                                        'Rescheduled' => 'Rescheduled',
                                    ])
                                    ->required()
                                    ->default('Pending')
                                    ->live(),

                                Forms\Components\Select::make('payment_method')
                                    ->options([
                                        'Cash' => 'Cash',
                                        'Bank_Transfer' => 'Bank Transfer',
                                        'Mobile_Money' => 'Mobile Money',
                                        'Cheque' => 'Cheque',
                                        'Deduction' => 'Salary Deduction',
                                        'Other' => 'Other',
                                    ])
                                    ->searchable()
                                    ->label('Payment Method'),
                            ]),
                    ]),

                Section::make('Payment Details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('transaction_reference')
                                    ->maxLength(100)
                                    ->label('Transaction Reference'),

                                Forms\Components\TextInput::make('receipt_number')
                                    ->maxLength(100)
                                    ->label('Receipt Number'),
                            ]),

                        Forms\Components\Textarea::make('payment_notes')
                            ->rows(3)
                            ->columnSpanFull()
                            ->label('Payment Notes'),
                    ])
                    ->collapsible(),

                Section::make('Grace Period & Extensions')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('grace_period_days')
                                    ->numeric()
                                    ->default(0)
                                    ->suffix('days')
                                    ->minValue(0)
                                    ->label('Grace Period'),

                                Forms\Components\DatePicker::make('extended_due_date')
                                    ->label('Extended Due Date')
                                    ->after('due_date'),

                                Forms\Components\TextInput::make('penalty_rate')
                                    ->numeric()
                                    ->default(0)
                                    ->suffix('%')
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->label('Penalty Rate'),
                            ]),

                        Forms\Components\Textarea::make('extension_reason')
                            ->rows(2)
                            ->columnSpanFull()
                            ->label('Extension Reason'),
                    ])
                    ->collapsible(),

                Section::make('Management')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('recorded_by_id')
                                    ->relationship('recordedBy', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->default(Auth::id())
                                    ->label('Recorded By'),

                                Forms\Components\Select::make('approved_by_id')
                                    ->relationship('approvedBy', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->label('Approved By'),
                            ]),

                        Forms\Components\Textarea::make('remarks')
                            ->rows(2)
                            ->columnSpanFull()
                            ->label('Additional Remarks'),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('repayment_code')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),

                Tables\Columns\TextColumn::make('empowermentGrant.title')
                    ->label('Grant/Loan')
                    ->searchable()
                    ->limit(25)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 25 ? $state : null;
                    }),

                Tables\Columns\TextColumn::make('empowermentGrant.beneficiary.name')
                    ->label('Beneficiary')
                    ->searchable()
                    ->limit(20),

                Tables\Columns\TextColumn::make('installment_number')
                    ->badge()
                    ->color('primary')
                    ->label('#'),

                Tables\Columns\TextColumn::make('scheduled_amount')
                    ->money('ZMW')
                    ->sortable()
                    ->label('Scheduled'),

                Tables\Columns\TextColumn::make('paid_amount')
                    ->money('ZMW')
                    ->sortable()
                    ->label('Paid'),

                Tables\Columns\TextColumn::make('outstanding_amount')
                    ->money('ZMW')
                    ->getStateUsing(fn ($record) => $record->scheduled_amount + $record->penalty_amount + $record->interest_amount - $record->paid_amount)
                    ->color(fn ($state) => $state > 0 ? 'danger' : 'success')
                    ->label('Outstanding'),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'Pending',
                        'success' => 'Paid',
                        'warning' => 'Partial',
                        'danger' => ['Overdue', 'Defaulted'],
                        'info' => 'Waived',
                        'primary' => 'Rescheduled',
                    ]),

                Tables\Columns\TextColumn::make('due_date')
                    ->date()
                    ->sortable()
                    ->color(fn ($record) => $record->due_date < now() && !in_array($record->status, ['Paid', 'Waived']) ? 'danger' : null),

                Tables\Columns\TextColumn::make('paid_date')
                    ->date()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('days_overdue')
                    ->getStateUsing(function ($record) {
                        if (in_array($record->status, ['Paid', 'Waived'])) {
                            return 0;
                        }
                        $dueDate = $record->extended_due_date ?? $record->due_date;
                        return $dueDate < now() ? now()->diffInDays($dueDate) : 0;
                    })
                    ->badge()
                    ->color(fn ($state) => $state > 0 ? 'danger' : 'success')
                    ->formatStateUsing(fn ($state) => $state > 0 ? "{$state} days" : 'On time')
                    ->label('Overdue'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'Paid' => 'Paid',
                        'Partial' => 'Partial Payment',
                        'Overdue' => 'Overdue',
                        'Defaulted' => 'Defaulted',
                        'Waived' => 'Waived',
                        'Rescheduled' => 'Rescheduled',
                    ]),

                Tables\Filters\SelectFilter::make('payment_method')
                    ->options([
                        'Cash' => 'Cash',
                        'Bank_Transfer' => 'Bank Transfer',
                        'Mobile_Money' => 'Mobile Money',
                        'Cheque' => 'Cheque',
                        'Deduction' => 'Salary Deduction',
                        'Other' => 'Other',
                    ]),

                Tables\Filters\Filter::make('overdue')
                    ->query(fn (Builder $query): Builder =>
                        $query->where('due_date', '<', now())
                              ->whereNotIn('status', ['Paid', 'Waived'])
                    )
                    ->label('Overdue Payments'),

                Tables\Filters\Filter::make('due_this_month')
                    ->query(fn (Builder $query): Builder =>
                        $query->whereMonth('due_date', now()->month)
                              ->whereYear('due_date', now()->year)
                    )
                    ->label('Due This Month'),

                Tables\Filters\Filter::make('due_this_week')
                    ->query(fn (Builder $query): Builder =>
                        $query->whereBetween('due_date', [
                            now()->startOfWeek(),
                            now()->endOfWeek()
                        ])
                    )
                    ->label('Due This Week'),
            ])
            ->actions([
                Tables\Actions\Action::make('record_payment')
                    ->icon('heroicon-o-banknotes')
                    ->color('success')
                    ->form([
                        Forms\Components\TextInput::make('amount_paid')
                            ->numeric()
                            ->required()
                            ->prefix('K')
                            ->minValue(0.01)
                            ->label('Amount Paid'),

                        Forms\Components\Select::make('payment_method')
                            ->options([
                                'Cash' => 'Cash',
                                'Bank_Transfer' => 'Bank Transfer',
                                'Mobile_Money' => 'Mobile Money',
                                'Cheque' => 'Cheque',
                                'Deduction' => 'Salary Deduction',
                                'Other' => 'Other',
                            ])
                            ->required()
                            ->label('Payment Method'),

                        Forms\Components\TextInput::make('transaction_ref')
                            ->label('Transaction Reference'),

                        Forms\Components\Textarea::make('payment_notes')
                            ->rows(2)
                            ->label('Payment Notes'),
                    ])
                    ->action(function (GrantRepayment $record, array $data) {
                        $oldValues = $record->toArray();

                        $newPaidAmount = $record->paid_amount + $data['amount_paid'];
                        $totalDue = $record->scheduled_amount + $record->penalty_amount + $record->interest_amount;
                        $status = $newPaidAmount >= $totalDue ? 'Paid' : 'Partial';

                        $record->update([
                            'paid_amount' => $newPaidAmount,
                            'paid_date' => now(),
                            'status' => $status,
                            'payment_method' => $data['payment_method'],
                            'transaction_reference' => $data['transaction_ref'] ?? null,
                            'payment_notes' => $data['payment_notes'] ?? null,
                        ]);

                        // Log audit trail
                        self::logActivity('Record_Payment', $record, $oldValues, $record->fresh()->toArray());

                        // Send SMS notification
                        $smsService = new SmsService();
                        $outstanding = $totalDue - $newPaidAmount;
                        $message = "Payment of K{$data['amount_paid']} received for your loan repayment. Outstanding balance: K{$outstanding}. Thank you!";
                        $smsService->sendSms($record->empowermentGrant->beneficiary->phone, $message);

                        Notification::make()
                            ->title('Payment Recorded')
                            ->body("K{$data['amount_paid']} payment recorded successfully")
                            ->success()
                            ->send();
                    })
                    ->visible(fn (GrantRepayment $record) =>
                        !in_array($record->status, ['Paid', 'Waived']) &&
                        checkGrantRepaymentUpdatePermission()
                    ),

                Tables\Actions\Action::make('send_reminder')
                    ->icon('heroicon-o-bell')
                    ->color('warning')
                    ->form([
                        Forms\Components\Textarea::make('custom_message')
                            ->label('Custom Message (Optional)')
                            ->rows(3)
                            ->placeholder('Leave empty to use default reminder message'),
                    ])
                    ->action(function (GrantRepayment $record, array $data) {
                        $smsService = new SmsService();
                        $daysOverdue = $record->due_date < now() ? now()->diffInDays($record->due_date) : 0;

                        if (!empty($data['custom_message'])) {
                            $message = $data['custom_message'];
                        } else {
                            $message = $daysOverdue > 0
                                ? "OVERDUE REMINDER: Your loan repayment of K{$record->scheduled_amount} was due {$daysOverdue} days ago. Please make payment urgently. Ref: {$record->repayment_code}"
                                : "PAYMENT REMINDER: Your loan repayment of K{$record->scheduled_amount} is due on {$record->due_date->format('d/m/Y')}. Please make timely payment. Ref: {$record->repayment_code}";
                        }

                        $result = $smsService->sendSms($record->empowermentGrant->beneficiary->phone, $message);

                        // Log audit trail
                        self::logActivity('Send_Reminder', $record, null, [
                            'message' => $message,
                            'sms_result' => $result
                        ]);

                        if ($result['success']) {
                            Notification::make()
                                ->title('Reminder Sent')
                                ->body('SMS reminder sent successfully')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Reminder Failed')
                                ->body('Failed to send SMS reminder')
                                ->danger()
                                ->send();
                        }
                    })
                    ->visible(fn () => checkGrantRepaymentUpdatePermission()),

                Tables\Actions\Action::make('extend_due_date')
                    ->icon('heroicon-o-calendar-days')
                    ->color('primary')
                    ->form([
                        Forms\Components\DatePicker::make('new_due_date')
                            ->required()
                            ->after('today')
                            ->label('New Due Date'),

                        Forms\Components\Textarea::make('extension_reason')
                            ->required()
                            ->rows(3)
                            ->label('Reason for Extension'),
                    ])
                    ->action(function (GrantRepayment $record, array $data) {
                        $oldValues = $record->toArray();

                        $record->update([
                            'extended_due_date' => $data['new_due_date'],
                            'extension_reason' => $data['extension_reason'],
                            'status' => $record->status === 'Overdue' ? 'Pending' : $record->status,
                        ]);

                        // Log audit trail
                        self::logActivity('Extend_Due_Date', $record, $oldValues, $record->fresh()->toArray());

                        // Send SMS notification
                        $smsService = new SmsService();
                        $message = "Your loan repayment due date has been extended to {$data['new_due_date']}. Ref: {$record->repayment_code}";
                        $smsService->sendSms($record->empowermentGrant->beneficiary->phone, $message);

                        Notification::make()
                            ->title('Due Date Extended')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (GrantRepayment $record) =>
                        !in_array($record->status, ['Paid', 'Waived']) &&
                        checkGrantRepaymentUpdatePermission()
                    ),

                Tables\Actions\Action::make('waive_payment')
                    ->icon('heroicon-o-gift')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalHeading('Waive Payment')
                    ->modalDescription('Are you sure you want to waive this payment? This action cannot be undone.')
                    ->form([
                        Forms\Components\Textarea::make('waiver_reason')
                            ->required()
                            ->rows(3)
                            ->label('Reason for Waiver'),
                    ])
                    ->action(function (GrantRepayment $record, array $data) {
                        $oldValues = $record->toArray();

                        $record->update([
                            'status' => 'Waived',
                            'paid_date' => now(),
                            'remarks' => 'Payment waived: ' . $data['waiver_reason'],
                        ]);

                        // Log audit trail
                        self::logActivity('Waive_Payment', $record, $oldValues, $record->fresh()->toArray());

                        // Send SMS notification
                        $smsService = new SmsService();
                        $message = "Your loan repayment of K{$record->scheduled_amount} has been waived. Ref: {$record->repayment_code}";
                        $smsService->sendSms($record->empowermentGrant->beneficiary->phone, $message);

                        Notification::make()
                            ->title('Payment Waived')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (GrantRepayment $record) =>
                        !in_array($record->status, ['Paid', 'Waived']) &&
                        checkGrantRepaymentDeletePermission() // Higher permission for waiving
                    ),

                Tables\Actions\ViewAction::make()
                    ->visible(fn () => checkGrantRepaymentReadPermission())
                    ->after(function (GrantRepayment $record) {
                        // Log view activity
                        self::logActivity('View', $record);
                    }),

                Tables\Actions\EditAction::make()
                    ->visible(fn () => checkGrantRepaymentUpdatePermission())
                    ->mutateFormDataUsing(function (array $data, GrantRepayment $record): array {
                        // Store old values for audit trail
                        session(['grant_repayment_old_values' => $record->toArray()]);
                        return $data;
                    }),

                Tables\Actions\DeleteAction::make()
                    ->visible(fn () => checkGrantRepaymentDeletePermission())
                    ->before(function (GrantRepayment $record) {
                        // Log deletion before it happens
                        self::logActivity('Delete', $record, $record->toArray());
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('send_bulk_reminders')
                        ->label('Send Reminders')
                        ->icon('heroicon-o-bell')
                        ->color('warning')
                        ->form([
                            Forms\Components\Textarea::make('bulk_message')
                                ->label('Custom Message (Optional)')
                                ->rows(3)
                                ->placeholder('Leave empty to use default reminder messages'),
                        ])
                        ->action(function ($records, array $data) {
                            $smsService = new SmsService();
                            $successCount = 0;
                            $failCount = 0;

                            foreach ($records as $record) {
                                if (!in_array($record->status, ['Paid', 'Waived'])) {
                                    $daysOverdue = $record->due_date < now() ? now()->diffInDays($record->due_date) : 0;

                                    if (!empty($data['bulk_message'])) {
                                        $message = $data['bulk_message'];
                                    } else {
                                        $message = $daysOverdue > 0
                                            ? "OVERDUE: Your loan repayment of K{$record->scheduled_amount} was due {$daysOverdue} days ago. Ref: {$record->repayment_code}"
                                            : "REMINDER: Your loan repayment of K{$record->scheduled_amount} is due on {$record->due_date->format('d/m/Y')}. Ref: {$record->repayment_code}";
                                    }

                                    $result = $smsService->sendSms($record->empowermentGrant->beneficiary->phone, $message);

                                    // Log each reminder
                                    self::logActivity('Send_Reminder', $record, null, [
                                        'bulk_reminder' => true,
                                        'message' => $message,
                                        'sms_result' => $result
                                    ]);

                                    if ($result['success']) {
                                        $successCount++;
                                    } else {
                                        $failCount++;
                                    }
                                }
                            }

                            Notification::make()
                                ->title("Bulk Reminders Complete")
                                ->body("Sent: {$successCount}, Failed: {$failCount}")
                                ->success()
                                ->send();
                        })
                        ->visible(fn () => checkGrantRepaymentUpdatePermission()),

                    Tables\Actions\BulkAction::make('mark_overdue')
                        ->label('Mark as Overdue')
                        ->icon('heroicon-o-exclamation-triangle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $count = 0;
                            foreach ($records as $record) {
                                if ($record->due_date < now() && !in_array($record->status, ['Paid', 'Waived', 'Overdue'])) {
                                    $oldValues = $record->toArray();
                                    $record->update(['status' => 'Overdue']);
                                    self::logActivity('Update', $record, $oldValues, $record->fresh()->toArray());
                                    $count++;
                                }
                            }

                            Notification::make()
                                ->title("Marked {$count} Payments as Overdue")
                                ->success()
                                ->send();
                        })
                        ->visible(fn () => checkGrantRepaymentUpdatePermission()),

                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => checkGrantRepaymentDeletePermission())
                        ->before(function ($records) {
                            // Log bulk deletion
                            foreach ($records as $record) {
                                self::logActivity('Delete', $record, $record->toArray());
                            }
                        }),
                ]),
            ])
            ->defaultSort('due_date', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGrantRepayments::route('/'),
            'create' => Pages\CreateGrantRepayment::route('/create'),
            'view' => Pages\ViewGrantRepayment::route('/{record}'),
            'edit' => Pages\EditGrantRepayment::route('/{record}/edit'),
        ];
    }

    // Override parent methods to add audit logging
    public static function handleRecordCreation(array $data): Model
    {
        $record = static::getModel()::create($data);

        // Log creation
        self::logActivity('Create', $record, null, $record->toArray());

        return $record;
    }

    public static function handleRecordUpdate(Model $record, array $data): Model
    {
        $oldValues = session('grant_repayment_old_values', $record->toArray());

        $record->update($data);

        // Log update
        self::logActivity('Update', $record, $oldValues, $record->fresh()->toArray());

        return $record;
    }
}
