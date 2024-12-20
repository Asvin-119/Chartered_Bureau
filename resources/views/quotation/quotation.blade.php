@extends('dashboard.layout')

@section('title','Ticket Reservation and Booking Details')

@section('content')

<div class="container-fluid pt-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card text-center">
                <div class="card-header">
                    <div class="row justify-content-between">
                        <div class="col-md-6 d-flex align-items-start">
                            <table class="table">
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-start">
                                            <img src="http://localhost/My_Project/Chartered_Bureau/public/dist/images/logos/logo.ico" style="height: 250px; width: auto;" alt="Company Logo">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="quote_id" id="quote_id" class="form-control select2" style="width: 100%;">
                                            <option value="">Select Quote ID</option>
                                            @foreach($quotes as $quote)
                                                <option value="{{ $quote->id }}"
                                                    data-quote-id="{{ $quote->quote_id }}"
                                                    data-detail="{{ $quote->details }}"
                                                    data-qty="{{ $quote->quantity }}"
                                                    data-amount_lkr="{{ $quote->amount_lkr }}"
                                                    data-amount_do="{{ $quote->amount_usd }}"
                                                    data-airline_details="{{ $quote->airline_details }}"
                                                    data-booking_summary="{{ $quote->booking_summary }}"
                                                    data-hotel_type="{{ optional($quote->hotelType)->hotel_type }}"
                                                    data-hotellocation="{{ optional($quote->hotelLocation)->hotel_location }} - {{ optional($quote->hotelLocation)->hotel_name }}"
                                                    data-hlqty="{{ $quote->hlquantity }}"
                                                    data-hlamount_lkr="{{ $quote->hlamount_rs }}"
                                                    data-hlamount_do="{{ $quote->hlamount_usd }}"
                                                    data-food_type="{{ optional($quote->foodType)->food_type }}"
                                                    data-meals="{{ optional($quote->meals)->meals_name }}"
                                                    data-mealamount_lkr="{{ $quote->mealamount_rs }}"
                                                    data-mealamount_do="{{ $quote->mealamount_usd }}"
                                                    data-transport_type="{{ optional($quote->tourLocationDetail)->tour_location }} &nbsp; - &nbsp; {{ optional($quote->tourLocationDetail)->tour_places_name }} "
                                                    data-transport_amount_lkr="{{ $quote->touramount_rs }}"
                                                    data-transport_amount_do="{{ $quote->touramount_usd }}"
                                                    data-transport_details="{{ optional($quote->service)->service_name }}"
                                                    data-transport_details_lkr="{{ $quote->serviceamount_lkr }}"
                                                    data-transport_details_do="{{ $quote->serviceamount_usd }}"
                                                > {{ $quote->quote->quote_id }}</option>  <!-- Use optional() for quote -->
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="table-responsive" style="border-radius: 8px; overflow: hidden;">
                                <table class="table table-bordered" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th colspan="2" class="text-white bg-black">Client Details</th>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;">Date</td>
                                            <td style="width: 70%;">
                                                <input type="date" name="date" value="{{ date('Y-m-d') }}" class="form-control">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-start" style="width: 30%;">Client ID & Name</td>
                                            <td style="width: 70%;">
                                                <select name="custom_id" id="custom_id" class="form-control select2" style="width: 100%;">
                                                    <option value="">Select Client</option>
                                                    @foreach($clients as $client)
                                                        <option value="{{ $client->id }}"
                                                            data-custom-id="{{ $client->custom_id }}"
                                                            data-email="{{ $client->email }}"
                                                            data-phone="{{ $client->mobile_phone }}"
                                                            data-consultant="{{ $client->tour_consultant }}"
                                                            data-source="{{ $client->source }}"
                                                            >{{ $client->custom_id }} &nbsp; &nbsp; -- &nbsp; &nbsp; {{ $client->first_name }}&nbsp; &nbsp;{{ $client->last_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody class="text-start">
                                        <tr>
                                            <td style="width: 30%;">Contact Email</td>
                                            <td style="width: 70%;">
                                                <input type="text" name="contact_email" id="contact_email" class="form-control" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;">Contact Number</td>
                                            <td style="width: 70%;">
                                                <input type="text" name="contact_number" id="contact_number" class="form-control" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;">Tour Consultant</td>
                                            <td style="width: 70%;">
                                                <input type="text" name="tour_consultant" id="tour_consultant" class="form-control" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;">Source / Agent</td>
                                            <td style="width: 70%;">
                                                <input type="text" name="source_agent" id="source_agent" class="form-control" readonly>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" style="width: 100%;">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-white bg-black">Description</th>
                                <th class="text-white bg-black">Qty</th>
                                <th class="text-white bg-black">Amount ( Rs. )</th>
                                <th class="text-white bg-black">Amount ( $ )</th>
                            </tr>
                        </thead>
                        <tbody class="text-start">
                            <tr>
                                <td colspan="2" style="background: rgb(214, 214, 214); font-weight: bold;" class="text-center">Ticket Reservation and Booking Details</td>
                                <td style="background: rgb(214, 214, 214);"></td>
                                <td style="background: rgb(214, 214, 214);"></td>
                                <td style="background: rgb(214, 214, 214);"></td>
                            </tr>
                            <tr>
                                <td style="width: 20%">Ticket</td>
                                <td style="width: 40%">
                                    <input type="text" name="detail" id="detail" class="form-control" readonly>
                                </td>
                                <td style="width: 10%">
                                    <input type="text" name="qty" id="qty" class="form-control" readonly>
                                </td>
                                <td style="width: 15%">
                                    <input type="text" name="amount_lkr" id="amount_lkr" class="form-control" readonly>
                                </td>
                                <td style="width: 15%">
                                    <input type="text" name="amount_do" id="amount_do" class="form-control" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 20%">Airline Details</td>
                                <td style="width: 40%">
                                    <input type="text" name="airline_details" id="airline_details" class="form-control" readonly>
                                </td>
                                <td style="width: 10%; text-align: center;">
                                    <span> ----- </span>
                                </td>
                                <td style="width: 15%; text-align: center;">
                                    <span> ----- </span>
                                </td>
                                <td style="width: 15%; text-align: center;">
                                    <span> ----- </span>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 20%">Booking Summary</td>
                                <td style="width: 40%">
                                    <input type="text" name="booking_summary" id="booking_summary" class="form-control" readonly>
                                </td>
                                <td style="width: 10%; text-align: center;">
                                    <span> ----- </span>
                                </td>
                                <td style="width: 15%; text-align: center;">
                                    <span> ----- </span>
                                </td>
                                <td style="width: 15%; text-align: center;">
                                    <span> ----- </span>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2" style="background: rgb(214, 214, 214); font-weight: bold;" class="text-center">Hotel Reservation and Booking Details</td>
                                <td style="background: rgb(214, 214, 214);"></td>
                                <td style="background: rgb(214, 214, 214);"></td>
                                <td style="background: rgb(214, 214, 214);"></td>
                            </tr>
                            <tr class="text-start">
                                <td style="width: 20%;">Type of Hotel</td>
                                <td style="width: 40%">
                                    <input type="text" name="hotel_type" id="hotel_type" class="form-control" readonly>
                                </td>
                                <td style="width: 10%; text-align: center;">
                                    <span> ----- </span>
                                </td>
                                <td style="width: 15%; text-align: center;">
                                    <span> ----- </span>
                                </td>
                                <td style="width: 15%; text-align: center;">
                                    <span> ----- </span>
                                </td>
                            </tr>
                            <tr class="text-start">
                                <td style="">Hotel Location 1</td>
                                <td style="width: 40%">
                                    <input type="text" name="hotellocation" id="hotellocation" class="form-control" readonly>
                                </td>
                                <td style="width: 10%">
                                    <input type="text" name="hlqty" id="hlqty" class="form-control" readonly>
                                </td>
                                <td style="width: 15%">
                                    <input type="text" name="hlamount_lkr" id="hlamount_lkr" class="form-control" readonly>
                                </td>
                                <td style="width: 15%">
                                    <input type="text" name="hlamount_do" id="hlamount_do" class="form-control" readonly>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2" style="background: rgb(214, 214, 214); font-weight: bold;" class="text-center">Food & Beverage</td>
                                <td style="background: rgb(214, 214, 214);"></td>
                                <td style="background: rgb(214, 214, 214);"></td>
                                <td style="background: rgb(214, 214, 214);"></td>
                            </tr>
                            <tr class="text-start">
                                <td style="width: 20%;">Type of Food</td>
                                <td style="width: 40%">
                                    <input type="text" name="food_type" id="food_type" class="form-control" readonly>
                                </td>
                                <td style="width: 10%; text-align: center;">
                                    <span> ----- </span>
                                </td>
                                <td style="width: 15%">
                                    <input type="text" name="mealamount_lkr" id="mealamount_lkr" class="form-control" readonly>
                                </td>
                                <td style="width: 15%">
                                    <input type="text" name="mealamount_do" id="mealamount_do" class="form-control" readonly>
                                </td>
                            </tr>
                            <tr class="text-start">
                                <td style="">Meals</td>
                                <td style="width: 40%">
                                    <input type="text" name="meals" id="meals" class="form-control" readonly>
                                </td>
                                <td style="width: 10%; text-align: center;">
                                    <span> ----- </span>
                                </td>
                                <td style="width: 15%; text-align: center;">
                                    <span> ----- </span>
                                </td>
                                <td style="width: 15%; text-align: center;">
                                    <span> ----- </span>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2" style="background: rgb(214, 214, 214); font-weight: bold;" class="text-center">Tour Location and Transport</td>
                                <td style="background: rgb(214, 214, 214);"></td>
                                <td style="background: rgb(214, 214, 214);"></td>
                                <td style="background: rgb(214, 214, 214);"></td>
                            </tr>
                            <tr class="text-start">
                                <td style="width: 20%;">Tour Location 1</td>
                                <td style="width: 40%">
                                    <input type="text" name="tour_location" id="tour_location" class="form-control" readonly>
                                </td>
                                <td style="width: 10%; text-align: center;">
                                    <span> ----- </span>
                                </td>
                                <td style="width: 15%">
                                    <input type="text" name="tramount_lkr" id="tramount_lkr" class="form-control" readonly>
                                </td>
                                <td style="width: 15%">
                                    <input type="text" name="tramount_do" id="tramount_do" class="form-control" readonly>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2" style="background: rgb(214, 214, 214); font-weight: bold;" class="text-center">Other Services</td>
                                <td style="background: rgb(214, 214, 214);"></td>
                                <td style="background: rgb(214, 214, 214);"></td>
                                <td style="background: rgb(214, 214, 214);"></td>
                            </tr>
                            <tr class="text-start">
                                <td style="width: 20%;">Other Service 1</td>
                                <td style="width: 40%">
                                    <input type="text" name="otherservice" id="otherservice" class="form-control" readonly>
                                </td>
                                <td style="width: 10%; text-align: center;">
                                    <span> ----- </span>
                                </td>
                                <td style="width: 15%">
                                    <input type="text" name="osamount_lkr" id="osamount_lkr" class="form-control" readonly>
                                </td>
                                <td style="width: 15%">
                                    <input type="text" name="osamount_do" id="osamount_do" class="form-control" readonly>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize Select2 for the quote_id and custom_id select elements
        $('#quote_id').select2({
            placeholder: 'Select Quote ID',
            allowClear: true
        });

        $('#custom_id').select2({
            placeholder: 'Select Client',
            allowClear: true
        });

        // Event listener for custom_id select change (using select2)
        $('#custom_id').on('change', function() {
            const selectedOption = $(this).find(':selected');
            document.getElementById('contact_email').value = selectedOption.data('email');
            document.getElementById('contact_number').value = selectedOption.data('phone');
            document.getElementById('tour_consultant').value = selectedOption.data('consultant');
            document.getElementById('source_agent').value = selectedOption.data('source');
        });

        // Event listener for quote_id select change (using select2)
        $('#quote_id').on('change', function() {
            const selectedQuoteId = $(this).val();
            const selectedOption = $(this).find('option:selected');

            if (selectedOption.length) {
                // Fill the input fields with the selected quote data
                document.getElementById('detail').value = selectedOption.data('detail');
                document.getElementById('qty').value = selectedOption.data('qty');
                document.getElementById('amount_lkr').value = selectedOption.data('amount_lkr');
                document.getElementById('amount_do').value = selectedOption.data('amount_do');
                document.getElementById('airline_details').value = selectedOption.data('airline_details');
                document.getElementById('booking_summary').value = selectedOption.data('booking_summary');
                document.getElementById('hotel_type').value = selectedOption.data('hotel_type');
                document.getElementById('hotellocation').value = selectedOption.data('hotellocation');
                document.getElementById('hlqty').value = selectedOption.data('hlqty');
                document.getElementById('hlamount_lkr').value = selectedOption.data('hlamount_lkr');
                document.getElementById('hlamount_do').value = selectedOption.data('hlamount_do');
                document.getElementById('food_type').value = selectedOption.data('food_type');
                document.getElementById('meals').value = selectedOption.data('meals');
                document.getElementById('mealamount_lkr').value = selectedOption.data('mealamount_lkr');
                document.getElementById('mealamount_do').value = selectedOption.data('mealamount_do');
                document.getElementById('tour_location').value = selectedOption.data('transport_type');
                document.getElementById('tramount_lkr').value = selectedOption.data('transport_amount_lkr');
                document.getElementById('tramount_do').value = selectedOption.data('transport_amount_do');
                document.getElementById('otherservice').value = selectedOption.data('transport_details');
                document.getElementById('osamount_lkr').value = selectedOption.data('transport_details_lkr');
                document.getElementById('osamount_do').value = selectedOption.data('transport_details_do');

            } else {
                // Clear the inputs if no valid selection is made
                document.getElementById('detail').value = '';
                document.getElementById('qty').value = '';
                document.getElementById('amount_lkr').value = '';
                document.getElementById('amount_do').value = '';
                document.getElementById('airline_details').value = '';
                document.getElementById('booking_summary').value = '';
                document.getElementById('hotel_type').value = '';
                document.getElementById('hotellocation').value = '';
                document.getElementById('hlqty').value = '';
                document.getElementById('hlamount_lkr').value = '';
                document.getElementById('hlamount_do').value = '';
                document.getElementById('food_type').value = '';
                document.getElementById('meals').value = '';
                document.getElementById('mealamount_lkr').value = '';
                document.getElementById('mealamount_do').value = '';
                document.getElementById('transport_type').value = '';
                document.getElementById('tramount_lkr').value = '';
                document.getElementById('tramount_do').value = '';
                document.getElementById('transport_details').value = '';
                document.getElementById('osamount_lkr').value = '';
                document.getElementById('osamount_do').value = '';
            }
        });
    });
</script>
@endsection
