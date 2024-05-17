<?php

namespace App\Http\Controllers;

use App\Models\Airplane;
use App\Models\Seat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AirplaneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $airplanes = Airplane::all();

        return response()->json([
            'airplanes'=>$airplanes,
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
            'title'=>['required', 'unique:airplanes'],
            'count_seat'=>['required', 'numeric', 'min:1'],
            'price'=>['required', 'numeric', 'min:1'],
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $airplane = new Airplane();

        $airplane->title = $request->title;
        $airplane->count_seat = $request->count_seat;
        $airplane->price = $request->price;

        $airplane->save();


        $airplane = Airplane::query()
            ->where('title', $request->title)
            ->first();

        $seats = new Seat();

        for ($i = 1; $i <= $airplane->count_seat; $i++) {
            $seats->insert([
                'airplane_id'=>$airplane->id,
                'seat'=>$i,
            ]);
        }

        return response()->json('Самолёт успешно добавлен', 200);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Airplane  $airplane
     * @return \Illuminate\Http\Response
     */
    public function show(Airplane $airplane)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Airplane  $airplane
     * @return \Illuminate\Http\Response
     */
    public function edit(Airplane $airplane)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Airplane  $airplane
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Airplane $airplane)
    {
        $validation = Validator::make($request->all(), [
            'title'=>['required'],
            'count_seat'=>['required', 'numeric', 'min:1'],
            'price'=>['required', 'numeric', 'min:1'],
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $airplane = Airplane::query()
            ->where('id', $request->id)
            ->first();

        $airplane->title = $request->title;

        if ($airplane->count_seat != $request->count_seat) {
            $seats = Seat::query()
                ->where('airplane_id', $request->id)
                ->delete();

            $seats = new Seat();
            for ($i = 1; $i <= $request->count_seat; $i++) {
                $seats->insert([
                    'airplane_id'=>$airplane->id,
                    'seat'=>$i,
                ]);
            }
        }
        $airplane->count_seat = $request->count_seat;
        $airplane->price = $request->price;

        $airplane->update();

        return redirect()->route('AirplanesPage');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Airplane  $airplane
     * @return \Illuminate\Http\Response
     */
    public function destroy(Airplane $airplane, Request $request)
    {
        $airplane = Airplane::query()
            ->where('id', $request->id)
            ->delete();

        return response()->json('Самолёт успешно удален', 200);
    }
}
