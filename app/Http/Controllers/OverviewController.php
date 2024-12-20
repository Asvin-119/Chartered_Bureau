<?php

namespace App\Http\Controllers;

use App\Models\FoodandBeverage;
use App\Models\TicketReservation;
use App\Models\HotelReservation;
use App\Models\TourLocation;
use App\Models\OtherService;
use Illuminate\Http\Request;

class OverviewController extends Controller
{
    public function showAllDetails($id)
    {
        // Retrieve all relevant data
        $ticketReservation = TicketReservation::with('customer', 'flightDetails')->findOrFail($id);
        $hotelReservation = HotelReservation::with('customer', 'hotel')->where('ticket_reservation_id', $id)->first();
        $foodBeverage = FoodandBeverage::with('orderDetails')->where('ticket_reservation_id', $id)->first();
        $tourLocation = TourLocation::with('transportOptions')->where('ticket_reservation_id', $id)->first();
        $otherService = OtherService::with('quote', 'service')->where('ticket_reservation_id', $id)->first();

        // Pass all the data to the view
        return view('overview.all_details', compact(
            'ticketReservation',
            'hotelReservation',
            'foodBeverage',
            'tourLocation',
            'otherService'
        ));
    }
}

