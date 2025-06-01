<?php

namespace App\Filament\Resources\EmpowermentGrantResource\Pages;

use App\Filament\Resources\EmpowermentGrantResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmpowermentGrants extends ListRecords
{
    protected static string $resource = EmpowermentGrantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
