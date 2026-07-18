<?php

namespace App\Filament\Resources\DonorResource\Pages;

use App\Filament\Resources\PatientResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPatient extends ViewRecord
{
    protected static string $resource = PatientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\EditAction::make(), // Removing edit action as per requirement
        ];
    }
}
