@extends('layout.app')
@section('title')
    Рейсы. Редактирование
@endsection
@section('main')
    <div class="container" id="EditFlightPage">
        <div class="row align-items-center justify-content-center" style="margin-top: 2.2rem; margin-bottom: 1rem;">
            <div class="col-5">
                <h3 style="font-weight: 500; font-size: 2.4rem; color: rgba(38, 91, 227, 1)">Рейсы. Редактирование</h3>
            </div>
            <div class="col-2">
                <div style="height: 5px; background: rgba(38, 91, 227, 1)" class="w-100"></div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-5">
                <form id="form" enctype="multipart/form-data" @submit.prevent="editFLight({{$flight->id}})">
                    <div class="mb-3">
                        <label for="from_city_id" class="form-label">Город отправления</label>
                        <select name="from_city_id" id="from_city_id" class="form-select" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px">
                            <option v-for="city in cities" :value="city.id" :selected="`{{$flight->city->id}}` == city.id">@{{ city.title }}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="from_airport_id" class="form-label">Аэропорт отправления</label>
                        <select name="from_airport_id" id="from_airport_id" class="form-select" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px">
                            <option v-for="airport in airports" :value="airport.id" :selected="`{{$flight->airport->id}}` == airport.id">@{{ airport.title }}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="to_city_id" class="form-label">Город прилёта</label>
                        <select name="to_city_id" id="to_city_id" class="form-select" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px">
                            <option v-for="city in cities" :value="city.id" :selected="`{{$flight->city_to->id}}` == city.id">@{{ city.title }}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="to_airport_id" class="form-label">Аэропорт прилёта</label>
                        <select name="to_airport_id" id="to_airport_id" class="form-select" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px">
                            <option v-for="airport in airports" :value="airport.id" :selected="`{{$flight->airport_to->id}}` == airport.id">@{{ airport.title }}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date_from" class="form-label">Дата отправления</label>
                        <input type="date" class="form-control" name="date_from" id="date_from"  style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.date_from? 'is-invalid' : ''" value="{{$flight->date_from}}">
                        <div class="invalid-feedback" v-for="error in errors.date_from">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="time_from" class="form-label">Время отправления</label>
                        <input type="time" class="form-control" name="time_from" id="time_from"  style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.time_from? 'is-invalid' : ''" value="{{$flight->time_from}}">
                        <div class="invalid-feedback" v-for="error in errors.time_from">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="date_to" class="form-label">Дата прилёта</label>
                        <input type="date" class="form-control" name="date_to" id="date_to"  style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.date_to? 'is-invalid' : ''" value="{{$flight->date_to}}">
                        <div class="invalid-feedback" v-for="error in errors.date_to">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="time_to" class="form-label">Время прилёта</label>
                        <input type="time" class="form-control" name="time_to" id="time_to"  style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.time_to? 'is-invalid' : ''" value="{{$flight->time_to}}">
                        <div class="invalid-feedback" v-for="error in errors.time_to">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="timeWay" class="form-label">Время в пути</label>
                        <input type="time" class="form-control" name="timeWay" id="timeWay"  style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.timeWay? 'is-invalid' : ''" value="{{$flight->timeWay}}">
                        <div class="invalid-feedback" v-for="error in errors.timeWay">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="percentPrice" class="form-label">Количество процентов</label>
                        <input type="text" class="form-control" name="percentPrice" id="percentPrice"  style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.percentPrice? 'is-invalid' : ''" value="{{$flight->percentPrice}}">
                        <div class="invalid-feedback" v-for="error in errors.percentPrice">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="airplane_id" class="form-label">Самолёт</label>
                        <select name="airplane_id" id="airplane_id" class="form-select" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px">
                            <option v-for="airplane in airplanes" :value="airplane.id" :selected="`{{$flight->airplane->id}}` == airplane.id">@{{ airplane.title }}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Статус</label>
                        <select name="status" id="status" class="form-select" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px">
                            <option v-for="status in statuses" :value="status" :selected="`{{$flight->status}}` == status">@{{ status }}</option>
                        </select>
                    </div>
                    <button type="submit" class="btn col-4 text-white" style="background-color: #F4C82C; padding: 10px">добавить</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        const EditFlight = {
            data() {
                return {
                    errors: [],
                    message: '',
                    cities: [],
                    airports: [],
                    airplanes: [],
                    statuses: ['готов', 'полёт', 'прибыл', 'ТО',],
                }
            },
            methods: {
                async editFLight(id) {
                    const form_data = new FormData(document.getElementById('form'));
                    form_data.append('id', id);
                    const response = await fetch('{{route('editFLight')}}', {
                        method:'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                        },
                        body: form_data,

                    });

                    if (response.status === 200) {
                        window.location = response.url;
                    }

                    if (response.status === 400) {
                        this.errors = await response.json();
                        setTimeout(()=> {
                            this.errors = [];
                        }, 2500);
                    }
                },
                async getCities() {
                    const response = await fetch('{{route('getCities')}}');
                    const data =  await response.json();

                    this.cities = data.cities;
                },
                async getAirports() {
                    const response = await fetch('{{route('getAirports')}}');
                    const data =  await response.json();

                    this.airports = data.airports;
                },
                async getAirplanes() {
                    const response = await fetch('{{route('getAirplanes')}}');
                    const data =  await response.json();

                    this.airplanes = data.airplanes;
                },
            },
            mounted() {
                this.getCities();
                this.getAirports();
                this.getAirplanes();
            }
        }
        Vue.createApp(EditFlight).mount('#EditFlightPage');
    </script>
@endsection
