<?php

namespace App\Filament\Resources\PatientResource\Pages;

use App\Filament\Resources\PatientResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; // <-- Add this import
use Illuminate\Support\Facades\Hash;

class CreatePatient extends CreateRecord
{
    protected static string $resource = PatientResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        // Use a transaction to ensure both models are created successfully
        return DB::transaction(function () use ($data) {
            // 1. Create the User record
            $user = User::create([
                'name' => $data['user']['name'],
                'email' => $data['user']['email'],
                'password' => Hash::make($data['password']),
                'role' => 'patient',
            ]);

            // 2. Prepare the patient data
            $patientData = $data;
            $patientData['user_id'] = $user->id;

            // *** THE FIX IS HERE ***
            // The patient's email comes from the nested user array
            $patientData['email'] = $data['user']['email'];

            // 3. Unset data that doesn't belong in the patients table
            unset($patientData['user'], $patientData['password']);
            
            // 4. Create the Patient record
            return static::getModel()::create($patientData);
        });
    }
}