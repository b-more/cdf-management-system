<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Models\Document;
use App\Models\CommunityProject;
use App\Models\DisasterProject;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Document Management';
    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return checkDocumentReadPermission();
    }

    public static function canCreate(): bool
    {
        return checkDocumentCreatePermission();
    }

    public static function canEdit($record): bool
    {
        return checkDocumentUpdatePermission();
    }

    public static function canDelete($record): bool
    {
        return checkDocumentDeletePermission();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Document Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Document Title'),

                                Forms\Components\Select::make('document_type')
                                    ->options([
                                        'Contract' => 'Contract',
                                        'Report' => 'Report',
                                        'Proposal' => 'Proposal',
                                        'Invoice' => 'Invoice',
                                        'Receipt' => 'Receipt',
                                        'Permit' => 'Permit',
                                        'Certificate' => 'Certificate',
                                        'Photo' => 'Photo',
                                        'Video' => 'Video',
                                        'Other' => 'Other',
                                    ])
                                    ->required()
                                    ->searchable(),
                            ]),

                        Forms\Components\Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull()
                            ->label('Description'),

                        Forms\Components\FileUpload::make('file_path')
                            ->required()
                            ->disk('public')
                            ->directory('documents')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'image/jpeg',
                                'image/png',
                                'image/gif',
                                'video/mp4',
                                'video/avi',
                            ])
                            ->maxSize(10240) // 10MB
                            ->label('Document File')
                            ->columnSpanFull(),
                    ]),

                Section::make('Related Project')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('documentable_type')
                                    ->options([
                                        'App\\Models\\CommunityProject' => 'Community Project',
                                        'App\\Models\\DisasterProject' => 'Disaster Project',
                                        'App\\Models\\EmpowermentGrant' => 'Empowerment Grant',
                                        'App\\Models\\User' => 'User',
                                    ])
                                    ->reactive()
                                    ->label('Related To'),

                                Forms\Components\Select::make('documentable_id')
                                    ->options(function (Forms\Get $get) {
                                        $type = $get('documentable_type');
                                        if ($type === 'App\\Models\\CommunityProject') {
                                            return CommunityProject::pluck('title', 'id');
                                        } elseif ($type === 'App\\Models\\DisasterProject') {
                                            return DisasterProject::pluck('title', 'id');
                                        }
                                        return [];
                                    })
                                    ->searchable()
                                    ->label('Select Item'),
                            ]),
                    ])
                    ->collapsible(),

                Section::make('Document Details')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('file_size')
                                    ->numeric()
                                    ->suffix('KB')
                                    ->label('File Size')
                                    ->disabled(),

                                Forms\Components\TextInput::make('mime_type')
                                    ->maxLength(100)
                                    ->label('MIME Type')
                                    ->disabled(),

                                Forms\Components\TextInput::make('version')
                                    ->maxLength(10)
                                    ->default('1.0')
                                    ->label('Version'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                Forms\Components\Toggle::make('is_public')
                                    ->label('Public Document')
                                    ->default(false)
                                    ->helperText('Public documents can be viewed by everyone'),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('Active Document')
                                    ->default(true),
                            ]),
                    ])
                    ->collapsible(),

                Section::make('Access Control')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\DateTimePicker::make('expires_at')
                                    ->label('Expiry Date (Optional)'),

                                Forms\Components\TextInput::make('access_level')
                                    ->maxLength(50)
                                    ->default('Standard')
                                    ->label('Access Level'),
                            ]),

                        Forms\Components\Textarea::make('access_notes')
                            ->rows(2)
                            ->columnSpanFull()
                            ->label('Access Notes'),
                    ])
                    ->collapsible(),

                Section::make('Management')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('uploaded_by_id')
                                    ->relationship('uploadedBy', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->default(Auth::id())
                                    ->label('Uploaded By'),

                                Forms\Components\Select::make('approved_by_id')
                                    ->relationship('approvedBy', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->label('Approved By'),
                            ]),

                        Forms\Components\Textarea::make('tags')
                            ->rows(2)
                            ->columnSpanFull()
                            ->label('Tags (comma separated)')
                            ->helperText('Enter tags separated by commas for easier searching'),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(30),

                Tables\Columns\BadgeColumn::make('document_type')
                    ->colors([
                        'primary' => 'Contract',
                        'success' => 'Report',
                        'info' => 'Proposal',
                        'warning' => 'Invoice',
                        'danger' => 'Receipt',
                        'secondary' => ['Permit', 'Certificate', 'Photo', 'Video', 'Other'],
                    ]),

                Tables\Columns\TextColumn::make('documentable.title')
                    ->label('Related To')
                    ->limit(25)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 25 ? $state : null;
                    }),

                Tables\Columns\TextColumn::make('file_size')
                    ->formatStateUsing(fn ($state) => $state ? number_format($state / 1024, 2) . ' MB' : 'N/A')
                    ->label('Size'),

                Tables\Columns\TextColumn::make('version')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\IconColumn::make('is_public')
                    ->boolean()
                    ->trueIcon('heroicon-o-globe-alt')
                    ->falseIcon('heroicon-o-lock-closed')
                    ->trueColor('success')
                    ->falseColor('warning')
                    ->label('Access'),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->label('Status'),

                Tables\Columns\TextColumn::make('uploadedBy.name')
                    ->label('Uploaded By')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('expires_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Expires')
                    ->color(fn ($state) => $state && $state < now() ? 'danger' : 'success')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('document_type')
                    ->options([
                        'Contract' => 'Contract',
                        'Report' => 'Report',
                        'Proposal' => 'Proposal',
                        'Invoice' => 'Invoice',
                        'Receipt' => 'Receipt',
                        'Permit' => 'Permit',
                        'Certificate' => 'Certificate',
                        'Photo' => 'Photo',
                        'Video' => 'Video',
                        'Other' => 'Other',
                    ]),

                Tables\Filters\TernaryFilter::make('is_public')
                    ->label('Document Access')
                    ->placeholder('All documents')
                    ->trueLabel('Public documents')
                    ->falseLabel('Private documents'),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Document Status')
                    ->placeholder('All documents')
                    ->trueLabel('Active documents')
                    ->falseLabel('Inactive documents'),

                Tables\Filters\Filter::make('expired')
                    ->query(fn (Builder $query): Builder => $query->where('expires_at', '<', now()))
                    ->label('Expired Documents'),
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('primary')
                    ->url(fn (Document $record): string => Storage::disk('public')->url($record->file_path))
                    ->openUrlInNewTab()
                    ->visible(fn () => checkDocumentReadPermission()),

                Tables\Actions\Action::make('preview')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn (Document $record): string => Storage::disk('public')->url($record->file_path))
                    ->openUrlInNewTab()
                    ->visible(fn (Document $record) =>
                        in_array($record->document_type, ['Photo', 'Video']) &&
                        checkDocumentReadPermission()
                    ),

                Tables\Actions\ViewAction::make()
                    ->visible(fn () => checkDocumentReadPermission()),

                Tables\Actions\EditAction::make()
                    ->visible(fn () => checkDocumentUpdatePermission()),

                Tables\Actions\DeleteAction::make()
                    ->visible(fn () => checkDocumentDeletePermission()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => checkDocumentDeletePermission()),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            //'view' => Pages\ViewDocument::route('/{record}'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
