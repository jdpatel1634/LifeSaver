<?php

namespace App\Filament\Resources\BloodRequestResource\Pages;

use App\Filament\Resources\BloodRequestResource;
use App\Filament\Resources\BloodRequestResource\Widgets\AvailableBloodUnits; // <-- IMPORT
use App\Filament\Resources\BloodRequestResource\Widgets\FulfilledBloodUnits;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBloodRequest extends EditRecord
{
    protected static string $resource = BloodRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // ADD THIS METHOD
    protected function getHeaderWidgets(): array
    {
        return [
            FulfilledBloodUnits::class, 
            AvailableBloodUnits::class,
        ];
    }
}