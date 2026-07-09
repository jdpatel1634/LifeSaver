<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DonorRegistrationController extends Controller
{
    /**
     * Show the donor registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
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

        $states = collect();
        $cities = collect();

        return view('donor-register', compact('bloodGroups', 'states', 'cities'));
    }

    /**
     * Handle the submission of the donor registration form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerDonor(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:20',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date',
            'address' => 'nullable|string',
            'state_id' => 'nullable',
            'city_id' => 'nullable',
            'blood_group_id' => 'required',
        ]);

        return redirect()
            ->back()
            ->with('success', 'Thank you for registering as a donor. Database saving will be connected in the next version.');
    }
}