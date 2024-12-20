<?php

namespace App\Http\Controllers;

// use App\Models\AirlineDetails;
use App\Models\FoodType;
use App\Models\HotelLocation;
use App\Models\HotelType;
use App\Models\Meals;
use App\Models\Quote;
use App\Models\Service;
// use App\Models\Temp;
use App\Models\TempService;
use App\Models\Ticket;
use App\Models\Total;
use App\Models\TourLocation;
use Barryvdh\DomPDF\Facade\Pdf;
// use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class TempController extends Controller
{
    public function create()
    {
        $lastQuote = Quote::latest()->first();
        $ticketTypes = Ticket::all(); // Assuming you have a TicketType model
        $hotelTypes = HotelType::all();   // Assuming you have a HotelType model
        $hotelLocations = HotelLocation::all(); // Assuming you have a HotelLocation model
        $foodTypes = FoodType::all();    // Assuming you have a FoodType model
        $meals = Meals::all();            // Assuming you have a Meal model
        $tourLocations = TourLocation::all(); // Assuming you have a TourLocation model
        $services = Service::all();       // Assuming you have a Service model

        return view('_temp.temp', compact(
            'lastQuote', 'ticketTypes', 'hotelTypes', 'hotelLocations', 'foodTypes', 'meals', 'tourLocations', 'services'
        ));
    }

    public function store(Request $request)
    {
        // dd($request);
        // Validate incoming request data
        $validated = $request->validate([
            'quote_id'     => 'required|exists:quotes,id',
            'details'      => 'required|array',
            'details.*'    => 'nullable|string',
            'description.*'=> 'nullable|string',
            'qty.*'        => 'nullable|integer|min:1',
            'rate.*'       => 'nullable|numeric|min:0',
            'amount_rs.*'  => 'nullable|numeric|min:0',
            'amount_usd.*' => 'nullable|numeric|min:0',
            'airline_details' => 'nullable|string',
            'booking_summary' => 'nullable|string',
            'lkrtotal' => 'nullable|numeric|min:0',
            'usdtotal' => 'nullable|numeric|min:0',
            'tax'        => 'nullable|integer|min:0',
            'lkrgrand_total' => 'nullable|numeric|min:0',
            'usdgrand_total' => 'nullable|numeric|min:0',
        ]);

        // Store data into database
        foreach ($request->details as $key => $detailType) {
            $description = $this->getDescriptionByDetailType($detailType, $request->description[$key] ?? null);

            TempService::create([
                'quote_id'   => $request->quote_id,
                'detail_type'=> $detailType,
                'description'=> $description,
                'qty'        => $request->qty[$key] ?? null,
                'rate'       => $request->rate[$key] ?? null,
                'amount_rs'  => $request->amount_rs[$key] ?? null,
                'amount_usd' => $request->amount_usd[$key] ?? null,
            ]);
        }

        // Store airline details if provided
        $airline = new Total();
        $airline->quote_id = $request->quote_id;
        $airline->airline_details = $request->airline_details ?? null;
        $airline->booking_summary = $request->booking_summary ?? null;
        $airline->lkr_total = $request->lkrtotal ?? null;
        $airline->usd_total = $request->usdtotal ?? null;
        $airline->tax = $request->tax ?? null;
        $airline->lkr_grand_total = $request->lkrgrand_total ?? null;
        $airline->usd_grand_total = $request->usdgrand_total ?? null;
        $airline->save();

        // Redirect to a route to generate PDF
        return redirect()->route('generate.pdf', ['quote_id' => $validated['quote_id']]);
    }


    private function getDescriptionByDetailType(string $detailType, ?string $providedDescription): string
    {
        if (!empty($providedDescription)) {
            return $providedDescription;
        }

        return match ($detailType) {
            'Ticket'         => Ticket::inRandomOrder()->value('ticket_type') ?? 'Default Ticket Type',
            'Hotel Type'     => HotelType::inRandomOrder()->value('hotel_type') ?? 'Default Hotel Type',
            'Hotel Location' => HotelLocation::inRandomOrder()->selectRaw("CONCAT(hotel_location, ' - ', hotel_name) AS full_name")
                                ->value('full_name') ?? 'Default Hotel Location',
            'Food Type'      => FoodType::inRandomOrder()->value('food_type') ?? 'Default Food',
            'Meals'          => Meals::inRandomOrder()->value('meals_name') ?? 'Default Meal',
            'Tour Location'  => TourLocation::inRandomOrder()->selectRaw("CONCAT(tour_location, ' - ', tour_places_name) AS full_name")
                                ->value('full_name') ?? 'Default Tour Location',
            'Other Services' => Service::inRandomOrder()->value('service_name') ?? 'Default Service',
            default          => 'No description available',
        };
    }

    public function generatePDF($quote_id)
    {
        // Retrieve the relevant quote and services
        $quote = Quote::findOrFail($quote_id); // Assuming you have a Quote model
        $services = TempService::where('quote_id', $quote_id)->get();

        // Retrieve client information (assuming a relationship exists between Quote and Client)
        $client = $quote->client; // Ensure the `Quote` model has a relationship with the `Client` model

        // Retrieve airline details (assuming the airline information is stored in the 'Total' model)
        $airline = Total::where('quote_id', $quote_id)->first();

        // Check if the data exists for all variables
        if (!$quote || !$services || !$client || !$airline) {
            return response()->json(['error' => 'Required data not found'], 404);
        }

        // Calculate totals
        $totalLKR = $services->sum('amount_rs');
        $totalUSD = $services->sum('amount_usd');
        $taxPercentage = $airline->tax; // Tax percentage
        $taxAmountLKR = ($totalLKR * $taxPercentage) / 100;
        $taxAmountUSD = ($totalUSD * $taxPercentage) / 100;
        $grandTotalLKR = $totalLKR + $taxAmountLKR;
        $grandTotalUSD = $totalUSD + $taxAmountUSD;

        // Pass the calculated values to the Blade view
        $pdf = PDF::loadView('pdf.temp_services', compact(
            'quote',
            'services',
            'client',
            'airline',
            'totalLKR',
            'totalUSD',
            'taxPercentage',
            'taxAmountLKR',
            'taxAmountUSD',
            'grandTotalLKR',
            'grandTotalUSD'
        ));

        // Sanitize the quote ID to avoid / and \ characters
        $sanitizedQuoteId = str_replace(['/', '\\'], '_', $quote->quote_id);

        // Return the PDF with a sanitized filename
        return $pdf->stream('invoice_' . $sanitizedQuoteId . '.pdf'); // stream - PDF Show
    }




}
