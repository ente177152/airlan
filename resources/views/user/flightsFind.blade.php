@extends('layout.app')
@section('title')
    Рейсы
@endsection
@section('main')
<section style="padding: 5.9rem 5.5rem">
    <div class="container">
        <div class="row">
            <div class="col-3">
                <h4 style="color: #265BE3; font-weight: 500; font-size: 1.5rem; margin-bottom: 2rem">Фильтры</h4>
                <p style="color: #265BE3; font-weight: 400; font-size: 1.25rem">Стоимость</p>
                <div class="row">
                    <input type="number" placeholder="от" class="col-5" style="border: 1px solid #265BE3; height: 2.7rem; border-radius: 5px; margin-right: 1rem">
                    <input type="number" placeholder="до" class="col-5" style="border: 1px solid #265BE3; height: 2.7rem; border-radius: 5px">
                </div>
            </div>

            <div class="col-9" style="color: rgba(38, 91, 227, 1)">
                <div class="row align-items-center" style="margin-bottom: 1.5rem">
                    <div class="col-6">
                        <h3 style="font-weight: 500; font-size: 2.6rem">Рейсы</h3>
                    </div>
                    <div class="col-6">
                        <div style="height: 5px; background: rgba(38, 91, 227, 1)" class="w-100"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        @if(count($flights) !== 0)
                            <p style="font-size: 1.25rem; font-weight: 400; color: black">По вашему запросу найдены следующие рейсы</p>
                        @else
                            <p style="font-size: 1.25rem; font-weight: 400; color: black">По вашему запросу ничего не найдено</p>
                        @endif
                    </div>
                </div>
                <div class="row">
{{--                    --}}

                    @foreach($flights as $flight)
                        <div class="col-7" style="border-right: #265BE3 solid 2px; padding: 0; margin-bottom: 2.6rem">
                            <div style="background: #265BE3; min-height: 2.7rem;" class="text-white d-flex align-items-center justify-content-around">
                                <span style="font-weight: 700">{{$flight->airplane->title}}</span>
                                <span>
                                    {{$flight->city->title}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"/>
                                </svg>
                                {{$flight->city_to->title}}
                                </span>
                            </div>
                            <div class="row align-items-center" style="margin-top: 2rem">
                                <div class="col-4">
                                    <p style="font-size: 1rem">
                                        {{\Carbon\Carbon::parse($flight->date_from)->translatedFormat('j F Y')}}
                                    </p>
                                    <p style="font-weight: 500; font-size: 2rem">{{\Carbon\Carbon::createFromFormat('H:i:s',$flight->time_from)->format('H:i')}}</p>
                                    <p style="font-size: 1.1rem">{{$flight->city->title}}</p>
                                </div>
                                <div class="col-3">
                                    {{\Carbon\Carbon::createFromFormat('H:i:s',$flight->timeWay)->format('H')}} ч {{\Carbon\Carbon::createFromFormat('H:i:s',$flight->timeWay)->format('i')}} мин
                                </div>
                                <div class="col-4">
                                    <p style="font-size: 1rem">{{\Carbon\Carbon::parse($flight->date_to)->translatedFormat('j F Y')}}</p>
                                    <p style="font-weight: 500; font-size: 2rem">{{\Carbon\Carbon::createFromFormat('H:i:s',$flight->time_to)->format('H:i')}}</p>
                                    <p style="font-size: 1.1rem">{{$flight->city_to->title}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-5">
                            <p class="d-flex justify-content-between">
                                <span>Цена места:</span>
                                <span style="font-weight: 500">{{$flight->airplane->price}} руб.</span>
                            </p>
                            <p class="d-flex justify-content-between">
                                <span>Количество свободных:</span>
                                <span style="font-weight: 500">5 мест.</span>
                            </p>
                            <p class="d-flex justify-content-between">
                                <span>Взимаемый процент:</span>
                                <span style="font-weight: 500">{{$flight->percentPrice}}</span>
                            </p>
                            <p class="d-flex justify-content-between">
                                <span style="font-weight: 700; font-size: 1.25rem">Стоимость</span>
                                <span style="font-weight: 700; font-size: 2rem">{{$flight->airplane->price + ($flight->airplane->price * 10 / 100)}} руб.</span>
                            </p>
                            @if(\Illuminate\Support\Facades\Auth::user())<a href="{{route('flightDetail', ['flight'=>$flight])}}" class="btn text-white" style="background-color: #F4C82C; padding: 10px">Выбрать место</a>@endif
                        </div>
                    @endforeach
{{--                    --}}

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
