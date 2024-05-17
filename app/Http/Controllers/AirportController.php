<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AirportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $airports = Airport::with('city')->get();

        return response()->json([
            'airports'=>$airports,
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
           'title'=>['required', 'unique:airports'],
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $airport = new Airport();

        $airport->title = $request->title;
        $airport->city_id = $request->city;

        $airport->save();

        return response()->json('Аэропорт успешно добавлен', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Airport  $airport
     * @return \Illuminate\Http\Response
     */
    public function show(Airport $airport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Airport  $airport
     * @return \Illuminate\Http\Response
     */
    public function edit(Airport $airport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Airport  $airport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Airport $airport)
    {
        $validation = Validator::make($request->all(), [
            'title'=>['required'],
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $airport = Airport::query()
            ->where('id', $request->id)
            ->first();

        $airport->title = $request->title;
        $airport->city_id = $request->city;

        $airport->update();

        return redirect()->route('AirportsPage');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Airport  $airport
     * @return \Illuminate\Http\Response
     */
    public function destroy(Airport $airport, Request $request)
    {
        $airport = Airport::query()
            ->where('id', $request->id)
            ->delete();

        return response()->json('Аэропорт успешно удален', 200);
    }
}
