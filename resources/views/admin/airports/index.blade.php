@extends('layout.app')
@section('title')
    Аэропорты
@endsection
@section('main')
    <div class="container" id="AirportsPage">
        <div class="row align-items-center justify-content-center" style="margin-top: 2.2rem; margin-bottom: 1rem;">
            <div class="col-3">
                <h3 style="font-weight: 500; font-size: 2.6rem; color: rgba(38, 91, 227, 1)">Аэропорты</h3>
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
            <a class="btn col-2 text-white" style="background-color: #265BE3" href="{{route('AirportAddPage')}}">Добавить аэропорт</a>
        </div>

        <div class="row">
            <div class="col-12">
                <table class="table" style="font-size: 1.4rem">
                    <thead>
                    <tr style="color: rgba(38, 91, 227, 1); font-size: 1.5rem; border-bottom: 2px solid rgba(38, 91, 227, 1)">
                        <th scope="col" style="font-weight: 500">ID</th>
                        <th scope="col" style="font-weight: 500">Название</th>
                        <th scope="col" style="font-weight: 500">Город</th>
                        <th scope="col" style="font-weight: 500">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr style="border-color: #fff;" v-for="airport in airports">
                        <td>@{{ airport.id }}</td>
                        <td>@{{ airport.title }}</td>
                        <td>@{{ airport.city.title }}</td>
                        <td>
                            <div class="row justify-content-between">
                                <a class="btn btn-primary col-5" :href="`{{route('editAirportPage')}}/${airport.id}`">редактировать</a>
                                <button class="btn btn-danger col-5" @click="deleteAirport(airport.id)">удалить</button>
                            </div>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        const ShowAirports = {
            data() {
                return {
                    errors: [],
                    message: '',
                    airports: [],
                }
            },
            methods: {
                async getAirports() {
                    const response = await fetch('{{route('getAirports')}}');
                    const data =  await response.json();

                    this.airports = data.airports;
                },
                async deleteAirport(id) {
                    const response = await fetch('{{route('deleteAirport')}}', {
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
                    this.getAirports();
                },
            },
            mounted() {
                this.getAirports();
            }
        }
        Vue.createApp(ShowAirports).mount('#AirportsPage');
    </script>
@endsection
