@extends('layout.app')
@section('title')
    Рейсы. Добавление
@endsection
@section('main')
    <div class="container" id="AddFlightPage">
        <div class="row align-items-center justify-content-center" style="margin-top: 2.2rem; margin-bottom: 1rem;">
            <div class="col-5">
                <h3 style="font-weight: 500; font-size: 2.4rem; color: rgba(38, 91, 227, 1)">Рейсы. Добавление</h3>
            </div>
            <div class="col-2">
                <div style="height: 5px; background: rgba(38, 91, 227, 1)" class="w-100"></div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div :class="message? 'alert alert-success col-6' : ''">
                @{{ message }}
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-5">
                <form @submit.prevent="AddFlight" id="form" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="from_city_id" class="form-label">Город отправления</label>
                        <select name="from_city_id" id="from_city_id" class="form-select" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" v-model="from_city" :class="errors.from_city_id? 'is-invalid' : ''">
                            <option value="0" disabled selected></option>
                            <option v-for="city in cities" :value="city.id">@{{ city.title }}</option>
                        </select>
                        <div class="invalid-feedback" v-for="error in errors.from_city_id">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="from_airport_id" class="form-label">Аэропорт отправления</label>
                        <select name="from_airport_id" id="from_airport_id" class="form-select" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px">
                            <option v-for="airport in filter_from" :value="airport.id">@{{ airport.title }}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="to_city_id" class="form-label">Город прилёта</label>
                        <select name="to_city_id" id="to_city_id" class="form-select" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" v-model="to_city" :class="errors.to_city_id? 'is-invalid' : ''">
                            <option value="0" disabled selected></option>
                            <option v-for="city in cities" :value="city.id">@{{ city.title }}</option>
                        </select>
                        <div class="invalid-feedback" v-for="error in errors.to_city_id">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="to_airport_id" class="form-label">Аэропорт прилёта</label>
                        <select name="to_airport_id" id="to_airport_id" class="form-select" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px">
                            <option v-for="airport in filter_to" :value="airport.id">@{{ airport.title }}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date_from" class="form-label">Дата отправления</label>
                            <input type="date" class="form-control" name="date_from" id="date_from"  style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.date_from? 'is-invalid' : ''">
                        <div class="invalid-feedback" v-for="error in errors.date_from">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="time_from" class="form-label">Время отправления</label>
                        <input type="time" class="form-control" name="time_from" id="time_from"  style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.time_from? 'is-invalid' : ''">
                             <div class="invalid-feedback" v-for="error in errors.time_from">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="date_to" class="form-label">Дата прилёта</label>
                        <input type="date" class="form-control" name="date_to" id="date_to"  style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.date_to? 'is-invalid' : ''">
                             <div class="invalid-feedback" v-for="error in errors.date_to">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="time_to" class="form-label">Время прилёта</label>
                        <input type="time" class="form-control" name="time_to" id="time_to"  style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.time_to? 'is-invalid' : ''">
                             <div class="invalid-feedback" v-for="error in errors.time_to">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="timeWay" class="form-label">Время в пути</label>
                        <input type="time" class="form-control" name="timeWay" id="timeWay"  style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.timeWay? 'is-invalid' : ''">
                             <div class="invalid-feedback" v-for="error in errors.timeWay">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="percentPrice" class="form-label">Количество процентов</label>
                        <input type="text" class="form-control" name="percentPrice" id="percentPrice"  style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.percentPrice? 'is-invalid' : ''">
                             <div class="invalid-feedback" v-for="error in errors.percentPrice">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="airplane_id" class="form-label">Самолёт</label>
                        <select name="airplane_id" id="airplane_id" class="form-select" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px">
                            <option v-for="airplane in airplanes" :value="airplane.id">@{{ airplane.title }}</option>
                        </select>
                    </div>
                    <button type="submit" class="btn col-4 text-white" style="background-color: #F4C82C; padding: 10px">добавить</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const AddFlight = {
            data() {
                return {
                    errors: [],
                    message: '',
                    cities: [],
                    airports: [],
                    airplanes: [],
                    from_city: 0,
                    to_city: 0,
                }
            },
            methods: {
                async AddFlight() {
                    const form_data = new FormData(document.querySelector('#form'));
                    const response = await fetch('{{route('AddFlight')}}',{
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                        },
                        body:form_data
                    });

                    if (response.status === 400) {
                        this.errors = await response.json();
                        setTimeout(()=>{
                            this.errors = []
                        },2500);
                    }

                    if (response.status === 200) {
                        this.message = await response.json();
                        setTimeout(()=>{
                            this.message = ''
                        },2500);
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
            computed: {
                filter_from() {
                    let airports = this.airports;

                    if (this.from_city != 0) {
                        airports = this.airports.filter(airport=>airport.city_id === this.from_city);
                    }

                    return airports;
                },
                filter_to() {
                    let airports = this.airports;

                    if (this.to_city != 0) {
                        airports = this.airports.filter(airport=>airport.city_id === this.to_city);
                    }

                    return airports;
                }
            },
            mounted() {
                this.getCities();
                this.getAirports();
                this.getAirplanes();
            }
        }
        Vue.createApp(AddFlight).mount('#AddFlightPage');
    </script>
@endsection
