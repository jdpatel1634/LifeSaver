<?php

namespace App\Filament\Resources\BloodUnitResource\Pages;

use App\Filament\Resources\BloodUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Donor;
use Illuminate\Database\Eloquent\Model;

class CreateBloodUnit extends CreateRecord
{
    protected static string $resource = BloodUnitResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        // Automatically calculate expiry_date (e.g., 42 days from collection_date)
        $data['expiry_date'] = \Illuminate\Support\Carbon::parse($data['collection_date'])->addDays(42);
        
        // Set initial status to 'test_awaited'
        $data['status'] = 'test_awaited';
        $data['serology_test_status'] = 'pending';

        $bloodUnit = parent::handleRecordCreation($data);

        // Update donor's last_donation_date
        $donor = Donor::find($bloodUnit->donor_id);
        if ($donor) {
            $donor->last_donation_date = $bloodUnit->collection_date;
            // Calculate eligible_to_donate_until (e.g., 12 weeks from last_donation_date)
            $donor->eligible_to_donate_until = $bloodUnit->collection_date->addWeeks(12);
            $donor->save();
        }

        return $bloodUnit;
    }
}
