<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BloodGroup;
use App\Models\BloodUnit;
use App\Models\Camp;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $latestCamps = Camp::where('status', 'active')
            ->orderBy('camp_date', 'desc')
            ->get();

        $availableUnitsCount = BloodUnit::where('status', 'ready_for_issue')
            ->where('serology_test_status', 'passed')
            ->where('expiry_date', '>=', Carbon::today())
            ->whereDoesntHave('reservedUnit', function ($query) {
                $query->where('status', 'active');
            })
            ->count();

        $bloodGroups = BloodGroup::orderBy('group_name')->get();
        $searchedBloodGroup = null;

        return view('home', compact('latestCamps', 'availableUnitsCount', 'bloodGroups', 'searchedBloodGroup'));
    }

    public function handleSearch(Request $request)
    {
        // 1. Validate the user's input
        $request->validate([
            'blood_group_id' => 'required|exists:blood_groups,id',
        ]);

        $bloodGroupId = $request->input('blood_group_id');

        // 2. Build the query on the BloodUnit model
        $availableUnitsCount = BloodUnit::query()
            // Condition 1: Match the requested blood group
            ->where('blood_group_id', $bloodGroupId)

            // Condition 2: Must be ready for issue
            ->where('status', 'ready_for_issue')

            // Condition 3: Must have passed safety tests
            ->where('serology_test_status', 'passed')

            // Condition 4: Must not be expired
            ->where('expiry_date', '>=', Carbon::today())

            // Condition 5: Must NOT have an active reservation
            // This checks the `reserved_units` table for a related record with 'active' status.
            ->whereDoesntHave('reservedUnit', function ($query) {
                $query->where('status', 'active');
            })

            // 3. Get the final count of available units
            ->count();
            
        // Get the blood group name to display in the results
        $searchedBloodGroup = BloodGroup::find($bloodGroupId);

        // Fetch latest camps and all blood groups again for the home page
        $latestCamps = Camp::where('status', 'active')
            ->orderBy('camp_date', 'desc')
            ->limit(3)
            ->get();

        $bloodGroups = BloodGroup::orderBy('group_name')->get();

        // 4. Return the result to the home view
        return view('home', compact('latestCamps', 'availableUnitsCount', 'bloodGroups', 'availableUnitsCount', 'searchedBloodGroup'));
    }
}