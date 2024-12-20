<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Quote;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        // Retrieve all clients
        $clients = Client::all();
        return view('_client.clients', compact('clients'));
    }

    public function create()
    {
        // Return the view for creating a new client
        return view('_client.clients_form');
    }

    public function edit($id)
    {
        // Find the client by ID
        $client = Client::findOrFail($id);

        // Return the view with the client data for editing
        return view('_client.clients_edit', compact('client'));
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'salutation' => 'nullable|string|max:10',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'display_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $id, // Exclude current email from unique check
            'mobile_phone' => 'nullable|string|max:15',
            'tour_consultant' => 'nullable|string|max:255',
            'source' => 'nullable|string|max:255',
        ]);

        // Find the client by ID
        $client = Client::findOrFail($id);

        // Update client information
        $client->salutation = $request->salutation;
        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->display_name = $request->display_name; // This should also be auto-filled on the frontend
        $client->email = $request->email;
        $client->mobile_phone = $request->mobile_phone;
        $client->tour_consultant = $request->tour_consultant;
        $client->source = $request->source;

        // Save the updated client information
        $client->save();

        // Redirect with a success message
        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    public function show($id)
    {
        // Find the client by ID
        $client = Client::findOrFail($id);

        // Return the view with the client data
        return view('_client.clients_overview', compact('client')); // Corrected view path
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'salutation' => 'nullable|string|max:10',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'display_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'mobile_phone' => 'nullable|string|max:15',
            'tour_consultant' => 'nullable|string|max:255',
            'source' => 'nullable|string|max:255',
        ]);

        // Create a new client instance and save it to the database
        $client = new Client();
        $client->salutation = $request->salutation;
        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->display_name = $request->display_name; // This will be auto-filled on the frontend
        $client->email = $request->email;
        $client->mobile_phone = $request->mobile_phone;
        $client->tour_consultant = $request->tour_consultant;
        $client->source = $request->source;

        // Save the client
        $client->save();

        // Redirect with a success message
        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Fetch clients based on the search query
        $clients = Client::where('display_name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->orWhere('custom_id', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($clients);
    }

}
