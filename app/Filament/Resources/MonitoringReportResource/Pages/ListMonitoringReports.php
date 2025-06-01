<?php

namespace App\Filament\Resources\MonitoringReportResource\Pages;

use App\Filament\Resources\MonitoringReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMonitoringReports extends ListRecords
{
    protected static string $resource = MonitoringReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
