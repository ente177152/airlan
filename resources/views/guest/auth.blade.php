@extends('layout.app')
@section('title')
    Авторизация
@endsection
@section('main')
    <div class="container" id="AuthPage">
        <div class="row align-items-center justify-content-center" style="margin-top: 6.2rem; margin-bottom: 1rem;">
            <div class="col-3">
                <h3 style="font-weight: 500; font-size: 2.6rem; color: rgba(38, 91, 227, 1)">Авторизация</h3>
            </div>
            <div class="col-2">
                <div style="height: 5px; background: rgba(38, 91, 227, 1)" class="w-100"></div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div :class="message? 'alert alert-danger col-6' : ''">
                @{{ message }}
            </div>
        </div>

        <div class="row justify-content-center align-items-center">
            <div class="col-5">
                <form @submit.prevent="Auth" id="form">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="login" name="login" placeholder="логин" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.login? 'is-invalid' : ''">
                       <div class="invalid-feedback" v-for="error in errors.login">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="пароль" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.password? 'is-invalid' : ''">
                       <div class="invalid-feedback" v-for="error in errors.password">
                            @{{ error }}
                        </div>
                    </div>
                        <button type="submit" class="btn col-4 text-white" style="background-color: #F4C82C; padding: 10px">вход</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        const Auth = {
            data() {
                return {
                    errors: [],
                    message: '',
                }
            },
            methods: {
                async Auth() {
                    const form_data = new FormData(document.querySelector('#form'));
                    const response = await fetch('{{route('Auth')}}',{
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                        },
                        body:form_data
                    });

                    if (response.status === 400) {
                        this.errors = await response.json();
                        setTimeout(()=>{
                            this.errors = ''
                        },2500);
                    }

                    if (response.status === 403) {
                        this.message = await response.json();
                        setTimeout(()=>{
                            this.message = ''
                        },2500);
                    }

                    if (response.status === 200) {
                        window.location = response.url;
                    }
                }
            }
        }
        Vue.createApp(Auth).mount('#AuthPage');
    </script>
@endsection
