<?php

namespace App\Filament\Widgets;

use App\Models\CommunityProject;
use App\Models\DisasterProject;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class RecentProjectsTable extends BaseWidget
{
    protected static ?string $heading = 'Recent Projects';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                $this->getTableQuery()
            )
            ->columns([
                Tables\Columns\TextColumn::make('project_code')
                    ->label('Code')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Project Title')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->tooltip(function ($record) {
                        return $record->title;
                    }),

                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Community' => 'success',
                        'Disaster' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('ward.name')
                    ->label('Ward')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('applicant.name')
                    ->label('Applicant/Reporter')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->getStateUsing(function ($record) {
                        if ($record->type === 'Community') {
                            return $record->applicant?->name ?? 'N/A';
                        } else {
                            // For disaster projects, get the reportedBy relationship
                            $disasterProject = \App\Models\DisasterProject::find($record->id);
                            return $disasterProject?->reportedBy?->name ?? 'N/A';
                        }
                    }),

                Tables\Columns\TextColumn::make('requested_amount')
                    ->label('Amount')
                    ->money('ZMW')
                    ->sortable()
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Draft' => 'gray',
                        'Submitted' => 'warning',
                        'Under Review' => 'info',
                        'WDC Approved' => 'success',
                        'CDFC Approved' => 'success',
                        'Approved' => 'success',
                        'In Progress' => 'primary',
                        'Completed' => 'success',
                        'Rejected' => 'danger',
                        'Suspended' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Draft' => 'Draft',
                        'Submitted' => 'Submitted',
                        'Under Review' => 'Under Review',
                        'WDC Approved' => 'WDC Approved',
                        'CDFC Approved' => 'CDFC Approved',
                        'Approved' => 'Approved',
                        'In Progress' => 'In Progress',
                        'Completed' => 'Completed',
                        'Rejected' => 'Rejected',
                        'Suspended' => 'Suspended',
                    ])
                    ->multiple(),

                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'Community' => 'Community Project',
                        'Disaster' => 'Disaster Project',
                    ]),

                Tables\Filters\Filter::make('recent')
                    ->label('Last 30 Days')
                    ->query(fn (Builder $query): Builder => $query->where('created_at', '>=', now()->subDays(30)))
                    ->default(),
            ])
            ->actions([
                // No actions for now - just display data
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(function () {
                            return checkCommunityProjectDeletePermission() || checkDisasterProjectDeletePermission();
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50])
            ->poll('30s'); // Auto-refresh every 30 seconds
    }

    protected function getTableQuery(): Builder
    {
        $user = Auth::user();

        // Start with CommunityProject as base query
        $query = CommunityProject::query()
            ->select([
                'id',
                'project_code',
                'title',
                'ward_id',
                'applicant_id',
                'requested_amount',
                'status',
                'created_at',
                \DB::raw("'Community' as type")
            ])
            ->with(['ward', 'applicant']);

        // Apply role-based filtering for community projects
        if ($user) {
            switch ($user->role->name) {
                case 'Applicant':
                    $query->where('applicant_id', $user->id);
                    break;

                case 'Ward Development Committee':
                case 'Constituency Officer':
                    if ($user->ward_id) {
                        $query->where('ward_id', $user->ward_id);
                    }
                    break;

                case 'CDFC Member':
                case 'Admin':
                case 'Super Admin':
                    // No filtering - can see all projects
                    break;
            }
        }

        // Create disaster projects query - note: uses reported_by_id instead of applicant_id
        $disasterQuery = DisasterProject::query()
            ->select([
                'id',
                'project_code',
                'title',
                'ward_id',
                'reported_by_id as applicant_id', // Map reported_by_id to applicant_id for union compatibility
                'requested_amount',
                'status',
                'created_at',
                \DB::raw("'Disaster' as type")
            ])
            ->with(['ward', 'reportedBy as applicant']); // Map reportedBy to applicant for consistency

        // Apply same role-based filtering for disaster projects
        if ($user) {
            switch ($user->role->name) {
                case 'Applicant':
                    $disasterQuery->where('reported_by_id', $user->id); // Use reported_by_id for disaster projects
                    break;

                case 'Ward Development Committee':
                case 'Constituency Officer':
                    if ($user->ward_id) {
                        $disasterQuery->where('ward_id', $user->ward_id);
                    }
                    break;

                case 'CDFC Member':
                case 'Admin':
                case 'Super Admin':
                    // No filtering - can see all projects
                    break;
            }
        }

        // Union the queries
        return $query->union($disasterQuery)->latest('created_at');
    }

    public function getTableRecordKey($record): string
    {
        return $record->type . '_' . $record->id;
    }

    public static function canView(): bool
    {
        return checkCommunityProjectReadPermission() || checkDisasterProjectReadPermission();
    }
}
