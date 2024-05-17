@extends('layout.app')
@section('title')
    Аэропорты. Редактирование
@endsection
@section('main')
    <div class="container" id="EditAirportPage">
        <div class="row align-items-center justify-content-center" style="margin-top: 2.2rem; margin-bottom: 1rem;">
            <div class="col-5">
                <h3 style="font-weight: 500; font-size: 2.4rem; color: rgba(38, 91, 227, 1)">Аэропорты. Редактирование</h3>
            </div>
            <div class="col-2">
                <div style="height: 5px; background: rgba(38, 91, 227, 1)" class="w-100"></div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-5">
                <form @submit.prevent="editAirport({{$airport->id}})" id="form" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="title" name="title" value="{{$airport->title}}" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.title? 'is-invalid' : ''">
                        <div class="invalid-feedback" v-for="error in errors.title">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <select name="city" id="city" class="form-select" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px">
                            <option v-for="city in cities" :value="city.id" :selected="`{{$airport->id}}` == city.id">@{{ city.title }}</option>
                        </select>
                    </div>
                    <button type="submit" class="btn col-4 text-white" style="background-color: #F4C82C; padding: 10px">редактировать</button>
                </form>
            </div>
        </div>
    </div>
    </div>
    <script>
        const EditAirport = {
            data() {
                return {
                    errors:[],
                    cities:[],
                }
            },
            methods: {
                async editAirport(id) {
                    const form_data = new FormData(document.getElementById('form'));
                    form_data.append('id', id);
                    const response = await fetch('{{route('editAirport')}}', {
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
            },
            mounted() {
                this.getCities();
            }
        }
        Vue.createApp(EditAirport).mount('#EditAirportPage');
    </script>
@endsection

