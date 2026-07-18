<?php

namespace App\Filament\Resources\DonorResource\Pages;

use App\Filament\Resources\DonorResource;
use App\Models\User; // <-- Add this import
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model; // <-- Add this import
use Illuminate\Support\Facades\DB; // <-- Add this import
use Illuminate\Support\Facades\Hash; // <-- Add this import

class CreateDonor extends CreateRecord
{
    protected static string $resource = DonorResource::class;

    /**
     * Override the default creation logic to create a User first.
     *
     * @param array $data The validated form data.
     * @return Model The newly created Donor model.
     */
    protected function handleRecordCreation(array $data): Model
    {
        // Use a transaction to ensure both models are created or none are.
        return DB::transaction(function () use ($data) {
            // 1. Create the User
            $user = User::create([
                'name' => $data['first_name'] . ' ' . $data['last_name'],
                'email' => $data['user_email'],
                'password' => Hash::make($data['password']), // Hash the password here
                'role' => 'donor',
            ]);

            // 2. Prepare the Donor data
            $donorData = $data;
            $donorData['user_id'] = $user->id; // Assign the new user's ID

            // 3. Unset the temporary user fields from the donor data array
            unset($donorData['user_name'], $donorData['user_email'], $donorData['password'], $donorData['password_confirmation']);

            // 4. Create the Donor using the static create method on the Resource's model
            return static::getModel()::create($donorData);
        });
    }
}