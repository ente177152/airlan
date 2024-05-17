<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Flight;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\Promise\all;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::all();

        $tickets = Ticket::query()
            ->select(Ticket::raw('count(*) as count_tickets,flight_id, flights.to_city_id'))
            ->groupBy('flight_id')
            ->orderByDesc('count_tickets')
            ->limit(4)
            ->join('flights', 'flight_id', '=', 'flights.id')
            ->get();

        foreach ($tickets as $ticket) {
            $popular_cities[] = City::query()->where('id', $ticket->to_city_id)->first();
        }


        return response()->json([
            'cities'=>$cities,
            'popular_cities'=>$popular_cities
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
            'title'=>['required','unique:cities'],
            'img'=>['required', 'mimes:jpeg,jpg,png']
        ], [
            'title.required'=>'Поле обязательно для заполнения',
            'title.unique'=>'Город уже существует',
            'img.required'=>'Поле обязательно для заполнения',
            'img.mimes'=>'Используйте файлы формата jpeg,jpg,png',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $path_img = '';
        if ($request->file('img')) {
            $path_img = $request->file('img')->store('/public/img/cities');
        }

        $city = new City();

        $city->title = $request->title;
        $city->img = '/storage/'.$path_img;

        $city->save();

        return response()->json('Город успешно добавлен', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city, Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        $validation = Validator::make($request->all(), [
            'title'=>['required','unique:cities'],
            'img'=>['mimes:jpeg,jpg,png', 'nullable']
        ], [
            'title.required'=>'Поле обязательно для заполнения',
            'title.unique'=>'Город уже существует',
            'img.mimes'=>'Используйте файлы формата jpeg,jpg,png',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $city = City::query()
            ->where('id', $request->id)
            ->first();

        $path_img = '';
        if ($request->file('img')) {
            $path_img = $request->file('img')->store('/public/img/cities');
        }

        $city->title = $request->title;
        if ($request->file('img')) {
            $city->img = '/storage/'.$path_img;
        }

        $city->update();

        return redirect()->route('CityPage');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city, Request $request)
    {
        $city = City::query()
            ->where('id', $request->id)
            ->delete();

        return response()->json('Город успешно удален', 200);
    }
}
