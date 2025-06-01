<?php

namespace App\Filament\Resources\GrantRepaymentResource\Pages;

use App\Filament\Resources\GrantRepaymentResource;
use Filament\Resources\Pages\ViewRecord;

class ViewGrantRepayment extends ViewRecord
{
    protected static string $resource = GrantRepaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\EditAction::make()
                ->visible(fn () => \checkGrantRepaymentUpdatePermission()),
            \Filament\Actions\DeleteAction::make()
                ->visible(fn () => \checkGrantRepaymentDeletePermission()),
        ];
    }

    public function mount(int | string $record): void
    {
        parent::mount($record);

        // Log view activity
        GrantRepaymentResource::logActivity('View', $this->record);
    }
}
