<?php

namespace App\Filament\Resources\EmpowermentResource\Pages;

use App\Filament\Resources\EmpowermentResource;
use App\Models\AuditTrail;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class CreateEmpowerment extends CreateRecord
{
    protected static string $resource = EmpowermentResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Auto-generate program code if not provided
        if (empty($data['program_code'])) {
            $data['program_code'] = 'EMP-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->logAuditTrail('Create', 'Created empowerment program: ' . $this->record->title, null, $this->record->toArray());
    }

    private function logAuditTrail(string $action, string $description, ?array $oldValues = null, ?array $newValues = null): void
    {
        try {
            AuditTrail::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'table_name' => 'empowerments',
                'record_id' => $this->record->id,
                'old_values' => $oldValues ? json_encode($oldValues) : null,
                'new_values' => $newValues ? json_encode($newValues) : null,
                'description' => $description,
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to log audit trail: ' . $e->getMessage());
        }
    }
}

