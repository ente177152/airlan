@extends('layout.app')
@section('title')
    Города
@endsection
@section('main')
    <div class="container" id="CitiesPage">
        <div class="row align-items-center justify-content-center" style="margin-top: 2.2rem; margin-bottom: 1rem;">
            <div class="col-3">
                <h3 style="font-weight: 500; font-size: 2.6rem; color: rgba(38, 91, 227, 1)">Города</h3>
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
            <a class="btn col-2 text-white" style="background-color: #265BE3" href="{{route('CityAddPage')}}">Добавить город</a>
        </div>

        <div class="row">
            <div class="col-12">
                <table class="table" style="font-size: 1.4rem">
                    <thead>
                    <tr style="color: rgba(38, 91, 227, 1); font-size: 1.5rem; border-bottom: 2px solid rgba(38, 91, 227, 1)">
                        <th scope="col" style="font-weight: 500">ID</th>
                        <th scope="col" style="font-weight: 500">Изображение</th>
                        <th scope="col" style="font-weight: 500">Название</th>
                        <th scope="col" style="font-weight: 500">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr style="border-color: #fff;" v-for="city in cities">
                        <td>@{{ city.id }}</td>
                        <td><img :src="/public/ + city.img" alt="" style="object-fit: cover; width: 12rem"></td>
                        <td>@{{ city.title }}</td>
                        <td>
                            <div class="row justify-content-between">
                                <a :href="`{{route('editCityPage')}}/${city.id}`" class="btn btn-primary col-5">редактировать</a>
                                <button class="btn btn-danger col-5" @click="deleteCity(city.id)">удалить</button>
                            </div>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        const ShowCity = {
            data() {
                return {
                    errors: [],
                    message: '',
                    cities: [],
                }
            },
            methods: {
                async getCities() {
                    const response = await fetch('{{route('getCities')}}');
                    const data =  await response.json();

                    this.cities = data.cities;
                },
                async deleteCity(id) {
                    const response = await fetch('{{route('deleteCity')}}', {
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
                    this.getCities();
                },
            },
            mounted() {
                this.getCities();
            }
        }
        Vue.createApp(ShowCity).mount('#CitiesPage');
    </script>
@endsection
