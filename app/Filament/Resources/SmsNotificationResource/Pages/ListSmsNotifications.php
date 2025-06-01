<?php

namespace App\Filament\Resources\SmsNotificationResource\Pages;

use App\Filament\Resources\SmsNotificationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSmsNotifications extends ListRecords
{
    protected static string $resource = SmsNotificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
