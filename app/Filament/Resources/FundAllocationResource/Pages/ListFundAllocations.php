<?php

namespace App\Filament\Resources\FundAllocationResource\Pages;

use App\Filament\Resources\FundAllocationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFundAllocations extends ListRecords
{
    protected static string $resource = FundAllocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
