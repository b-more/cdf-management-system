<?php

namespace App\Filament\Resources\SmsNotificationResource\Pages;

use App\Filament\Resources\SmsNotificationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSmsNotification extends EditRecord
{
    protected static string $resource = SmsNotificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
