<?php

namespace App\Http\Controllers;

use App\Models\BloodGroup;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $bloodGroups = BloodGroup::orderBy('group_name')->get();
        $availableUnitsCount = 0;
        $latestCamps = collect();
        $searchedBloodGroup = null;

        return view('home', compact(
            'bloodGroups',
            'availableUnitsCount',
            'latestCamps',
            'searchedBloodGroup'
        ));
    }

    public function handleSearch(Request $request)
    {
        $request->validate([
            'blood_group_id' => 'required|exists:blood_groups,id',
        ]);

        $bloodGroups = BloodGroup::orderBy('group_name')->get();
        $availableUnitsCount = 0;
        $latestCamps = collect();
        $searchedBloodGroup = BloodGroup::find($request->input('blood_group_id'));

        return view('home', compact(
            'bloodGroups',
            'availableUnitsCount',
            'latestCamps',
            'searchedBloodGroup'
        ));
    }
}