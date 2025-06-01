<?php

namespace App\Filament\Resources\EmpowermentResource\Pages;

use App\Filament\Resources\EmpowermentResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateEmpowerment extends CreateRecord
{
    protected static string $resource = EmpowermentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Auto-generate program code if not provided
        if (empty($data['program_code'])) {
            $data['program_code'] = 'EMP-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        }

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        return EmpowermentResource::handleRecordCreation($data);
    }
}
