<?php

namespace App\Http\Controllers;

use App\Models\Seat;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets_admin = Ticket::all();

        $tickets_user = Ticket::query()
            ->where('user_id', Auth::id())
            ->get();

        return response()->json([
            'tickets_admin'=>$tickets_admin,
            'tickets_user'=>$tickets_user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'fio'=>['required', 'regex:/[А-Яа-яЁёA-Za-z]/u'],
            'birthday'=>['required'],
            'passport'=>['nullable', 'regex:/[0-9]/u'],
            'certificate'=>['nullable'],
            'seat'=>['required'],
            'password'=>['required'],
        ], [
            'fio.required'=>'Поле обязательно для заполнения',
            'fio.regex'=>'Поле должно содержать только буквы и пробелы',
            'birthday.required'=>'Поле обязательно для заполнения',
            'birthday.regex'=>'Поле должно содержать только цифры и пробелы',
            'seat.required'=>'Поле обязательно для заполнения',
            'password.required'=>'Поле обязательно для заполнения',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $ticket = new Ticket();

        $ticket->user_id = Auth::id();
        $ticket->fio = $request->fio;
        $ticket->birthday = $request->birthday;
        if ($request->passport) $ticket->passport = $request->passport;
        if ($request->certificate) $ticket->certificate = $request->certificate;
        $ticket->flight_id = $request->flight_id;
        $ticket->seat = $request->seat;
        $ticket->price = $request->price + $request->price * 10 / 100;

        $ticket->save();

        return redirect()->route('HomePage');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
       $ticket = Ticket::query()
           ->where('id', $request->id)
           ->first();

       $ticket->status = 'отменен';

       $ticket->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
