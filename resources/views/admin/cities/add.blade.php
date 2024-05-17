@extends('layout.app')
@section('title')
    Города. Добавление
@endsection
@section('main')
    <div class="container" id="AddCityPage">
        <div class="row align-items-center justify-content-center" style="margin-top: 2.2rem; margin-bottom: 1rem;">
            <div class="col-5">
                <h3 style="font-weight: 500; font-size: 2.4rem; color: rgba(38, 91, 227, 1)">Города. Добавление</h3>
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
                <form @submit.prevent="AddCity" id="form" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="title" name="title" placeholder="название" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.title? 'is-invalid' : ''">
                        <div class="invalid-feedback" v-for="error in errors.title">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="file" name="img" class="form-control" style="border: 1px solid #265BE3; border-radius: 5px" :class="errors.img? 'is-invalid' : ''">
                        <div class="invalid-feedback" v-for="error in errors.img">
                            @{{ error }}
                        </div>
                    </div>
                    <button type="submit" class="btn col-4 text-white" style="background-color: #F4C82C; padding: 10px">добавить</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const AddCity = {
            data() {
                return {
                    errors: [],
                    message: '',
                }
            },
            methods: {
                async AddCity() {
                    const form_data = new FormData(document.querySelector('#form'));
                    const response = await fetch('{{route('AddCity')}}',{
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
                }
            }
        }
        Vue.createApp(AddCity).mount('#AddCityPage');
    </script>
@endsection
