<?php

namespace App\Http\Controllers;

use App\Models\FoodType;
use App\Models\HotelLocation;
use App\Models\HotelType;
use App\Models\Meals;
use App\Models\Quote;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\TourLocation;
use Illuminate\Http\Request;

class ExController extends Controller
{

    public function index()
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

    public function fetchData($type)
    {
        switch ($type) {
            case 'ticket':
                $data = Ticket::all(); // Replace with your model's data
                break;
            case 'hotel_type':
                $data = HotelType::all();
                break;
            case 'hotel_location':
                $data = HotelLocation::all();
                break;
            case 'food_type':
                $data = FoodType::all();
                break;
            case 'meals':
                $data = Meals::all();
                break;
            case 'tour_location':
                $data = TourLocation::all();
                break;
            case 'other_services':
                $data = Service::all();
                break;
            default:
                $data = [];
        }

        return response()->json($data);
    }
}
