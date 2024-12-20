<?php

namespace App\Http\Controllers;

use App\Models\HotelReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class HotelReservationController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'quote_id' => 'required|exists:quotes,id',
            'hotel_type' => 'required|exists:hotel_types,id',
            'hotel_locations.*.id' => 'required|exists:hotel_locations,id',
            'hotel_locations.*.hlquantity' => 'required|integer|min:1',
            'hotel_locations.*.rate' => 'required|numeric|min:0',
        ]);

        // Fetch the latest exchange rate for USD to LKR
        $response = Http::get('https://api.exchangerate-api.com/v4/latest/USD');

        if ($response->successful()) {
            $data = $response->json();
            $usdToLkrRate = $data['rates']['LKR'] ?? 400; // Fallback to 400 if the rate is not found
        } else {
            return redirect()->back()->withErrors(['error' => 'Unable to fetch exchange rate.']);
        }

        // Loop through the hotel_locations array and insert each row
        foreach ($request->hotel_locations as $location) {
            HotelReservation::create([
                'quote_id' => $request->quote_id,
                'hotel_type_id' => $request->hotel_type,
                'hotel_location_id' => $location['id'],
                'hlquantity' => $location['hlquantity'],
                'rate' => $location['rate'],
                'hlamount_rs' => $location['hlquantity'] * $location['rate'],
                'hlamount_usd' => ($location['hlquantity'] * $location['rate']) / $usdToLkrRate,
            ]);
        }

        // Redirect to a page with a success message
        return redirect()->route('hotel.hotels.extra')->with('success', 'Hotel reservations added successfully.');
    }
}
