<?php

namespace App\Filament\Resources\ReservedUnitResource\Pages;

use App\Filament\Resources\ReservedUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReservedUnit extends EditRecord
{
    protected static string $resource = ReservedUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
