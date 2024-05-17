@extends('layout.app')
@section('title')
    Города. Редактирование
@endsection
@section('main')
    <div class="container" id="EditCityPage">
        <div class="row align-items-center justify-content-center" style="margin-top: 2.2rem; margin-bottom: 1rem;">
            <div class="col-5">
                <h3 style="font-weight: 500; font-size: 2.4rem; color: rgba(38, 91, 227, 1)">Города. Редактирование</h3>
            </div>
            <div class="col-2">
                <div style="height: 5px; background: rgba(38, 91, 227, 1)" class="w-100"></div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-5">
                <form @submit.prevent="editCity({{$city->id}})" id="form" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="title" name="title" value="{{$city->title}}" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.title? 'is-invalid' : ''">
                        <div class="invalid-feedback" v-for="error in errors.title">
                            @{{ error }}
                        </div>
                    </div>
                    @if($city->img)<div class="mb-3 row justify-content-center"><img src="/public/{{$city->img}}" alt="" class="w-50"></div>@endif
                    <div class="mb-3">
                        <input type="file" name="img" class="form-control" style="border: 1px solid #265BE3; border-radius: 5px" :class="errors.img? 'is-invalid' : ''">
                        <div class="invalid-feedback" v-for="error in errors.img">
                            @{{ error }}
                        </div>
                    </div>
                    <button type="submit" class="btn col-4 text-white" style="background-color: #F4C82C; padding: 10px">редактировать</button>
                </form>
            </div>
        </div>
    </div>
    </div>
    <script>
        const EditCity = {
            data() {
                return {
                    errors:[],
                }
            },
            methods: {
                async editCity(id) {
                    const form_data = new FormData(document.getElementById('form'));
                    form_data.append('id', id);
                    const response = await fetch('{{route('editCity')}}', {
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
                }
            },
        }
        Vue.createApp(EditCity).mount('#EditCityPage');
    </script>
@endsection
