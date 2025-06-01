<?php

namespace App\Filament\Resources\MonitoringReportResource\Pages;

use App\Filament\Resources\MonitoringReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMonitoringReport extends EditRecord
{
    protected static string $resource = MonitoringReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
