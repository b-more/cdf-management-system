<?php

namespace App\Filament\Resources\PublicApplicationResource\Pages;

use App\Filament\Resources\PublicApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPublicApplication extends ViewRecord
{
    protected static string $resource = PublicApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
