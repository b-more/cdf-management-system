<?php

namespace App\Filament\Resources\EmpowermentResource\Pages;

use App\Filament\Resources\EmpowermentResource;
use Filament\Resources\Pages\ListRecords;

class ListEmpowerments extends ListRecords
{
    protected static string $resource = EmpowermentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make()
                ->visible(fn () => \checkEmpowermentCreatePermission()),
        ];
    }
}
