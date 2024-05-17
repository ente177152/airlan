@extends('layout.app')
@section('title')
    Самолёты
@endsection
@section('main')
    <div class="container" id="AirplanesPage">
        <div class="row align-items-center justify-content-center" style="margin-top: 2.2rem; margin-bottom: 1rem;">
            <div class="col-3">
                <h3 style="font-weight: 500; font-size: 2.6rem; color: rgba(38, 91, 227, 1)">Самолёты</h3>
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
            <a class="btn col-2 text-white" style="background-color: #265BE3" href="{{route('AirplaneAddPage')}}">Добавить самолёт</a>
        </div>

        <div class="row">
            <div class="col-12">
                <table class="table" style="font-size: 1.4rem">
                    <thead>
                    <tr style="color: rgba(38, 91, 227, 1); font-size: 1.5rem; border-bottom: 2px solid rgba(38, 91, 227, 1)">
                        <th scope="col" style="font-weight: 500">ID</th>
                        <th scope="col" style="font-weight: 500">Название</th>
                        <th scope="col" style="font-weight: 500">Количество мест</th>
                        <th scope="col" style="font-weight: 500">Цена</th>
                        <th scope="col" style="font-weight: 500">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr style="border-color: #fff;" v-for="airplane in airplanes">
                        <td>@{{ airplane.id }}</td>
                        <td>@{{ airplane.title }}</td>
                        <td>@{{ airplane.count_seat }}</td>
                        <td>@{{ airplane.price }}</td>
                        <td>
                            <div class="row justify-content-between">
                                <a class="btn btn-primary col-5" :href="`{{route('editAirplanePage')}}/${airplane.id}`" >редактировать</a>
                                <button class="btn btn-danger col-5" @click="deleteAirplane(airplane.id)">удалить</button>
                            </div>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        const ShowAirplanes = {
            data() {
                return {
                    airplanes: [],
                    message: '',
                }
            },
            methods: {
                async getAirplanes() {
                    const response = await fetch('{{route('getAirplanes')}}');
                    const data =  await response.json();

                    this.airplanes = data.airplanes;
                },

                async deleteAirplane(id) {
                    const response = await fetch('{{route('deleteAirplane')}}', {
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
                    this.getAirplanes();
                }
            },
            mounted() {
                this.getAirplanes();
            }
        }
        Vue.createApp(ShowAirplanes).mount('#AirplanesPage');
    </script>
@endsection
