<?php

namespace App\Http\Controllers;

use App\Models\BloodGroup;
use App\Models\City;
use App\Models\Donor;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class DonorRegistrationController extends Controller
{
    /**
     * Show the donor registration form.
     *
     * @return \\Illuminate\\View\\View
     */
    public function showRegistrationForm()
    {
        $bloodGroups = BloodGroup::all();
        $states = State::all();
        $cities = City::all(); // You might want to filter this by state dynamically with JavaScript

        return view('donor-register', compact('bloodGroups', 'states', 'cities'));
    }

    /**
     * Handle the submission of the donor registration form.
     *
     * @param  \\Illuminate\\Http\\Request  $request
     * @return \\Illuminate\\Http\\RedirectResponse
     */
    public function registerDonor(Request $request)
    {
        // 1. Validate the incoming request data.
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|unique:donors|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date',
            'address' => 'nullable|string',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'blood_group_id' => 'required|exists:blood_groups,id',
        ]);

        // 2. Check if a user with the given email already exists.
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // If user exists, prevent registration with the same email.
            return redirect()->back()->withErrors(['email' => 'An account with this email already exists. Please use a different email or log in with your existing account.'])->withInput();
        }

        // 3. Begin a database transaction to ensure atomicity.
        DB::beginTransaction();

        try {
            // 4. Create a new User record with 'donor' role.
            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'donor',
            ]);

            // 5. Create a new Donor record, linking it to the newly created user.
            Donor::create([
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'mobile_number' => $request->mobile_number,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'address' => $request->address,
                'city_id' => $request->city_id,
                'state_id' => $request->state_id,
                'blood_group_id' => $request->blood_group_id,
                'status' => 'pending_verification', // Crucial: Initial status as per requirements
            ]);

            DB::commit(); // Commit the transaction.

            return redirect()->back()->with('success', 'Thank you for registering! Your account is pending verification by our team. You will be notified once it is active.');

        } catch (Exception $e) {
            DB::rollBack(); // Rollback the transaction on error.
            Log::error("Donor registration failed: " . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred during registration. Please try again.']);
        }
    }
}
