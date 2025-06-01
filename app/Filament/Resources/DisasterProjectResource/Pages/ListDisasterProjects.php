<?php

namespace App\Filament\Resources\DisasterProjectResource\Pages;

use App\Filament\Resources\DisasterProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDisasterProjects extends ListRecords
{
    protected static string $resource = DisasterProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
