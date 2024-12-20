<?php

namespace App\Http\Controllers;

use App\Models\FoodandBeverage;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Http;

class FoodandBeverageController extends Controller
{

    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'quote_id' => 'required|exists:quotes,id',
            'food_type' => 'required|array',
            'food_type.*' => 'exists:food_types,id',
            'foodtype_rate' => 'required|numeric|min:0',
            'meals' => 'required|array',
            'meals.*' => 'exists:meals,id',
        ]);

        // Fetch the latest exchange rate for USD to LKR
        $response = Http::get('https://api.exchangerate-api.com/v4/latest/USD');

        // Check if the response is successful
        if ($response->successful()) {
            $exchangeRateData = $response->json();
            $usdToLkrRate = $exchangeRateData['rates']['LKR'] ?? 400; // Fallback to 400 if not available
        } else {
            return response()->json(['message' => 'Failed to fetch exchange rate.'], 500);
        }

        // Convert food_type and meals arrays to JSON or comma-separated strings
        $foodTypeIds = json_encode($validated['food_type']); // Convert to JSON
        $mealsIds = json_encode($validated['meals']); // Convert to JSON

        // Calculate the amounts
        $rate = $validated['foodtype_rate'];
        $amountRs = $rate; // Convert the rate to LKR
        $amountUsd = $rate / $usdToLkrRate; // Assume the rate is already in USD

        // Insert the data
        FoodandBeverage::create([
            'quote_id' => $validated['quote_id'],
            'food_type' => $foodTypeIds,
            'rate' => $rate,
            'mealamount_rs' => $amountRs,
            'mealamount_usd' => $amountUsd,
            'meals' => $mealsIds,
        ]);

        // Return a success response
        return response()->json([
            'message' => 'Successfully added!',
        ], 200);
    }


}
