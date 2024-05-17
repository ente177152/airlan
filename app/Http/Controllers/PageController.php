<?php

namespace App\Http\Controllers;

use App\Models\Airplane;
use App\Models\Airport;
use App\Models\City;
use App\Models\Flight;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function AuthPage() {
        return view('guest.auth');
    }

    public function RegPage() {
        return view('guest.reg');
    }

    public function ContactPage() {
        return view('guest.contact');
    }

    public function flightsFind(Request $request) {
        $flights = $request->session()->get('flights');
        return view('user.flightsFind',['flights'=>$flights]);
    }

    public function flightDetail(Flight $flight) {
        return view('user.flightDetail', ['flight'=>$flight->where('id', $flight->id)->with('airplane.seats')->first()]);
    }

    public function UserProfile() {
        return view('user.profile');
    }

    public function UserTicketsPage() {
        return view('user.tickets');
    }

    public function CityPage() {
        return view('admin.cities.index');
    }

    public function CityAddPage() {
        return view('admin.cities.add');
    }

    public function editCityPage(City $city) {
        return view('admin.cities.edit', ['city'=>$city]);
    }

    public function AirplanesPage() {
        return view('admin.airplanes.index');
    }

    public function AirplaneAddPage() {
        return view('admin.airplanes.add');
    }

    public function editAirplanePage(Airplane $airplane) {
        return view('admin.airplanes.edit', ['airplane'=>$airplane]);
    }

    public function AirportsPage() {
        return view('admin.airports.index');
    }

    public function AirportAddPage() {
        return view('admin.airports.add');
    }

    public function editAirportPage(Airport $airport) {
        return view('admin.airports.edit', ['airport'=>$airport]);
    }

    public function FlightsPage() {
        return view('admin.flights.index');
    }

    public function FlightsAddPage() {
        return view('admin.flights.add');
    }

    public function FlightEditPage(Flight $flight) {
        return view('admin.flights.edit', ['flight'=>$flight]);
    }

    public function TicketsPage() {
        return view('admin.tickets.index');
    }
}
