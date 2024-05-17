<?php

use App\Http\Controllers\AirplaneController;
use App\Http\Controllers\AirportController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Models\Airplane;
use App\Models\City;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Guest pages
Route::get('/', function () {
    return view('welcome');
})->name('HomePage');

Route::get('/auth',
    [PageController::class, 'AuthPage'])->name('AuthPage');

Route::get('/reg',
    [PageController::class, 'RegPage'])->name('RegPage');

Route::get('/contact',
    [PageController::class, 'ContactPage'])->name('ContactPage');

//User pages

Route::get('/profile',
    [PageController::class, 'UserProfile'])->name('UserProfile');

Route::post('/profile/edit/save',
    [UserController::class, 'EditProfile'])->name('EditProfile');

Route::get('/tickets',
    [PageController::class, 'UserTicketsPage'])->name('UserTicketsPage');

Route::post('/tickets/no',
    [TicketController::class, 'update'])->name('noTicket');

//FlightsFind

Route::get('/flights/find/valid',
    [PageController::class, 'flightsFind'])->name('flightsFind');

Route::post('/flights/find',
    [FlightController::class, 'show'])->name('findFlights');

Route::get('/flights/detail/{flight}',
    [PageController::class, 'flightDetail'])->name('flightDetail');

Route::post('ticket/reg',
    [TicketController::class, 'create'])->name('ticketReg');

//Reg + Auth + Logout

Route::post('/reg/save',
    [UserController::class, 'Reg'])->name('Reg');

Route::post('/login',
    [UserController::class, 'Auth'])->name('Auth');

Route::get('/logout',
    [UserController::class, 'Logout'])->name('Logout');

//Get
Route::get('/cities/get',
    [CityController::class, 'index'])->name('getCities');

Route::get('/airplanes/get',
    [AirplaneController::class, 'index'])->name('getAirplanes');

Route::get('/airports/get',
    [AirportController::class, 'index'])->name('getAirports');

Route::get('/flights/get',
    [FlightController::class, 'index'])->name('getFlights');

Route::get('/tickets/get',
    [TicketController::class, 'index'])->name('getTickets');

//Middleware

Route::group(['middleware'=>['admin', 'auth'], 'prefix'=>'admin'], function () {
//Cities

    Route::get('/cities',
        [PageController::class, 'CityPage'])->name('CityPage');

    Route::get('/cities/add',
        [PageController::class, 'CityAddPage'])->name('CityAddPage');

    Route::post('/cities/add/save',
        [CityController::class, 'store'])->name('AddCity');

    Route::post('/city/delete/{city?}',
        [CityController::class, 'destroy'])->name('deleteCity');

    Route::get('/city/edit/{city?}',
        [PageController::class, 'editCityPage'])->name('editCityPage');

    Route::post('/city/edit/save',
        [CityController::class, 'update'])->name('editCity');

//Airplanes

    Route::get('/airplanes',
        [PageController::class, 'AirplanesPage'])->name('AirplanesPage');

    Route::get('/airplane/add',
        [PageController::class, 'AirplaneAddPage'])->name('AirplaneAddPage');

    Route::post('/airplane/add/save',
        [AirplaneController::class, 'store'])->name('AddAirplane');

    Route::post('/airplane/delete/{airplane?}',
        [AirplaneController::class, 'destroy'])->name('deleteAirplane');

    Route::get('/airplane/edit/{airplane?}',
        [PageController::class, 'editAirplanePage'])->name('editAirplanePage');

    Route::post('/airplane/edit/save',
        [AirplaneController::class, 'update'])->name('editAirplane');

//Airports

    Route::get('/airports',
        [PageController::class, 'AirportsPage'])->name('AirportsPage');

    Route::get('/airport/add',
        [PageController::class, 'AirportAddPage'])->name('AirportAddPage');

    Route::post('/airport/add/save',
        [AirportController::class, 'store'])->name('AddAirport');

    Route::post('/airport/delete/{airport?}',
        [AirportController::class, 'destroy'])->name('deleteAirport');

    Route::get('/airport/edit/{airport?}',
        [PageController::class, 'editAirportPage'])->name('editAirportPage');

    Route::post('/airport/edit/save',
        [AirportController::class, 'update'])->name('editAirport');

//Flights

    Route::get('/flights',
        [PageController::class, 'FlightsPage'])->name('FlightsPage');

    Route::get('/flight/add',
        [PageController::class, 'FlightsAddPage'])->name('FlightsAddPage');

    Route::post('/flight/add/save',
        [FlightController::class, 'store'])->name('AddFlight');

    Route::post('/flight/delete/{flight?}',
        [FlightController::class, 'destroy'])->name('deleteFlight');

    Route::get('/flight/edit/{flight?}',
        [PageController::class, 'FlightEditPage'])->name('FlightEditPage');

    Route::post('/flight/edit/save',
        [FlightController::class, 'update'])->name('editFLight');

//Tickets

    Route::get('/tickets',
        [PageController::class, 'TicketsPage'])->name('TicketsPage');
});
