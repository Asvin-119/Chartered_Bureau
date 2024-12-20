@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Overview of Reservation Details</h1>

    <h2>Ticket Reservation</h2>
    <p><strong>Customer:</strong> {{ $ticketReservation->customer->name }}</p>
    <p><strong>Flight Details:</strong> {{ $ticketReservation->flightDetails->details }}</p>
    <!-- Add other ticket reservation fields here -->

    <h2>Hotel Reservation</h2>
    @if($hotelReservation)
        <p><strong>Hotel:</strong> {{ $hotelReservation->hotel->name }}</p>
        <p><strong>Check-in:</strong> {{ $hotelReservation->check_in_date }}</p>
        <p><strong>Check-out:</strong> {{ $hotelReservation->check_out_date }}</p>
        <!-- Add other hotel reservation fields here -->
    @else
        <p>No hotel reservation found.</p>
    @endif

    <h2>Food & Beverage</h2>
    @if($foodBeverage)
        <p><strong>Order Details:</strong> {{ $foodBeverage->orderDetails }}</p>
        <!-- Add other food and beverage fields here -->
    @else
        <p>No food and beverage orders found.</p>
    @endif

    <h2>Tour Location Transport</h2>
    @if($tourLocation)
        <p><strong>Transport Options:</strong> {{ $tourLocation->transportOptions }}</p>
        <!-- Add other tour location fields here -->
    @else
        <p>No tour location found.</p>
    @endif

    <h2>Other Services</h2>
    @if($otherService)
        <p><strong>Service:</strong> {{ $otherService->service->name }}</p>
        <!-- Add other service fields here -->
    @else
        <p>No other services found.</p>
    @endif
</div>
@endsection
