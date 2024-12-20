<?php

namespace App\Http\Controllers;

use App\Models\FoodType;
use App\Models\HotelLocation;
use App\Models\HotelType;
use App\Models\Meals;
use App\Models\Quote;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\TourLocation;
use Barryvdh\DomPDF\Facade\Pdf;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;

class QuoteIdController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            // Add validation rules for other fields if necessary
        ]);

        // Create a new Quotation
        $quotation = Quote::create([
            'client_id' => $request->input('client_id'),
            // Add other fields here if needed
        ]);

        // Redirect or return a response
        return redirect()->route('quotation.index_add_form');
    }

    public function ticket(){
        $lastQuote = Quote::orderBy('created_at', 'desc')->first(); // Get the latest quote
        $ticketTypes = Ticket::all();

        return view('form.ticket_reservation', compact('lastQuote', 'ticketTypes'));

        // return view('form.ticket_reservation',compact('quotes', 'ticketTypes'));
    }

    public function hotel(){
        $lastQuote = Quote::orderBy('created_at', 'desc')->first(); // Get the latest quote
        $hotel_types = HotelType::all();
        $hotel_locations = HotelLocation::all();

        return view('form.hotel_reservation', compact('lastQuote', 'hotel_types', 'hotel_locations'));
    }

    public function food(){
        $lastQuote = Quote::orderBy('created_at', 'desc')->first(); // Get the latest quote
        $food_types = FoodType::all();
        $meals = Meals::all();

        return view('form.food_&_beverage', compact('lastQuote', 'food_types', 'meals'));
    }

    public function tour(){
        $lastQuote = Quote::orderBy('created_at', 'desc')->first(); // Get the latest quote
        $tour_locations = TourLocation::all();

        return view('form.tour_location', compact('lastQuote', 'tour_locations'));
    }

    public function service(){
        $lastQuote = Quote::orderBy('created_at', 'desc')->first(); // Get the latest quote
        $services = Service::all();

        return view('form.other_services', compact('lastQuote', 'services'));
    }

    public function generatePdf($quoteId)
    {
        $quote = Quote::with('customer', 'services')->findOrFail($quoteId);
        $customer = $quote->customer;
        $services = $quote->services;
        $totalRs = $services->sum('amount_rs');
        $totalUsd = $services->sum('amount_usd');

        $pdf = Pdf::loadView('pdf_view', compact('quote', 'customer', 'services', 'totalRs', 'totalUsd'));
        return $pdf->download('Quotation-' . $quote->quote_id . '.pdf');
    }
}
