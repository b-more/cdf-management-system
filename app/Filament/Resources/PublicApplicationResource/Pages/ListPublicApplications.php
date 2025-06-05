<?php

namespace App\Filament\Resources\PublicApplicationResource\Pages;

use App\Filament\Resources\PublicApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPublicApplications extends ListRecords
{
    protected static string $resource = PublicApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Actions\Action::make('export_applications')
                ->label('Export Applications')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('info')
                ->action(function () {
                    // Implement CSV export logic here
                    $this->notify('success', 'Applications exported successfully!');
                }),
        ];
    }
}
