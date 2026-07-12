<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BloodRequestController extends Controller
{
    /**
     * Show the blood request form.
     *
     * @return \Illuminate\View\View
     */
    public function showForm()
    {
        $bloodGroups = collect([
            (object) ['id' => 1, 'group_name' => 'A+'],
            (object) ['id' => 2, 'group_name' => 'A-'],
            (object) ['id' => 3, 'group_name' => 'B+'],
            (object) ['id' => 4, 'group_name' => 'B-'],
            (object) ['id' => 5, 'group_name' => 'O+'],
            (object) ['id' => 6, 'group_name' => 'O-'],
            (object) ['id' => 7, 'group_name' => 'AB+'],
            (object) ['id' => 8, 'group_name' => 'AB-'],
        ]);

        return view('blood-request', compact('bloodGroups'));
    }

    /**
     * Handle the submission of the blood request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitForm(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile_number' => 'nullable|string|max:20',
            'email' => 'required|string|email|max:255',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date',
            'address' => 'nullable|string',
            'hospital_name' => 'required|string|max:255',
            'blood_group_id' => 'required',
            'units_requested' => 'required|integer|min:1',
            'urgency_level' => 'required|in:routine,urgent,emergency',
            'required_by_date' => 'nullable|date|after_or_equal:today',
            'description' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            $patient = Patient::firstOrCreate(
                ['email' => $validated['email']],
                [
                    'first_name' => $validated['first_name'],
                    'last_name' => $validated['last_name'],
                    'mobile_number' => $validated['mobile_number'] ?? null,
                    'gender' => $validated['gender'],
                    'date_of_birth' => $validated['date_of_birth'],
                    'address' => $validated['address'] ?? null,
                    'hospital_name' => $validated['hospital_name'],
                ]
            );

            BloodRequest::create([
                'patient_id' => $patient->id,
                'blood_group_id' => $validated['blood_group_id'],
                'units_requested' => $validated['units_requested'],
                'urgency_level' => $validated['urgency_level'],
                'request_date' => now(),
                'required_by_date' => $validated['required_by_date'] ?? null,
                'status' => 'pending',
                'description' => $validated['description'] ?? null,
            ]);
        });

        return redirect()
            ->back()
            ->with('success', 'Blood request submitted successfully and saved to the database.');
    }
}