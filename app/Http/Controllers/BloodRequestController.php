<?php

namespace App\Http\Controllers;

use App\Models\BloodGroup;
use App\Models\BloodRequest;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BloodRequestController extends Controller
{
    /**
     * Show the blood request form.
     *
     * @return \\Illuminate\\View\\View
     */
    public function showForm()
    {
        $bloodGroups = BloodGroup::all();
        return view('blood-request', compact('bloodGroups'));
    }

    /**
     * Handle the submission of the blood request form.
     *
     * @param  \\Illuminate\\Http\\Request  $request
     * @return \\Illuminate\\Http\\RedirectResponse
     */
    public function submitForm(Request $request)
    {
        // 1. Validate the incoming request data.
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile_number' => 'nullable|string|max:20',
            'email' => 'required|string|email|max:255',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date',
            'address' => 'nullable|string',
            'hospital_name' => 'required|string|max:255',
            'blood_group_id' => 'required|exists:blood_groups,id',
            'units_requested' => 'required|integer|min:1',
            'urgency_level' => 'required|in:routine,urgent,emergency',
            'required_by_date' => 'nullable|date|after_or_equal:today',
            'description' => 'nullable|string',
        ]);

        // 2. Check if a user with the given email already exists.
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // If user exists, check if they are a patient.
            if ($user->isPatient()) {
                // If it's an existing patient, instruct them to log in and make a new request.
                return redirect()->back()->withErrors(['email' => 'You are already registered as a patient. Please log in to your panel to submit a new blood request.'])->withInput();
            } else {
                // If user exists but is not a patient (e.g., donor or admin), prevent registration with the same email.
                return redirect()->back()->withErrors(['email' => 'An account with this email already exists with a different role. Please use a different email or log in with your existing account.'])->withInput();
            }
        }

        // 3. Begin a database transaction to ensure atomicity.
        DB::beginTransaction();

        try {
            // 4. Create a new User record with 'patient' role.
            $password = Str::random(12); // Generate a random password for the user
            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($password), // Hash the password
                'role' => 'patient',
            ]);

            // 5. Create a new Patient record, linking it to the newly created user.
            $patient = Patient::create([
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'mobile_number' => $request->mobile_number,
                'email' => $request->email,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'address' => $request->address,
                'hospital_name' => $request->hospital_name,
            ]);

            // 6. Create a new BloodRequest record, linking it to the patient.
            BloodRequest::create([
                'patient_id' => $patient->id,
                'blood_group_id' => $request->blood_group_id,
                'units_requested' => $request->units_requested,
                'urgency_level' => $request->urgency_level,
                'request_date' => Carbon::now(),
                'required_by_date' => $request->required_by_date,
                'status' => 'pending', // Initial status is pending
                'description' => $request->description,
            ]);

            // 7. Send password reset link to the patient's email.
            // For a real application, you would typically use Laravel's built-in password reset functionality.
            // For this example, we'll simulate sending a simple email.
            $token = Str::random(60);
            DB::table('password_reset_tokens')->insert([
                'email' => $user->email,
                'token' => Hash::make($token),
                'created_at' => Carbon::now(),
            ]);

            $resetLink = url(route('password.reset', ['token' => $token, 'email' => $user->email]));

            Mail::raw("Hello " . $user->name . ",\n\nYour blood request has been registered. Please use the following link to set your password and access your patient panel: " . $resetLink . "\n\nThank you!", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Blood Request Registered & Set Your Password');
            });

            DB::commit(); // Commit the transaction.

            return redirect()->back()->with('success', 'Blood request registered successfully! A password reset link has been sent to your email to set up your account.');

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error.
            \Log::info($e);
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred while processing your request. Please try again.']);
        }
    }
}
