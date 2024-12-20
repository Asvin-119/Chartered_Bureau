@extends('dashboard.layout')

@section('content')


<div class="col-md-12">
    <div class="row pb-2">
        {{-- <div class="col-md-12 p-2">
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addAirlineDetailsModal" style="width: 100%;">
                <i class="fa-solid fa-circle-plus me-2"></i> Add Airline Details
            </button>
        </div> --}}

        <div class="col-md-3 p-2">
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addHotelLocationModal" style="width: 100%;">
                <i class="fa-solid fa-circle-plus me-2"></i> Add Hotel Location
            </button>
        </div>

        <div class="col-md-3 p-2">
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addTypeofFoodModal" style="width: 100%;">
                <i class="fa-solid fa-circle-plus me-2"></i> Add Type of Food
            </button>
        </div>

        <div class="col-md-3 p-2">
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addTourLocationModal" style="width: 100%;">
                <i class="fa-solid fa-circle-plus me-2"></i> Add Tour Location
            </button>
        </div>

        <div class="col-md-3 p-2">
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addOtherServiceModal" style="width: 100%;">
                <i class="fa-solid fa-circle-plus me-2"></i> Add Service
            </button>
        </div>
    </div>

    @include('popup.hotel_location')
    {{-- @include('popup.airline_details') --}}
    @include('popup.food_type')
    @include('popup.tour_location')
    @include('popup.service')
</div>

