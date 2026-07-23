<?php

namespace App\Filament\Resources\ReservedUnitResource\Pages;

use App\Filament\Resources\ReservedUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReservedUnits extends ListRecords
{
    protected static string $resource = ReservedUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
