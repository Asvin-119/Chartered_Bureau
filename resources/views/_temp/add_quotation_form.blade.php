@extends('dashboard.layout')

@section('title', 'Add Quotation')

@section('content')
<div class="container-fluid">
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-5">
                    <h4 class="fw-semibold mb-3">Add Quotation1</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Add Quotation</li>
                        </ol>
                    </nav>
                </div>

                <div class="col-3">
                    <input type="text" name="quote_id" class="form-control" style="color: #5864be; font-weight: bold;" id="quote_id" value="{{ $lastQuoteId }}" readonly>
                </div>

                <div class="col-1"></div>
                <div class="col-3 text-center mb-n5">
                    <img src="{{ asset('dist/images/breadcrumb/ChatBc.png') }}" alt="" class="img-fluid mb-n4">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="ticket_reservation-tab" data-bs-toggle="tab" data-bs-target="#ticket_reservation" type="button" role="tab" aria-controls="ticket_reservation" aria-selected="true">Ticket Reservation</button>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content" id="myTabContent" style="border-top: 2px solid #bfbfbf;">
        <div class="tab-pane fade show active" id="ticket_reservation" role="tabpanel" aria-labelledby="ticket_reservation-tab">
            {{-- @include('tab_content.ticket_reservation') --}}

            <form id="ticketReservation" class="pt-2" action="{{ route('ticket.ticket.reservations.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-end">
                            <input type="text" name="quote_id" class="form-control" style="color: #5864be; font-weight: bold;" id="quote_id" value="{{ $lastQuoteId }}" hidden>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 20%;">Details</th>
                                    <th style="width: 20%;">Description</th>
                                    <th style="width: 10%;">Quantity</th>
                                    <th style="width: 20%;">Rate</th>
                                    <th style="width: 15%;">Amount (Rs.)</th>
                                    <th style="width: 15%;">Amount ($)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="item-row">
                                    <td><strong>Ticket</strong></td>
                                    <td>
                                        <select name="ticket_type" class="form-control ticket_type select2" style="width: 100%;">
                                            <option value="">Select Ticket Type</option>
                                            @foreach($ticketTypes as $ticketType)
                                                <option value="{{ $ticketType->id }}">{{ $ticketType->ticket_type }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="number" name="ticket_quantity" class="form-control ticket_quantity" id="ticket_quantity" value="1" min="1"></td>
                                    <td><input type="number" name="ticket_rate" class="form-control ticket_rate" id="ticket_rate" value="0.00" min="0" step="0.01"></td>
                                    <td class="ticket_amount-rs" id="ticket_amount-rs">0.00</td>
                                    <td class="ticket_amount-usd" id="ticket_amount-usd">0.00</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="row mb-3">
                                    <div class="col-3 pt-4 ms-3"><strong>Airline Details</strong></div>
                                    <div class="col-8">
                                        <textarea name="airline_details" id="airline_details" class="form-control" style="resize: none; height: 80px;"></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-3 ps-3 pt-4 ms-3"><strong>Booking Summary</strong></div>
                                    <div class="col-8">
                                        <textarea name="booking_summary" id="booking_summary" class="form-control" style="resize: none; height: 80px;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary btn-icon-text mx-2">
                                <i class="mdi mdi-content-save btn-icon-prepend"></i> Save
                            </button>
                            <a href="{{ url()->previous() }}" class="btn btn-icon-text" style="background: #eeeeee;">
                                <i class="mdi mdi-cancel btn-icon-prepend"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>


    </div>
</div>

@endsection

@section('script')
<script>
    let usdToLkrRate = 0; // Exchange rate placeholder

    function fetchExchangeRate() {
        fetch('https://api.exchangerate-api.com/v4/latest/USD')
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                usdToLkrRate = data.rates.LKR;
                calculateAmounts(); // Calculate on exchange rate fetch
            })
            .catch(error => console.error('Error fetching exchange rate:', error));
    }

    function calculateAmounts() {
        const quantity = parseFloat(document.querySelector('.ticket_quantity').value) || 0;
        const rate = parseFloat(document.querySelector('.ticket_rate').value) || 0;
        const amountLKR = quantity * rate;
        const amountUSD = usdToLkrRate > 0 ? amountLKR / usdToLkrRate : 0;

        document.querySelector('.ticket_amount-rs').textContent = amountLKR.toFixed(2);
        document.querySelector('.ticket_amount-usd').textContent = amountUSD.toFixed(2);
    }

    document.addEventListener('DOMContentLoaded', function () {
        fetchExchangeRate(); // Fetch exchange rate on page load

        $('.select2').select2();

        const quantityInput = document.querySelector('.ticket_quantity');
        const rateInput = document.querySelector('.ticket_rate');

        quantityInput.addEventListener('input', calculateAmounts);
        rateInput.addEventListener('input', calculateAmounts);

        document.getElementById('ticketReservation').addEventListener('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(this);

            console.log("Form Data: ", Object.fromEntries(formData)); // Log form data for debugging

            $.ajax({
                url: this.action,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            text: 'Ticket reservation saved successfully.',
                            timer: 3000,
                            showConfirmButton: false
                        });
                        $('#ticketReservation')[0].reset();
                        $('.ticket_amount-rs').text("0.00");
                        $('.ticket_amount-usd').text("0.00");
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to save data.'
                        });
                    }
                },
                error: function (xhr, status, error) {
                    let errorMessage = 'An unexpected error occurred.';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = xhr.responseJSON.errors.quote_id[0] || 'Validation failed';
                        console.error('Validation Errors:', xhr.responseJSON.errors);
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage
                    });
                }
            });
        });
    });
</script>
@endsection
