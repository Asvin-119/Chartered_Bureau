<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
        ]);
    
        Service::create($request->all());
    
        // Redirect back with success message
        return redirect()->back()->with('success', 'Service added successfully.');
    }
}
