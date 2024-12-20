<?php

use App\Http\Controllers\AirlineDetailsController;
use App\Http\Controllers\ClientController;
// use App\Http\Controllers\ExController;
use App\Http\Controllers\FoodandBeverageController;
// use App\Http\Controllers\FoodController;
use App\Http\Controllers\FoodTypeController;
use App\Http\Controllers\HotelLocationController;
use App\Http\Controllers\HotelReservationController;
use App\Http\Controllers\OtherServiceController;
use App\Http\Controllers\OverviewController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\QuoteIdController;
use App\Http\Controllers\ReceiptVoucherController;
use App\Http\Controllers\VoucherCodeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TempController;
// use App\Http\Controllers\TempControllercopy;
use App\Http\Controllers\TicketReservationController;
use App\Http\Controllers\TourLocationController;
use App\Http\Controllers\TourLocationTransportController;
// use App\Models\Client;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::prefix('clients')->name('clients.')->group(function () {
    Route::get('/', [ClientController::class, 'index'])->name('index'); // List clients
    Route::get('/create', [ClientController::class, 'create'])->name('create'); // Create client form
    Route::post('/', [ClientController::class, 'store'])->name('store'); // Store new client
    Route::get('/{id}', [ClientController::class, 'show'])->name('overview.show'); // Show client overview

    Route::get('/{id}/edit', [ClientController::class, 'edit'])->name('edit'); // Edit client
    Route::put('/{id}', [ClientController::class, 'update'])->name('update'); // Update client
    Route::delete('/{id}', [ClientController::class, 'destroy'])->name('destroy'); // Delete client

    Route::get('/clients/search', [ClientController::class, 'search'])->name('clients.search');
});

Route::post('/generate-quote-id', [QuoteIdController::class, 'store'])->name('generate.quote.id');

Route::prefix('quotation')->name('quotation.')->group(function () {
    Route::get('/', [QuotationController::class, 'index'])->name('index'); // List quotation
    Route::get('/form', [QuotationController::class, 'index_form'])->name('index_form'); // List quotation_form
    Route::get('/add/form', [QuotationController::class, 'index_add_form'])->name('index_add_form'); // List add_quotation_form
});

Route::prefix('ticket')->name('ticket.')->group(function (){
    Route::get('/tickets/extra', [QuoteIdController::class, 'ticket'])->name('tickets.extra');
    Route::post('/ticket-reservations', [TicketReservationController::class, 'store'])->name('ticket.reservations.store');
});

Route::prefix('hotel')->name('hotel.')->group(function (){
    Route::get('/hotels/extra', [QuoteIdController::class, 'hotel'])->name('hotels.extra');
    Route::post('/hotel/locations', [HotelLocationController::class, 'store'])->name('hotel_locations.store');
    Route::post('/hotel-reservations', [HotelReservationController::class, 'store'])->name('hotel.reservations.store');
});

Route::prefix('food')->name('food.')->group(function (){
    Route::get('/food/beverage', [QuoteIdController::class, 'food'])->name('food.beverage');
    Route::post('/food-beverages', [FoodandBeverageController::class, 'store'])->name('food.beverages.store');
    Route::post('/food/beverage', [FoodTypeController::class, 'store'])->name('food_type.store');
});

Route::prefix('tour')->name('tour.')->group(function (){
    Route::get('/tour/locations', [QuoteIdController::class, 'tour'])->name('tour.locations');
    Route::post('/tour-locations', [TourLocationController::class, 'store'])->name('tour.locations.store');
    Route::post('/tour/locations', [TourLocationTransportController::class, 'store'])->name('tour.locations.transport.store');
});

Route::prefix('service')->name('service.')->group(function (){
    Route::get('/other/service', [QuoteIdController::class, 'service'])->name('other.service');
    Route::post('/other-service', [ServiceController::class, 'store'])->name('service.store');
    Route::post('/other/service', [OtherServiceController::class, 'store'])->name('other.service.store');
});

Route::get('/overview/{id}', [OverviewController::class, 'showAllDetails'])->name('overview.show');

// Route::post('/airline/details', [AirlineDetailsController::class, 'store'])->name('airline_details.store');

Route::get('/view', function () {
    return view('_temp/view');
});

// Route::get('/temp1', [ExController::class, 'index'])->name('temp1.index');
// Route::get('/get-descriptions', [ExController::class, 'getDescriptions']);

// Route::get('temp1/create', [ReceiptVoucherController::class, 'create'])->name('temp1.form');
// // Route::post('/generate-rv-code', [ReceiptVoucherController::class, 'store'])->name('generate.rv.code');
// // Route::get('temp1/form', [ReceiptVoucherController::class, 'index_form'])->name('index_form');
Route::post('temp1/store', [ReceiptVoucherController::class, 'store'])->name('temp1.store');

Route::post('/generate-rv-code', [VoucherCodeController::class, 'store'])->name('generate.rv.code');
Route::get('temp1/form', [VoucherCodeController::class, 'index_form'])->name('index1_form');
Route::get('/temp1/create', [VoucherCodeController::class, 'create'])->name('temp1.create');
Route::get('/generate-pdf/{rv_code}', [ReceiptVoucherController::class, 'generatervPdf'])->name('generaterv.pdf');


Route::get('temp/create', [TempController::class, 'create'])->name('temp.create');
Route::post('temp/store', [TempController::class, 'store'])->name('temp.store');
Route::get('/generate-pdf/{quote_id}', [TempController::class, 'generatePDF'])->name('generate.pdf');


Route::get('/temp5', function () {
    return view('_temp/reciptvoucher');
});