<div class="container-fluid">
    <form id="newServiceForm" action="{{ route('temp.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-center">
                    <select name="quote_id" id="quote_id" class="form-control ticket_type select2" style="width: 100%;">
                        <option value="{{ $lastQuote->id }}">{{ $lastQuote->quote_id }}</option>
                    </select>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th style="width: 16%;">Description</th>
                            <th style="width: 30%;">Description</th>
                            <th style="width: 9%;">Qty</th>
                            <th style="width: 13%;">Rate</th>
                            <th style="width: 14%;">Amount (Rs.)</th>
                            <th style="width: 13%;">Amount ($)</th>
                            <th style="width: 5%;"></th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                    </tbody>
                </table>

                <div class="row pb-3">
                    <div class="col-md-6 pt-2">
                        <button type="button" class="btn btn-secondary" id="add-row" data-bs-toggle="tooltip">
                            <i class="fa-solid fa-circle-plus me-2"></i> Add New Row
                        </button>
                    </div>
                </div>

                <hr>

                <div class="row pb-3">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <div class="row">
                            <!-- Airline Details -->
                            <div class="col-md-4 pt-4">
                                <label for="airline_details"><strong>Airline Details</strong></label>
                            </div>
                            <div class="col-md-8 pb-2">
                                <textarea id="airline_details" name="airline_details" cols="3" rows="3" class="form-control" style="resize: none"></textarea>
                            </div>
                            <!-- Booking Summary -->
                            <div class="col-md-4 pt-4">
                                <label for="booking_summary"><strong>Booking Summary</strong></label>
                            </div>
                            <div class="col-md-8">
                                <textarea id="booking_summary" name="booking_summary" cols="3" rows="3" class="form-control" style="resize: none"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6">
                        <div class="row">
                            <!-- Total -->
                            <div class="col-md-4 pt-2">
                                <label for="total"><strong>Total</strong></label>
                            </div>
                            <div class="col-md-4 pb-3">
                                <input type="text" class="form-control" id="lkrtotal" name="lkrtotal" aria-label="Total" readonly>
                            </div>
                            <div class="col-md-4 pb-3">
                                <input type="text" class="form-control" id="usdtotal" name="usdtotal" aria-label="Total" readonly>
                            </div>
                            <!-- Tax -->
                            <div class="col-md-4 pt-2">
                                <label for="tax"><strong>Tax</strong></label>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="tax" name="tax" aria-label="Tax">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            <!-- Grand Total -->
                            <div class="col-md-4 pt-2">
                                <label for="grand_total"><strong>Grand Total</strong></label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="lkrgrand_total" name="lkrgrand_total" aria-label="Grand Total" readonly>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="usdgrand_total" name="usdgrand_total" aria-label="Grand Total" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary btn-icon-text mx-2">
                        <i class="mdi mdi-content-save btn-icon-prepend"></i> Save and Generate PDF
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-icon-text" style="background: #eeeeee;">
                        <i class="mdi mdi-cancel btn-icon-prepend"></i> Cancel
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
    let usdToLkrRate = 400; // Default exchange rate
    let locationIndex = 1;

    // Fetch exchange rate from the API
    function fetchExchangeRate() {
        fetch('https://api.exchangerate-api.com/v4/latest/USD')
            .then(response => response.json())
            .then(data => {
                usdToLkrRate = data.rates.LKR; // Update exchange rate
                calculateAmounts(); // Recalculate amounts after exchange rate is updated
        })
            .catch(error => console.error('Error fetching exchange rate:', error));
    }

    // Function to calculate amounts based on quantity and rate
    function calculateAmounts() {
        const rows = document.querySelectorAll("#table-body tr");
        let totalLkr = 0; // Initialize total in LKR
        let totalUsd = 0; // Initialize total in USD

        rows.forEach(row => {
            const qty = parseFloat(row.querySelector('input[name="qty[]"]').value || 0);
            const rate = parseFloat(row.querySelector('input[name="rate[]"]').value || 0);

            const amountLkr = qty * rate;
            const amountUsd = amountLkr / usdToLkrRate;

            row.querySelector('input[name="amount_rs[]"]').value = amountLkr.toFixed(2);
            row.querySelector('input[name="amount_usd[]"]').value = amountUsd.toFixed(2);

            totalLkr += amountLkr; // Add to total in LKR
            totalUsd += amountUsd; // Add to total in USD
        });

        // Update total in LKR
        document.getElementById("lkrtotal").value = totalLkr.toFixed(2);

        // Update total in USD
        document.getElementById("usdtotal").value = totalUsd.toFixed(2);

        // After calculating the amounts, recalculate grand total including tax
        calculateGrandTotal();
    }

    // Function to calculate grand total including tax
    function calculateGrandTotal() {
        const totalLkr = parseFloat(document.getElementById("lkrtotal").value || 0);
        const taxRate = parseFloat(document.getElementById("tax").value || 0);  // User input for tax

        // Calculate tax amount based on total LKR
        const taxAmount = (totalLkr * taxRate) / 100;

        // Calculate grand total in LKR with tax
        const grandTotalLkr = totalLkr + taxAmount;

        // Convert grand total from LKR to USD
        const grandTotalUsd = grandTotalLkr / usdToLkrRate;

        // Update the grand total values in the respective fields
        document.getElementById("lkrgrand_total").value = grandTotalLkr.toFixed(2);
        document.getElementById("usdgrand_total").value = grandTotalUsd.toFixed(2);
    }

    // Example: Trigger the calculate function when the user changes quantity, rate, or tax input
    document.querySelectorAll('input[name="qty[]"], input[name="rate[]"], input[name="tax"]').forEach(input => {
        input.addEventListener('input', function() {
            calculateAmounts();  // Recalculate totals when the user changes any input
        });
    });

    // Add new row when button is clicked
    document.addEventListener("DOMContentLoaded", function() {
        // Fetch the initial exchange rate
        fetchExchangeRate();

        // Add event listener to recalculate amounts on any change in quantity or rate
        document.getElementById("table-body").addEventListener("input", function(e) {
            if (e.target && (e.target.name === "qty[]" || e.target.name === "rate[]")) {
                calculateAmounts();
            }
        });

        // Add new row to the table
        document.getElementById("add-row").addEventListener("click", function(e) {
            e.preventDefault();

            const tableBody = document.getElementById("table-body");
            const newRow = document.createElement("tr");
            newRow.classList.add("text-center");

            newRow.innerHTML = `
                <td class="p-2">
                    <select name="details[]" class="form-control select2" style="width: 100%;" onchange="updateDescription(this)">
                        <option value="">Select Details</option>
                        <option value="Ticket">Ticket</option>
                        <option value="Hotel Type">Hotel Type</option>
                        <option value="Hotel Location">Hotel Location</option>
                        <option value="Food Type">Food Type</option>
                        <option value="Meals">Meals</option>
                        <option value="Tour Location">Tour Location</option>
                        <option value="Other Services">Other Services</option>
                    </select>
                </td>
                <td class="p-2" name="description[]"></td>
                <td class="p-2"><input type="number" name="qty[]" class="form-control" placeholder="Qty" value="1" min="1"></td>
                <td class="p-2"><input type="number" name="rate[]" class="form-control" placeholder="Rate" value="0.00" min="0" step="0.01"></td>
                <td class="p-2"><input type="number" name="amount_rs[]" class="form-control" placeholder="Amount (Rs.)" value="0.00" min="0" step="0.01" readonly></td>
                <td class="p-2"><input type="number" name="amount_usd[]" class="form-control" placeholder="Amount ($)" value="0.00" min="0" step="0.01" readonly></td>
                <td class="p-2"><button type="button" class="btn btn-danger btn-sm delete-row"><i class="fa-solid fa-trash"></i></button></td>
            `;

            tableBody.appendChild(newRow);

            // Initialize Select2 for the new row's select element
            $(newRow).find('.select2').select2();

            // Add event listener to the delete button
            newRow.querySelector('.delete-row').addEventListener('click', function() {
                newRow.remove();
                calculateAmounts(); // Recalculate amounts after row is deleted
            });
        });

        // Delete row
        document.getElementById("table-body").addEventListener("click", function(e) {
            if (e.target && e.target.classList.contains("delete-row")) {
                e.target.closest("tr").remove();
                calculateAmounts(); // Recalculate amounts after row is deleted
            }
        });
    });

    // Function to update description field based on selected option
    function updateDescription(selectElement) {
    // Get the selected value
    const selectedValue = selectElement.value;

    // Locate the corresponding `<td>` element for description
    const row = selectElement.closest('tr');
    const descriptionTd = row.querySelector('td[name="description[]"]');
    const qtyInput = row.querySelector('input[name="qty[]"]');
    const rateInput = row.querySelector('input[name="rate[]"]');
    const amountRsInput = row.querySelector('input[name="amount_rs[]"]');
    const amountUsdInput = row.querySelector('input[name="amount_usd[]"]');

    if (!descriptionTd) return; // Exit if descriptionTd not found

    // Update the content of descriptionTd dynamically
    if (selectedValue === "Ticket") {
        descriptionTd.innerHTML = `
            <select name="ticket_type[]" class="form-control select2" style="width: 100%;">
                <option value="">Select Ticket Type</option>
                @foreach($ticketTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->ticket_type }}</option>
                @endforeach
            </select>
        `;
    } else if (selectedValue === "Hotel Type") {
        descriptionTd.innerHTML = `
            <select name="hotel_type[]" class="form-control select2" style="width: 100%;">
                <option value="">Select Hotel Type</option>
                @foreach($hotelTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->hotel_type }}</option>
                @endforeach
            </select>
        `;
        if (qtyInput) {
            qtyInput.value = true; // Default Quantity
            qtyInput.readOnly = true;
        }
        if (rateInput) {
            rateInput.value = true; // Default Rate
            rateInput.readOnly = true;
        }
        if (amountRsInput) {
            amountRsInput.value = true; // Default Amount Rs
            amountRsInput.readOnly = true;
        }
        if (amountUsdInput) {
            amountUsdInput.value = true; // Default Amount USD
            amountUsdInput.readOnly = true;
        }
    } else if (selectedValue === "Hotel Location") {
        descriptionTd.innerHTML = `
            <select name="hotel_location[]" class="form-control select2" style="width: 100%;">
                <option value="">Select Hotel Location</option>
                @foreach($hotelLocations as $location)
                    <option value="{{ $location->id }}">{{ $location->hotel_location }} - {{ $location->hotel_name }}</option>
                @endforeach
            </select>
        `;
    } else if (selectedValue === "Food Type") {
        descriptionTd.innerHTML = `
            <select name="food_type[]" class="form-control select2" style="width: 100%;">
                <option value="">Select Food Type</option>
                @foreach($foodTypes as $food)
                    <option value="{{ $food->id }}">{{ $food->food_type }}</option>
                @endforeach
            </select>
        `;
    } else if (selectedValue === "Meals") {
        descriptionTd.innerHTML = `
            <select name="meals[]" class="form-control select2" style="width: 100%;">
                <option value="">Select Meals</option>
                @foreach($meals as $meal)
                    <option value="{{ $meal->id }}">{{ $meal->meals_name }}</option>
                @endforeach
            </select>
        `;
        if (qtyInput) {
            qtyInput.value = true; // Default Quantity
            qtyInput.readOnly = true;
        }
        if (rateInput) {
            rateInput.value = true; // Default Rate
            rateInput.readOnly = true;
        }
        if (amountRsInput) {
            amountRsInput.value = true; // Default Amount Rs
            amountRsInput.readOnly = true;
        }
        if (amountUsdInput) {
            amountUsdInput.value = true; // Default Amount USD
            amountUsdInput.readOnly = true;
        }
    } else if (selectedValue === "Tour Location") {
        descriptionTd.innerHTML = `
            <select name="tour_location[]" class="form-control select2" style="width: 100%;">
                <option value="">Select Tour Location</option>
                @foreach($tourLocations as $tour)
                    <option value="{{ $tour->id }}">{{ $tour->tour_location }} - {{ $tour->tour_places_name }}</option>
                @endforeach
            </select>
        `;
    } else if (selectedValue === "Other Services") {
        descriptionTd.innerHTML = `
            <select name="other_services[]" class="form-control select2" style="width: 100%;">
                <option value="">Select Other Services</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}">{{ $service->service_name }}</option>
                @endforeach
            </select>
        `;
    }

    // Reinitialize Select2 for dynamically added select
    $(descriptionTd.querySelector('select')).select2();
}
</script>
@endsection
