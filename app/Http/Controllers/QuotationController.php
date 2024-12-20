<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\FoodandBeverage;
use App\Models\HotelReservation;
use App\Models\OtherService;
use App\Models\Quote;
use App\Models\Ticket;
use App\Models\TicketReservation;
use App\Models\TourLocationTransport;
// use App\Models\TicketType;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    public function index(){

        // $quotes = TicketReservation::with(['quote', 'ticket'])->get();

        $quotes = collect()
        ->merge(TicketReservation::with(['quote', 'ticket'])->get())
        ->merge(HotelReservation::with(['quote', 'hotelType', 'hotelLocation'])->get())
        ->merge(FoodandBeverage::with(['quote', 'foodType', 'meals'])->get())
        ->merge(TourLocationTransport::with(['quote', 'tourLocationDetail'])->get())
        ->merge(OtherService::with(['quote', 'service'])->get());

        $clients = Client::all();
        // $ticketReservations = TicketReservation::with(['quote', 'ticket'])->get();
        // $hotelReservations = HotelReservation::with(['quote', 'hotelType', 'hotelLocation'])->get();

        //$hotelReservations = HotelReservation::with(['quote', 'hotelType', 'hotelLocation'])->get();
        //return view('quotation.quotation', compact('hotelReservations'));
        return view('quotation.quotation', compact('quotes','clients'));
    }

    public function index_form(){

        $clients = Client::all();
        return view('quotation.quotation_form',compact('clients'));
    }

    public function index_add_form(){
        $lastQuote = Quote::orderBy('created_at', 'desc')->first(); // Get the latest quote
        $ticketTypes = Ticket::all();

        return view('quotation.add_quotation_form', compact('lastQuote', 'ticketTypes'));
    }
}
