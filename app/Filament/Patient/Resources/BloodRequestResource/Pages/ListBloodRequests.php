<?php

namespace App\Filament\Patient\Resources\BloodRequestResource\Pages;

use App\Filament\Patient\Resources\BloodRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBloodRequests extends ListRecords
{
    protected static string $resource = BloodRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
