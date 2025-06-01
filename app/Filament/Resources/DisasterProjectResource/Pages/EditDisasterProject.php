<?php

namespace App\Filament\Resources\DisasterProjectResource\Pages;

use App\Filament\Resources\DisasterProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDisasterProject extends EditRecord
{
    protected static string $resource = DisasterProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
