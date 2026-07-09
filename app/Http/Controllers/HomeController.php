<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $latestCamps = collect();
        $availableUnitsCount = 0;
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

        $searchedBloodGroup = null;

        return view('home', compact(
            'latestCamps',
            'availableUnitsCount',
            'bloodGroups',
            'searchedBloodGroup'
        ));
    }

    public function handleSearch(Request $request)
    {
        $request->validate([
            'blood_group_id' => 'required',
        ]);

        $latestCamps = collect();
        $availableUnitsCount = 0;

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

        $searchedBloodGroup = $bloodGroups->firstWhere('id', (int) $request->blood_group_id);

        return view('home', compact(
            'latestCamps',
            'availableUnitsCount',
            'bloodGroups',
            'searchedBloodGroup'
        ));
    }
}