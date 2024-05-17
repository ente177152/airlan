@extends('layout.app')
@section('title')
    Рейсы
@endsection
@section('main')
    <div class="container" id="FlightsPage">
        <div class="row align-items-center justify-content-center" style="margin-top: 2.2rem; margin-bottom: 1rem;">
            <div class="col-3">
                <h3 style="font-weight: 500; font-size: 2.6rem; color: rgba(38, 91, 227, 1)">Рейсы</h3>
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

        <div class="row justify-content-end">
            <a class="btn col-2 text-white" style="background-color: #265BE3" href="{{route('FlightsAddPage')}}">Добавить рейс</a>
        </div>

        <div class="row">
            <div class="col-12">
                <table class="table align-middle" style="font-size: 0.9rem">
                    <thead>
                    <tr style="color: rgba(38, 91, 227, 1); font-size: 1rem; border-bottom: 2px solid rgba(38, 91, 227, 1)">
                        <th scope="col" style="font-weight: 500">ID</th>
                        <th scope="col" style="font-weight: 500">Город и Аэропорт отправления</th>
                        <th scope="col" style="font-weight: 500">Город и Аэропорт прилёта</th>
                        <th scope="col" style="font-weight: 500">Дата и время отправления</th>
                        <th scope="col" style="font-weight: 500">Дата и время прилёта</th>
                        <th scope="col" style="font-weight: 500">Проценты</th>
                        <th scope="col" style="font-weight: 500">Самолёт</th>
                        <th scope="col" style="font-weight: 500">Статус</th>
                        <th scope="col" style="font-weight: 500">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr style="border-color: #fff;" v-for="flight in flights">
                        <td>@{{ flight.id }}</td>
                        <td>@{{ flight.city.title + ' ' + flight.airport.title  }}</td>
                        <td>@{{ flight.city_to.title + ' ' + flight.airport_to.title }}</td>
                        <td>@{{ flight.date_from + ' ' + flight.time_from }}</td>
                        <td>@{{ flight.date_to + ' ' + flight.time_to }}</td>
                        <td>@{{ flight.percentPrice }}</td>
                        <td>@{{ flight.airplane.title  }}</td>
                        <td>@{{ flight.status  }}</td>
                        <td>
                            <div class="row justify-content-between">
                                <a :href="`{{route('FlightEditPage')}}/${flight.id}`" class="btn btn-primary col-12 mb-2">редактировать</a>
                                <button class="btn btn-danger col-12" @click="deleteFlight(flight.id)">удалить</button>
                            </div>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        const ShowFLights = {
            data() {
                return {
                    errors: [],
                    message: '',
                    flights: [],
                }
            },
            methods: {
                async getFlights() {
                    const response = await fetch('{{route('getFlights')}}');
                    const data =  await response.json();

                    this.flights = data.flights;
                },
                async deleteFlight(id) {
                    const response = await fetch('{{route('deleteFlight')}}', {
                        method:'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                            'Content-Type':'application/json'
                        },
                        body: JSON.stringify({
                            id:id,
                        })
                    });
                    if (response.status === 200) {
                        this.message = await response.json();
                        setTimeout(()=>{
                            this.message = '';
                        }, 2500);
                    }
                    this.getFlights();
                }
            },
            mounted() {
                this.getFlights();
            }
        }
        Vue.createApp(ShowFLights).mount('#FlightsPage');
    </script>
@endsection
