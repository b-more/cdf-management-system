<?php

namespace App\Filament\Resources\PublicApplicationResource\Pages;

use App\Filament\Resources\PublicApplicationResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePublicApplication extends CreateRecord
{
    protected static string $resource = PublicApplicationResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
