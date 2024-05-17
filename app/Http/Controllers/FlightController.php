<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Flight;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FlightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $flights = Flight
            ::with('city')
            ->with('city_to')
            ->with('airport')
            ->with('airport_to')
            ->with('airplane')
            ->get();

        $flights_welcome = Flight
            ::with('city')
            ->with('city_to')
            ->with('airplane')
            ->where('status', 'готов')
            ->get();


        return response()->json([
            'flights'=>$flights,
            'flights_welcome'=>$flights_welcome,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'from_city_id'=>['required'],
            'to_city_id'=>['required'],
            'date_from'=>['required'],
            'time_from'=>['required'],
            'date_to'=>['required'],
            'time_to'=>['required'],
            'timeWay'=>['required'],
            'percentPrice'=>['required', 'numeric', 'min:0'],
        ],[
            'from_city_id.required'=>'Поле обязательно для заполнения',
            'to_city_id.required'=>'Поле обязательно для заполнения',
            'date_from.required'=>'Поле обязательно для заполнения',
            'time_from.required'=>'Поле обязательно для заполнения',
            'date_to.required'=>'Поле обязательно для заполнения',
            'time_to.required'=>'Поле обязательно для заполнения',
            'timeWay.required'=>'Поле обязательно для заполнения',
            'percentPrice.required'=>'Поле обязательно для заполнения',
            'percentPrice.numeric'=>'Поле должно быть числовым',
            'percentPrice.min'=>'Минимальное значение поля - 0',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $flight = new Flight();

        $flight->from_city_id = $request->from_city_id;
        $flight->to_city_id = $request->to_city_id;
        $flight->from_airport_id = $request->from_airport_id;
        $flight->to_airport_id = $request->to_airport_id;
        $flight->date_from = $request->date_from;
        $flight->time_from = $request->time_from;
        $flight->date_to = $request->date_to;
        $flight->time_to = $request->time_to;
        $flight->timeWay = $request->timeWay;
        $flight->percentPrice = $request->percentPrice;
        $flight->airplane_id = $request->airplane_id;

        $flight->save();

        return response()->json('Рейс успешно добавлен', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

    $from_city = City::query()
        ->where('title', $request->from_city)
        ->first();

    $to_city = City::query()
        ->where('title', $request->to_city)
        ->first();

    $flights = Flight::query()
        ->with(['city','city_to','airport','airport_to','airplane'])
        ->where('from_city_id', $from_city->id)
        ->where('to_city_id', $to_city->id)
        ->where('date_from', $request->date_from)
        ->where('status', 'готов')
        ->get();
    session(['flights'=>$flights]);
    return redirect()->route('flightsFind');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function edit(Flight $flight)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Flight $flight)
    {
        $validation = Validator::make($request->all(), [
            'date_from'=>['required'],
            'time_from'=>['required'],
            'date_to'=>['required'],
            'time_to'=>['required'],
            'timeWay'=>['required'],
            'percentPrice'=>['required', 'numeric', 'min:0'],
        ],[
            'date_from.required'=>'Поле обязательно для заполнения',
            'time_from.required'=>'Поле обязательно для заполнения',
            'date_to.required'=>'Поле обязательно для заполнения',
            'time_to.required'=>'Поле обязательно для заполнения',
            'timeWay.required'=>'Поле обязательно для заполнения',
            'percentPrice.required'=>'Поле обязательно для заполнения',
            'percentPrice.numeric'=>'Поле должно быть числовым',
            'percentPrice.min'=>'Минимальное значение поля - 0',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $flight = Flight::query()
            ->where('id', $request->id)
            ->first();

        $tickets = Ticket::query()
            ->where('flight_id', $request->id)
            ->where('status', 'оформлен')
            ->get();


        $flight->from_city_id = $request->from_city_id;
        $flight->to_city_id = $request->to_city_id;
        $flight->from_airport_id = $request->from_airport_id;
        $flight->to_airport_id = $request->to_airport_id;
        $flight->date_from = $request->date_from;
        $flight->time_from = $request->time_from;
        $flight->date_to = $request->date_to;
        $flight->time_to = $request->time_to;
        $flight->timeWay = $request->timeWay;
        $flight->percentPrice = $request->percentPrice;
        $flight->airplane_id = $request->airplane_id;
        $flight->status = $request->status;

        if ($request->status == 'полёт') {
            foreach ($tickets as $ticket) {
                $ticket->status = 'использован';
                $ticket->update();
            }
        }

        $flight->update();

        return redirect()->route('FlightsPage');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function destroy(Flight $flight, Request $request)
    {
        $flight = Flight::query()
            ->where('id', $request->id)
            ->delete();

        return response()->json('Рейс успешно удален', 200);
    }

}
