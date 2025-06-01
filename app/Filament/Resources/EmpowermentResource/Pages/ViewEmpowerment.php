<?php

namespace App\Filament\Resources\EmpowermentResource\Pages;

use App\Filament\Resources\EmpowermentResource;
use Filament\Resources\Pages\ViewRecord;

class ViewEmpowerment extends ViewRecord
{
    protected static string $resource = EmpowermentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\EditAction::make()
                ->visible(fn () => \checkEmpowermentUpdatePermission()),
            \Filament\Actions\DeleteAction::make()
                ->visible(fn () => \checkEmpowermentDeletePermission()),
        ];
    }

    public function mount(int | string $record): void
    {
        parent::mount($record);

        // Log view activity
        EmpowermentResource::logActivity('View', $this->record);
    }
}
