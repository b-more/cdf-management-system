<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WardResource\Pages;
use App\Models\Ward;
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
use Illuminate\Support\Facades\Request;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;

class WardResource extends Resource
{
    protected static ?string $model = Ward::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationLabel = 'Wards';

    protected static ?string $modelLabel = 'Ward';

    protected static ?string $pluralModelLabel = 'Wards';

    protected static ?string $navigationGroup = 'Administration';

    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return checkWardReadPermission();
    }

    public static function canCreate(): bool
    {
        return checkWardCreatePermission();
    }

    public static function canEdit($record): bool
    {
        return checkWardUpdatePermission();
    }

    public static function canDelete($record): bool
    {
        return checkWardDeletePermission();
    }

    public static function canView($record): bool
    {
        return checkWardReadPermission();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Ward Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Ward Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->placeholder('Enter ward name')
                                    ->rules(['min:3', 'max:255'])
                                    ->validationMessages([
                                        'min' => 'Ward name must be at least 3 characters long',
                                        'max' => 'Ward name cannot exceed 255 characters',
                                        'unique' => 'This ward name already exists',
                                    ])
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $state, Forms\Set $set, Forms\Get $get) {
                                        // Auto-generate code suggestion based on name
                                        if (strlen($state) >= 3) {
                                            $codeBase = strtoupper(substr(preg_replace('/[^A-Z0-9]/', '', strtoupper($state)), 0, 6));
                                            $suggestedCode = 'W' . $codeBase;
                                            if (strlen($suggestedCode) > 20) {
                                                $suggestedCode = substr($suggestedCode, 0, 20);
                                            }
                                            // Only set if code is empty
                                            $currentCode = $get('code');
                                            if (empty($currentCode)) {
                                                $set('code', $suggestedCode);
                                            }
                                        }
                                    }),

                                Forms\Components\TextInput::make('code')
                                    ->label('Ward Code')
                                    ->required()
                                    ->maxLength(20)
                                    ->unique(ignoreRecord: true)
                                    ->placeholder('W001')
                                    ->helperText('Unique identifier for the ward (max 20 characters)')
                                    ->rules(['regex:/^[A-Z0-9\-_]{1,20}$/'])
                                    ->validationMessages([
                                        'regex' => 'Ward code must contain only uppercase letters, numbers, hyphens, and underscores (max 20 characters)',
                                    ])
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $state, Forms\Set $set) {
                                        // Auto-format the code to uppercase
                                        $formatted = strtoupper(preg_replace('/[^A-Z0-9\-_]/', '', $state));
                                        if (strlen($formatted) > 20) {
                                            $formatted = substr($formatted, 0, 20);
                                        }
                                        $set('code', $formatted);
                                    }),
                            ]),

                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->rows(3)
                            ->maxLength(1000)
                            ->columnSpanFull()
                            ->placeholder('Brief description of the ward boundaries and characteristics'),
                    ])
                    ->columns(2),

                Section::make('Geographic Information')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('latitude')
                                    ->label('Latitude')
                                    ->numeric()
                                    ->step(0.00000001)
                                    ->placeholder('-15.4067')
                                    ->helperText('Decimal degrees format (-90 to 90)')
                                    ->rules(['min:-90', 'max:90'])
                                    ->validationMessages([
                                        'min' => 'Latitude must be between -90 and 90 degrees',
                                        'max' => 'Latitude must be between -90 and 90 degrees',
                                    ]),

                                Forms\Components\TextInput::make('longitude')
                                    ->label('Longitude')
                                    ->numeric()
                                    ->step(0.00000001)
                                    ->placeholder('28.2871')
                                    ->helperText('Decimal degrees format (-180 to 180)')
                                    ->rules(['min:-180', 'max:180'])
                                    ->validationMessages([
                                        'min' => 'Longitude must be between -180 and 180 degrees',
                                        'max' => 'Longitude must be between -180 and 180 degrees',
                                    ]),

                                Forms\Components\TextInput::make('area_size')
                                    ->label('Area Size')
                                    ->numeric()
                                    ->step(0.01)
                                    ->suffix('km²')
                                    ->placeholder('25.50')
                                    ->helperText('Area in square kilometers')
                                    ->rules(['min:0.01', 'max:10000'])
                                    ->validationMessages([
                                        'min' => 'Area size must be greater than 0',
                                        'max' => 'Area size cannot exceed 10,000 km²',
                                    ]),
                            ]),

                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('get_current_location')
                                ->label('Get Current Location')
                                ->icon('heroicon-o-map-pin')
                                ->color('info')
                                ->action(function (Forms\Set $set) {
                                    // This would require JavaScript to get user's location
                                    Notification::make()
                                        ->title('Location Feature')
                                        ->body('Please manually enter the coordinates for now.')
                                        ->info()
                                        ->send();
                                }),
                        ])
                        ->columnSpanFull(),
                    ])
                    ->columns(3)
                    ->collapsible(),

                Section::make('Contact Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('contact_person')
                                    ->label('Contact Person')
                                    ->maxLength(255)
                                    ->placeholder('John Doe')
                                    ->helperText('Primary contact person for this ward'),

                                Forms\Components\TextInput::make('phone')
                                    ->label('Phone Number')
                                    ->tel()
                                    ->maxLength(20)
                                    ->placeholder('+260 977 123456')
                                    ->helperText('Contact phone number (international format preferred)')
                                    ->rules(['regex:/^[\+]?[0-9\s\-\(\)]{10,20}$/'])
                                    ->validationMessages([
                                        'regex' => 'Please enter a valid phone number (10-20 digits)',
                                    ])
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $state, Forms\Set $set) {
                                        // Clean and format phone number
                                        $cleaned = preg_replace('/[^0-9\+]/', '', $state);
                                        if (strlen($cleaned) > 20) {
                                            $cleaned = substr($cleaned, 0, 20);
                                        }
                                        $set('phone', $cleaned);
                                    }),
                            ]),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Ward Name')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->tooltip(function ($record) {
                        return $record->name;
                    }),

                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->tooltip(function ($record) {
                        return $record->description;
                    })
                    ->toggleable(),

                Tables\Columns\TextColumn::make('area_size')
                    ->label('Area')
                    ->suffix(' km²')
                    ->numeric(2)
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('contact_person')
                    ->label('Contact Person')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone')
                    ->copyable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('users_count')
                    ->label('Users')
                    ->counts('users')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                Tables\Columns\TextColumn::make('community_projects_count')
                    ->label('Projects')
                    ->counts('communityProjects')
                    ->badge()
                    ->color('success')
                    ->sortable(),

                Tables\Columns\TextColumn::make('empowerment_programs_count')
                    ->label('Programs')
                    ->counts('empowermentPrograms')
                    ->badge()
                    ->color('warning')
                    ->sortable(),

                Tables\Columns\TextColumn::make('coordinates')
                    ->label('Coordinates')
                    ->getStateUsing(function ($record) {
                        if ($record->latitude && $record->longitude) {
                            return number_format($record->latitude, 6) . ', ' . number_format($record->longitude, 6);
                        }
                        return 'Not set';
                    })
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('has_coordinates')
                    ->label('Has GPS Coordinates')
                    ->query(fn (Builder $query): Builder =>
                        $query->whereNotNull('latitude')->whereNotNull('longitude')
                    ),

                Tables\Filters\Filter::make('has_contact')
                    ->label('Has Contact Info')
                    ->query(fn (Builder $query): Builder =>
                        $query->whereNotNull('contact_person')->whereNotNull('phone')
                    ),

                Tables\Filters\Filter::make('active_wards')
                    ->label('Active Wards (with users)')
                    ->query(fn (Builder $query): Builder =>
                        $query->has('users')
                    ),

                Tables\Filters\Filter::make('large_area')
                    ->label('Large Area (>50 km²)')
                    ->query(fn (Builder $query): Builder =>
                        $query->where('area_size', '>', 50)
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->visible(fn ($record) => checkWardReadPermission())
                    ->after(function ($record) {
                        self::logActivity('View', $record, 'Viewed ward: ' . $record->name);
                    }),

                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => checkWardUpdatePermission())
                    ->mutateFormDataUsing(function (array $data, $record): array {
                        self::logActivity('Update', $record,
                            'Updated ward: ' . $record->name,
                            $record->toArray(),
                            $data
                        );
                        return $data;
                    }),

                Tables\Actions\Action::make('view_map')
                    ->label('View on Map')
                    ->icon('heroicon-o-map')
                    ->color('info')
                    ->action(function ($record) {
                        if ($record->latitude && $record->longitude) {
                            self::logActivity('Map View', $record, 'Viewed ward location on map: ' . $record->name);

                            $mapUrl = "https://www.google.com/maps?q={$record->latitude},{$record->longitude}";

                            Notification::make()
                                ->title('Opening Map')
                                ->body('Ward location will open in a new tab.')
                                ->success()
                                ->send();

                            // In a real implementation, you might use JavaScript to open the URL
                            return redirect()->away($mapUrl);
                        } else {
                            Notification::make()
                                ->title('No Coordinates')
                                ->body('This ward does not have GPS coordinates set.')
                                ->warning()
                                ->send();
                        }
                    })
                    ->visible(fn ($record) => checkWardReadPermission()),

                Tables\Actions\Action::make('ward_statistics')
                    ->label('Statistics')
                    ->icon('heroicon-o-chart-bar')
                    ->color('success')
                    ->modalHeading(fn ($record) => 'Ward Statistics: ' . $record->name)
                    ->modalContent(function ($record) {
                        $stats = [
                            'users_count' => $record->users()->count(),
                            'community_projects_count' => $record->communityProjects()->count(),
                            'disaster_projects_count' => $record->disasterProjects()->count(),
                            'empowerment_programs_count' => $record->empowermentPrograms()->count(),
                            'fund_allocations_count' => $record->fundAllocations()->count(),
                            'monitoring_reports_count' => $record->monitoringReports()->count(),
                        ];

                        $html = '<div class="space-y-4">';
                        $html .= '<div class="grid grid-cols-2 gap-4">';

                        $html .= '<div class="bg-blue-50 p-4 rounded-lg">';
                        $html .= '<div class="text-2xl font-bold text-blue-600">' . $stats['users_count'] . '</div>';
                        $html .= '<div class="text-sm text-blue-800">Registered Users</div>';
                        $html .= '</div>';

                        $html .= '<div class="bg-green-50 p-4 rounded-lg">';
                        $html .= '<div class="text-2xl font-bold text-green-600">' . $stats['community_projects_count'] . '</div>';
                        $html .= '<div class="text-sm text-green-800">Community Projects</div>';
                        $html .= '</div>';

                        $html .= '<div class="bg-red-50 p-4 rounded-lg">';
                        $html .= '<div class="text-2xl font-bold text-red-600">' . $stats['disaster_projects_count'] . '</div>';
                        $html .= '<div class="text-sm text-red-800">Disaster Projects</div>';
                        $html .= '</div>';

                        $html .= '<div class="bg-purple-50 p-4 rounded-lg">';
                        $html .= '<div class="text-2xl font-bold text-purple-600">' . $stats['empowerment_programs_count'] . '</div>';
                        $html .= '<div class="text-sm text-purple-800">Empowerment Programs</div>';
                        $html .= '</div>';

                        $html .= '<div class="bg-yellow-50 p-4 rounded-lg">';
                        $html .= '<div class="text-2xl font-bold text-yellow-600">' . $stats['fund_allocations_count'] . '</div>';
                        $html .= '<div class="text-sm text-yellow-800">Fund Allocations</div>';
                        $html .= '</div>';

                        $html .= '<div class="bg-indigo-50 p-4 rounded-lg">';
                        $html .= '<div class="text-2xl font-bold text-indigo-600">' . $stats['monitoring_reports_count'] . '</div>';
                        $html .= '<div class="text-sm text-indigo-800">Monitoring Reports</div>';
                        $html .= '</div>';

                        $html .= '</div>';

                        // Additional ward info
                        $html .= '<div class="mt-6 p-4 bg-gray-50 rounded-lg">';
                        $html .= '<h3 class="font-semibold text-gray-900 mb-2">Ward Details</h3>';
                        $html .= '<div class="grid grid-cols-2 gap-2 text-sm">';
                        $html .= '<div><span class="font-medium">Ward Code:</span> ' . $record->code . '</div>';
                        if ($record->area_size) {
                            $html .= '<div><span class="font-medium">Area:</span> ' . number_format($record->area_size, 2) . ' km²</div>';
                        }
                        if ($record->contact_person) {
                            $html .= '<div><span class="font-medium">Contact:</span> ' . $record->contact_person . '</div>';
                        }
                        if ($record->phone) {
                            $html .= '<div><span class="font-medium">Phone:</span> ' . $record->phone . '</div>';
                        }
                        $html .= '</div>';
                        $html .= '</div>';

                        $html .= '</div>';

                        return new \Illuminate\Support\HtmlString($html);
                    })
                    ->modalActions([
                        Tables\Actions\Action::make('close')
                            ->label('Close')
                            ->color('gray')
                            ->close(),
                    ])
                    ->after(function ($record) {
                        self::logActivity('Statistics View', $record, 'Viewed statistics for ward: ' . $record->name);
                    })
                    ->visible(fn ($record) => checkWardReadPermission()),

                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => checkWardDeletePermission())
                    ->before(function ($record) {
                        // Check if ward has related records
                        $hasUsers = $record->users()->exists();
                        $hasProjects = $record->communityProjects()->exists() || $record->disasterProjects()->exists();

                        if ($hasUsers || $hasProjects) {
                            Notification::make()
                                ->title('Cannot Delete Ward')
                                ->body('This ward has associated users or projects and cannot be deleted.')
                                ->danger()
                                ->send();
                            return false;
                        }

                        self::logActivity('Delete', $record, 'Deleted ward: ' . $record->name);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('export_coordinates')
                        ->label('Export Coordinates')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('info')
                        ->action(function ($records) {
                            $coordinates = $records->filter(function ($record) {
                                return $record->latitude && $record->longitude;
                            })->map(function ($record) {
                                return [
                                    'ward_code' => $record->code,
                                    'ward_name' => $record->name,
                                    'latitude' => $record->latitude,
                                    'longitude' => $record->longitude,
                                ];
                            });

                            self::logActivity('Export', null, 'Exported coordinates for ' . $coordinates->count() . ' wards');

                            // In a real implementation, you would generate and download a CSV/Excel file
                            Notification::make()
                                ->title('Coordinates Exported')
                                ->body('Exported coordinates for ' . $coordinates->count() . ' wards.')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\BulkAction::make('update_contact_info')
                        ->label('Update Contact Info')
                        ->icon('heroicon-o-phone')
                        ->color('warning')
                        ->form([
                            Forms\Components\TextInput::make('contact_person')
                                ->label('Contact Person')
                                ->maxLength(255),

                            Forms\Components\TextInput::make('phone')
                                ->label('Phone Number')
                                ->tel()
                                ->maxLength(20),
                        ])
                        ->action(function ($records, array $data) {
                            $updateData = array_filter($data); // Remove empty values
                            $updatedCount = 0;

                            foreach ($records as $record) {
                                if (checkWardUpdatePermission()) {
                                    $oldData = $record->toArray();
                                    $record->update($updateData);

                                    self::logActivity('Bulk Update', $record,
                                        'Bulk updated contact info for ward: ' . $record->name,
                                        $oldData,
                                        $record->fresh()->toArray()
                                    );
                                    $updatedCount++;
                                }
                            }

                            Notification::make()
                                ->title('Contact Info Updated')
                                ->body("Updated contact information for {$updatedCount} ward(s).")
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => checkWardDeletePermission())
                        ->before(function ($records) {
                            foreach ($records as $record) {
                                // Check if ward has related records
                                $hasUsers = $record->users()->exists();
                                $hasProjects = $record->communityProjects()->exists() || $record->disasterProjects()->exists();

                                if ($hasUsers || $hasProjects) {
                                    Notification::make()
                                        ->title('Cannot Delete Some Wards')
                                        ->body('Some wards have associated users or projects and cannot be deleted.')
                                        ->warning()
                                        ->send();
                                    return false;
                                }

                                self::logActivity('Bulk Delete', $record, 'Bulk deleted ward: ' . $record->name);
                            }
                        }),
                ]),
            ])
            ->defaultSort('name')
            ->striped()
            ->paginated([10, 25, 50, 100]);
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();
        $query = parent::getEloquentQuery();

        if ($user && $user->role) {
            switch ($user->role->name) {
                case 'Ward Development Committee':
                case 'Constituency Officer':
                    // Only see their own ward
                    if ($user->ward_id) {
                        $query->where('id', $user->ward_id);
                    }
                    break;

                case 'CDFC Member':
                case 'Admin':
                case 'Super Admin':
                case 'Applicant':
                    // Can see all wards
                    break;
            }
        }

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
            'index' => Pages\ListWards::route('/'),
            'create' => Pages\CreateWard::route('/create'),
            'view' => Pages\ViewWard::route('/{record}'),
            'edit' => Pages\EditWard::route('/{record}/edit'),
        ];
    }

    // Audit Trail Logging Method
    private static function logActivity(string $action, $record, string $description, array $oldValues = [], array $newValues = []): void
    {
        try {
            AuditTrail::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'table_name' => 'wards',
                'record_id' => $record?->id,
                'old_values' => !empty($oldValues) ? json_encode($oldValues) : null,
                'new_values' => !empty($newValues) ? json_encode($newValues) : null,
                'description' => $description,
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
            ]);
        } catch (\Exception $e) {
            // Log error but don't break the application
            \Log::error('Failed to log audit trail: ' . $e->getMessage());
        }
    }
}
