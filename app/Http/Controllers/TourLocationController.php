<?php

namespace App\Http\Controllers;

use App\Models\TourLocation;
use Illuminate\Http\Request;

class TourLocationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'tour_location' => 'required|string|max:255',
            'tour_places_name' => 'required|string|max:255',
        ]);
    
        TourLocation::create($request->all());
    
        // Redirect back with success message
        return redirect()->back()->with('success', 'Tour Location added successfully.');
    }
}
