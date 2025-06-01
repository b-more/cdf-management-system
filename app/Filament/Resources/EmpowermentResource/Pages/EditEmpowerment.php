<?php

namespace App\Filament\Resources\EmpowermentResource\Pages;

use App\Filament\Resources\EmpowermentResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditEmpowerment extends EditRecord
{
    protected static string $resource = EmpowermentResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Store current values for audit trail
        session(['empowerment_old_values' => $this->record->toArray()]);
        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        return EmpowermentResource::handleRecordUpdate($record, $data);
    }
}
