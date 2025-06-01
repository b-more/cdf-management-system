<?php

namespace App\Filament\Resources\GrantRepaymentResource\Pages;

use App\Filament\Resources\GrantRepaymentResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Pages\Concerns\ExposesTableToWidgets;

class ListGrantRepayments extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = GrantRepaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make()
                ->visible(fn () => \checkGrantRepaymentCreatePermission()),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            GrantRepaymentResource\Widgets\RepaymentStatsWidget::class,
        ];
    }
}
