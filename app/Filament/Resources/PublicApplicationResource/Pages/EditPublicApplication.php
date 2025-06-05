<?php

namespace App\Filament\Resources\PublicApplicationResource\Pages;

use App\Filament\Resources\PublicApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPublicApplication extends EditRecord
{
    protected static string $resource = PublicApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
