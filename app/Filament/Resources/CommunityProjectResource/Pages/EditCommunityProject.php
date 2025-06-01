<?php

namespace App\Filament\Resources\CommunityProjectResource\Pages;

use App\Filament\Resources\CommunityProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCommunityProject extends EditRecord
{
    protected static string $resource = CommunityProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
