<?php

namespace App\Filament\Resources\EmpowermentGrantResource\Pages;

use App\Filament\Resources\EmpowermentGrantResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmpowermentGrant extends EditRecord
{
    protected static string $resource = EmpowermentGrantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
