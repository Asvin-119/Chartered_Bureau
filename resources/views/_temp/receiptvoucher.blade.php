@extends('dashboard.layout')

@section('content')

<div class="container-fluid">
    <form id="receiptVoucherForm" action="{{ route('temp1.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6 pt-2">
                        <label for="rv_code" class="form-label">Receipt Voucher Code</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="rv_code" id="rv_code" class="form-control" value="{{ $rvcode->rv_code }}" readonly>
                    </div>
                </div>
            </div>
        </div>


        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr class="text-center">
                        <th style="width: 5%; background: #00007c; color: #fff; padding: 10px;">No</th>
                        <th style="width: 10%; background: #00007c; color: #fff; padding: 10px;">Code</th>
                        <th style="width: 50%; background: #00007c; color: #fff; padding: 10px;">Description</th>
                        <th style="width: 15%; background: #00007c; color: #fff; padding: 10px;">Amount (Rs.)</th>
                        <th style="width: 15%; background: #00007c; color: #fff; padding: 10px;">Amount ($)</th>
                        <th style="width: 5%; background: #00007c; color: #fff; padding: 10px;"></th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    <tr>
                        <td colspan="2" class="p-2">Amount in Words (Rs)</td>
                        <td colspan="4" class="p-2">
                            <input type="text" id="amount-in-words-rs" name="amount_in_words_rs" class="form-control" readonly>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="p-2">Amount in Words (USD)</td>
                        <td colspan="4" class="p-2">
                            <input type="text" id="amount-in-words-usd" name="amount_in_words_usd" class="form-control" readonly>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row pb-3">
            <div class="col-12 col-md-2 pt-2">
                <button type="button" class="btn btn-secondary btn-sm w-100" id="add-row" data-bs-toggle="tooltip">
                    <i class="fa-solid fa-circle-plus me-2"></i> Add New Row
                </button>
            </div>
        </div>

        <!-- Payment for -->
        <div class="pt-2">
            <h6 class="text-center p-2" style="background: #00007c; color: #fff;">The Payment for</h6>
            <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="checkbox" name="payment_for[]" id="air_ticket" value="Air Ticket">
                    <label for="air_ticket" class="ps-2">Air Ticket</label>
                </div>
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="checkbox" name="payment_for[]" id="parking_fee" value="Parking Fee">
                    <label for="parking_fee" class="ps-2">Parking Fee</label>
                </div>
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="checkbox" name="payment_for[]" id="highway_ticket" value="Highway Ticket">
                    <label for="highway_ticket" class="ps-2">Highway Ticket</label>
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row justify-content-between pt-2 gap-2">
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="checkbox" name="payment_for[]" id="hotel_booking" value="Hotel Booking">
                    <label for="hotel_booking" class="ps-2">Hotel Booking</label>
                </div>
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="checkbox" name="payment_for[]" id="food_beverage" value="Food & Beverage">
                    <label for="food_beverage" class="ps-2">Food & Beverage</label>
                </div>
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="checkbox" name="payment_for[]" id="transportation" value="Transportation">
                    <label for="transportation" class="ps-2">Transportation</label>
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row justify-content-between pt-2 gap-2">
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="checkbox" name="payment_for[]" id="tourist_guide" value="Tourist Guide">
                    <label for="tourist_guide" class="ps-2">Tourist Guide</label>
                </div>
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="checkbox" name="payment_for[]" id="vehicle_arrangement" value="Vehicle Arrangement">
                    <label for="vehicle_arrangement" class="ps-2">Vehicle Arrangement</label>
                </div>
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="checkbox" name="payment_for[]" id="interpreter" value="Interpreter">
                    <label for="interpreter" class="ps-2">Interpreter</label>
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row justify-content-between pt-2 gap-2">
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="checkbox" name="payment_for[]" id="airport_welcome" value="Airport Welcome">
                    <label for="airport_welcome" class="ps-2">Airport Welcome</label>
                </div>
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="checkbox" name="payment_for[]" id="medical_visa" value="Medical Visa">
                    <label for="medical_visa" class="ps-2">Medical Visa</label>
                </div>
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="checkbox" name="payment_for[]" id="tourist_visa" value="Tourist Visa">
                    <label for="tourist_visa" class="ps-2">Tourist Visa</label>
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row justify-content-between pt-2 gap-2">
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="checkbox" name="payment_for[]" id="travel_insurance" value="Travel Insurance">
                    <label for="travel_insurance" class="ps-2">Travel Insurance</label>
                </div>
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="checkbox" name="payment_for[]" id="diagnostic_services" value="Diagnostic Services">
                    <label for="diagnostic_services" class="ps-2">Diagnostic Services</label>
                </div>
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="checkbox" name="payment_for[]" id="laboratory_services" value="Laboratory Services">
                    <label for="laboratory_services" class="ps-2">Laboratory Services</label>
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row justify-content-between pt-2 gap-2">
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="checkbox" name="payment_for[]" id="sim_card_internet" value="SIM Card with Internet">
                    <label for="sim_card_internet" class="ps-2">SIM Card with Internet</label>
                </div>
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="checkbox" name="payment_for[]" id="physician_consultation" value="Physician Consultation">
                    <label for="physician_consultation" class="ps-2">Physician Consultation</label>
                </div>
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="checkbox" name="payment_for[]" id="hospital_stay" value="Hospital Stay">
                    <label for="hospital_stay" class="ps-2">Hospital Stay</label>
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row justify-content-between pt-2 gap-2">
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="checkbox" name="payment_for[]" id="wellness_treatment" value="Wellness Treatment">
                    <label for="wellness_treatment" class="ps-2">Wellness Treatment</label>
                </div>
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="checkbox" name="payment_for[]" id="pharmacy_prescription" value="Pharmacy Prescription">
                    <label for="pharmacy_prescription" class="ps-2">Pharmacy Prescription</label>
                </div>
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="checkbox" name="payment_for[]" id="safari" value="Safari">
                    <label for="safari" class="ps-2">Safari</label>
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row justify-content-between pt-2 gap-2">
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="checkbox" name="payment_for[]" id="other" value="Other">
                    <label for="other" class="ps-2">Other</label>
                </div>
            </div>
        </div>

        <!-- Payment Status -->
        <div class="pt-2">
            <h6 class="text-center p-2" style="background: #00007c; color: #fff;">Payment Status</h6>
            <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="radio" name="payment_status" id="advance_payment" value="Advance Payment">
                    <label for="advance_payment" class="ps-2">Advance Payment</label>
                </div>
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="radio" name="payment_status" id="partial_payment" value="Partial Payment">
                    <label for="partial_payment" class="ps-2">Partial Payment</label>
                </div>
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="radio" name="payment_status" id="final_payment" value="Final Payment">
                    <label for="final_payment" class="ps-2">Final Payment</label>
                </div>
            </div>
        </div>

        <!-- Mode of Payment -->
        <div class="pt-2">
            <h6 class="text-center p-2" style="background: #00007c; color: #fff;">Mode of Payment</h6>
            <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="radio" name="mode_of_payment" id="cash_payment" value="Cash">
                    <label for="cash_payment" class="ps-2">Cash</label>
                </div>
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="radio" name="mode_of_payment" id="atm_deposit" value="Atm Deposit">
                    <label for="atm_deposit" class="ps-2">ATM Deposit</label>
                </div>
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="radio" name="mode_of_payment" id="bank_transfer" value="Bank Transfer">
                    <label for="bank_transfer" class="ps-2">Bank Transfer</label>
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row justify-content-between pt-2 gap-2">
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="radio" name="mode_of_payment" id="cheque_payment" value="Cheque">
                    <label for="cheque_payment" class="ps-2">Cheque</label>
                </div>
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="radio" name="mode_of_payment" id="pos_payment" value="Pos">
                    <label for="pos_payment" class="ps-2">POS</label>
                </div>
                <div class="pt-2 ps-4 form-control">
                    <input class="form-check-input success" type="radio" name="mode_of_payment" id="link_payment" value="Link">
                    <label for="link_payment" class="ps-2">Link</label>
                </div>
            </div>
        </div>

        <!-- Cheque Details -->
        <div id="chequeDetailsSection" class="pt-3" style="display: none;">
            <h6 class="text-center p-2" style="background: #00007c; color: #fff;">Cheque Details</h6>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Cheque No</th>
                            <th>Cheque Date</th>
                            <th>Amount</th>
                            <th>Bank</th>
                        </tr>
                    </thead>
                    <tbody id="chequeDetailsBody">
                        <tr>
                            <td class="p-2"><input type="text" name="cheque_no[]" class="form-control form-control-sm"></td>
                            <td class="p-2"><input type="date" name="cheque_date[]" class="form-control form-control-sm"></td>
                            <td class="p-2"><input type="number" name="amount[]" class="form-control form-control-sm" value="0.00" min="0" step="0.01"></td>
                            <td class="p-2"><input type="text" name="bank[]" class="form-control form-control-sm"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row pb-3">
                <div class="col-12 col-md-2 pt-2">
                    <button type="button" id="addChequeRow" class="btn btn-sm btn-info w-100"><i class="fa-solid fa-circle-plus me-2"></i> Add Row</button>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center pt-5">
            <button type="submit" class="btn btn-primary btn-icon-text mx-2">
                <i class="mdi mdi-content-save btn-icon-prepend"></i> Save
            </button>
            <a href="{{ route('dashboard') }}" class="btn btn-icon-text" style="background: #eeeeee;">
                <i class="mdi mdi-cancel btn-icon-prepend"></i> Cancel
            </a>
        </div>
    </form>
</div>

@endsection


@section('scripts')
<script src="{{ asset('js/receiptvoucher.js') }}"></script>

<script>
    // Show/Hide Cheque Details based on payment mode selection
    document.querySelectorAll('input[name="mode_of_payment"]').forEach((radio) => {
        radio.addEventListener('change', function () {
            const chequeDetailsSection = document.getElementById('chequeDetailsSection');
            if (this.id === 'cheque_payment') {
                chequeDetailsSection.style.display = 'block';
            } else {
                chequeDetailsSection.style.display = 'none';
            }
        });
    });

    // Add new row to the Cheque Details table
    document.getElementById('addChequeRow').addEventListener('click', function () {
        const tbody = document.getElementById('chequeDetailsBody');
        const newRow = document.createElement('tr');

        newRow.innerHTML = `
            <td class="p-2"><input type="text" name="cheque_no[]" class="form-control"></td>
            <td class="p-2"><input type="date" name="cheque_date[]" class="form-control"></td>
            <td class="p-2"><input type="number" name="amount[]" class="form-control" value="0.00" min="0" step="0.01"></td>
            <td class="p-2"><input type="text" name="bank[]" class="form-control"></td>
        `;
        tbody.appendChild(newRow);
    });
</script>
@endsection
