<?php

namespace App\Http\Controllers;

use App\Models\TicketReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class TicketReservationController extends Controller
{
    public function store(Request $request)
    {
        // Validate the input data
        $validator = Validator::make($request->all(), [
            'quote_id' => 'required|exists:quotes,id',
            'ticket_type' => 'required|exists:tickets,id',
            'ticket_quantity' => 'required|integer|min:1',
            'ticket_rate' => 'required|numeric|min:0',
            'airline_details' => 'nullable|string',
            'booking_summary' => 'nullable|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        // Fetch the latest exchange rate for USD to LKR
        $response = Http::get('https://api.exchangerate-api.com/v4/latest/USD');

        // Check if the response is successful
        if ($response->successful()) {
            $exchangeRateData = $response->json();
            $usdToLkrRate = $exchangeRateData['rates']['LKR'] ?? 400; // Fallback to 400 if not available
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to fetch exchange rate.'], 500);
        }

        // Calculate the amounts
        $ticketQuantity = $request->ticket_quantity;
        $ticketRate = $request->ticket_rate;
        $amountLKR = $ticketRate * $ticketQuantity; // Calculate amount in LKR
        $amountUSD = $ticketRate * $ticketQuantity / $usdToLkrRate; // Assuming the rate is in USD

        // Create a new TicketReservation record
        $ticketReservation = TicketReservation::create([
            'quote_id' => $request->quote_id,
            'ticket_id' => $request->ticket_type,
            'details' => 'Ticket', // Adjust based on your requirement
            'quantity' => $ticketQuantity,
            'rate' => $ticketRate,
            'amount_lkr' => $amountLKR,
            'amount_usd' => $amountUSD,
            'airline_details' => $request->airline_details,
            'booking_summary' => $request->booking_summary,
        ]);

        // Return a response
        if ($ticketReservation) {
            return response()->json(['success' => true, 'message' => 'Ticket reservation saved successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to save ticket reservation.'], 500);
        }
    }

}
