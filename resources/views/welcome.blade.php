@extends('layout.app')
@section('title')
    Главная страница
@endsection
@section('main')
    <div id="mainPage">
        <section class="linear-bg" style="min-height: 100vh">
            <div class="container">
                <div style="padding-top: 10rem">
                    <h1 style="padding-top: 11.3rem;padding-bottom: 2.25rem ; font-size: 4rem" class="text-white">Поиск авиабилетов</h1>

                    <form class="row align-items-end text-white" id="form" @submit.prevent="findFlight">
                        <div class="col-lg-3 col-12">
                            <div>
                                <label for="from_city" class="form-label">откуда</label>
                                <input type="text" name="from_city" id="from_city" class="form-control" style="height: 4.25rem">
                            </div>
                        </div>
                        <div class="col-lg-3 col-12">
                            <div>
                                <label for="to_city" class="form-label">куда</label>
                                <input type="text" name="to_city" id="to_city" class="form-control" style="height: 4.25rem">
                            </div>
                        </div>
                        <div class="col-lg-3 col-12">
                            <div>
                                <label for="date_from" class="form-label">когда</label>
                                <input type="date" name="date_from" id="date_from" class="form-control" style="height: 4.25rem">
                            </div>
                        </div>
                        <div class="col-lg-3 col-12">
                            <div>
                                <button type="submit" class="btn btn-warning text-white" style="height: 4.25rem; width: 12.25rem">найти</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row align-items-center" style="margin-top: 6.2rem; margin-bottom: 2.6rem;">
                    <div class="col-6">
                        <h3 style="font-weight: 500; font-size: 2.6rem; color: rgba(38, 91, 227, 1)">Популярные направления</h3>
                    </div>
                    <div class="col-6">
                        <div style="height: 5px; background: rgba(38, 91, 227, 1)" class="w-100"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-3 position-relative" v-for="city in cities">
                        <img :src="/public/ + city.img" class="img-fluid" style="border-radius: 10px; filter: brightness(70%); min-height: 345px; object-fit: cover">
                        <p class="position-absolute text-white" style="bottom: 2.5rem; left: 1.5rem;font-weight: 700; font-size: 2rem;">@{{ city.title }}</p>
                    </div>



                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row align-items-center" style="margin-top: 2.6rem; margin-bottom: 1.9rem;">
                    <div class="col-6">
                        <h3 style="font-weight: 500; font-size: 2.6rem; color: rgba(38, 91, 227, 1)">Все рейсы</h3>
                    </div>
                    <div class="col-6">
                        <div style="height: 5px; background: rgba(38, 91, 227, 1)" class="w-100"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <table class="table" style="font-size: 1.4rem">
                            <thead>
                            <tr style="color: rgba(38, 91, 227, 1); font-size: 1.5rem; border-bottom: 2px solid rgba(38, 91, 227, 1)">
                                <th scope="col" style="font-weight: 500">откуда</th>
                                <th scope="col" style="font-weight: 500">куда</th>
                                <th scope="col" style="font-weight: 500">дата и время вылета</th>
                                <th scope="col" style="font-weight: 500">цена билета</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr style="border-color: #fff;" v-for="flight in flights_welcome">
                                <td>@{{ flight.city.title }}</td>
                                <td>@{{ flight.city_to.title }}</td>
                                <td>
                                    @{{ flight.date_from }}
                                     @{{  flight.time_from }}
                                </td>
                                <td>@{{ flight.airplane.price + (flight.airplane.price * 10 / 100) }} руб.</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        const findFlights = {
            data() {
                return {
                    errors: [],
                    message: '',
                    flights_welcome: [],
                    cities: [],

                    month:['января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря',]
                }
            },
            methods: {
                async getFlights() {
                    const response = await fetch('{{route('getFlights')}}');
                    const data =  await response.json();

                    this.flights_welcome = data.flights_welcome;
                    this.normalize;
                },
                async getCities() {
                    const response = await fetch('{{route('getCities')}}');
                    const data =  await response.json();

                    this.cities = data.popular_cities;

                },
                async findFlight(){
                    const  form = document.querySelector('#form');
                    const from_data = new FormData(form);
                    const response = await fetch('{{route('findFlights')}}',{
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{csrf_token()}}',
                        },
                        body:from_data,
                    });
                    if(response.status===200){
                        window.location = response.url;
                    }
                }
            },
            computed:{
              normalize(){
                  this.flights_welcome.forEach((flight)=>{
                       let dateFrom = new Date(flight.date_from);
                      flight.date_from = dateFrom.getDate() + ' ' + this.month[dateFrom.getMonth()] + ' ' + dateFrom.getFullYear() + ',';
                      let timeFrom = flight.time_from.split(':');
                      flight.time_from = timeFrom[0]+':'+timeFrom[1];
                  });
              }
            },
            mounted() {
                this.getFlights();
                this.getCities();
            }
        }
        Vue.createApp(findFlights).mount('#mainPage');
    </script>
@endsection
