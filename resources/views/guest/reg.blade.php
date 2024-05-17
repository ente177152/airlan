@extends('layout.app')
@section('title')
    Регистрация
@endsection
@section('main')
    <div class="container" id="RegPage">
        <div class="row align-items-center justify-content-center" style="margin-top: 6.2rem; margin-bottom: 1rem;">
            <div class="col-3">
                <h3 style="font-weight: 500; font-size: 2.6rem; color: rgba(38, 91, 227, 1)">Регистрация</h3>
            </div>
            <div class="col-2">
                <div style="height: 5px; background: rgba(38, 91, 227, 1)" class="w-100"></div>
            </div>
        </div>
        <div class="row justify-content-center align-items-center">
            <div class="col-5">
                <form id="form" @submit.prevent="Reg">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="fio" name="fio" placeholder="фио" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.fio? 'is-invalid' : ''">
                        <div class="invalid-feedback" v-for="error in errors.fio">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="date" class="form-control" id="birthday" name="birthday" placeholder="дата рождения" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.birthday? 'is-invalid' : ''">
                         <div class="invalid-feedback" v-for="error in errors.birthday">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="number" class="form-control" id="passport" name="passport" placeholder="паспорт" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.passport? 'is-invalid' : ''">
                         <div class="invalid-feedback" v-for="error in errors.passport">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="login" name="login" placeholder="логин" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.login? 'is-invalid' : ''">
                         <div class="invalid-feedback" v-for="error in errors.login">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="number" class="form-control" id="phone" name="phone" placeholder="телефон" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.phone? 'is-invalid' : ''">
                         <div class="invalid-feedback" v-for="error in errors.phone">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="email" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.email? 'is-invalid' : ''">
                         <div class="invalid-feedback" v-for="error in errors.email">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="пароль" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.password? 'is-invalid' : ''">
                         <div class="invalid-feedback" v-for="error in errors.password">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="повторите пароль" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.password_confirmation? 'is-invalid' : ''">
                         <div class="invalid-feedback" v-for="error in errors.password_confirmation">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="rules" name="rules" checked :class="errors.rules? 'is-invalid' : ''">
                        <label class="form-check-label" for="rules">Согласен с правилами регистрации</label>
                        <div class="invalid-feedback" v-for="error in errors.rules">
                            @{{ error }}
                        </div>
                    </div>
                    <button type="submit" class="btn col-4 text-white" style="background-color: #F4C82C; padding: 10px">регистрация</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const Reg = {
            data() {
                return {
                    errors: [],
                }
            },
            methods: {
                async Reg() {
                    const form_data = new FormData(document.querySelector('#form'));
                    const response = await fetch('{{route('Reg')}}',{
                       method: 'post',
                       headers: {
                           'X-CSRF-TOKEN': '{{csrf_token()}}',
                       },
                        body:form_data
                    });

                    if (response.status === 400) {
                        this.errors = await response.json();
                    }

                    if (response.status === 200) {
                        window.location = response.url;
                    }
                }
            }
        }
        Vue.createApp(Reg).mount('#RegPage');
    </script>
@endsection
