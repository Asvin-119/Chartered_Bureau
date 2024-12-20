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


