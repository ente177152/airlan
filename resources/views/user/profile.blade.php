@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layout.app')
@section('title')
    Профиль
@endsection
@section('main')
    <div class="container" id="EditPage">
        <div class="row align-items-center justify-content-center" style="margin-top: 2.2rem; margin-bottom: 1rem;">
            <div class="col-5">
                <h3 style="font-weight: 500; font-size: 2.4rem; color: rgba(38, 91, 227, 1)">Профиль</h3>
            </div>
            <div class="col-4">
                <div style="height: 5px; background: rgba(38, 91, 227, 1)" class="w-100"></div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div :class="message? 'alert alert-success col-6' : ''">
                @{{ message }}
            </div>
        </div>

        <div class="row justify-content-center align-items-center">
            <div class="col-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                </svg>
            </div>
            <div class="col-6">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><span class="fw-bold">ФИО: </span> {{Auth::user()->fio}}</li>
                    <li class="list-group-item"><span class="fw-bold">Дата рождения: </span>{{Auth::user()->birthday}}</li>
                    <li class="list-group-item"><span class="fw-bold">Паспорт: </span>{{Auth::user()->passport}}</li>
                    <li class="list-group-item"><span class="fw-bold">Email: </span>{{Auth::user()->email}}</li>
                    <li class="list-group-item"><span class="fw-bold">Телефон: </span>{{Auth::user()->phone}}</li>
                    <li class="list-group-item"><span class="fw-bold">Логин: </span>{{Auth::user()->login}}</li>
                </ul>

                <div class="row justify-content-end">
                    <button type="button" class="btn btn-primary col-4" data-bs-toggle="modal" data-bs-target="#exampleModal">Редактировать данные</button>
                </div>
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="EditProfile" id="form">
                                <div class="mb-3">
                                    <label for="fio" class="form-label">ФИО</label>
                                    <input type="text" class="form-control" id="fio" name="fio" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.fio? 'is-invalid' : ''" value="{{Auth::user()->fio}}">
                                    <div class="invalid-feedback" v-for="error in errors.fio">
                                        @{{ error }}
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="birthday" class="form-label">Дата рождения</label>
                                    <input type="date" class="form-control" id="birthday" name="birthday" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.birthday? 'is-invalid' : ''" value="{{Auth::user()->birthday}}">
                                    <div class="invalid-feedback" v-for="error in errors.birthday">
                                        @{{ error }}
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="passport" class="form-label">Паспорт</label>
                                    <input type="number" class="form-control" id="passport" name="passport" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.passport? 'is-invalid' : ''" value="{{Auth::user()->passport}}">
                                    <div class="invalid-feedback" v-for="error in errors.passport">
                                        @{{ error }}
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="login" class="form-label">Логин</label>
                                    <input type="text" class="form-control" id="login" name="login" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.login? 'is-invalid' : ''" value="{{Auth::user()->login}}">
                                    <div class="invalid-feedback" v-for="error in errors.login">
                                        @{{ error }}
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Телефон</label>
                                    <input type="number" class="form-control" id="phone" name="phone" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.phone? 'is-invalid' : ''" value="{{Auth::user()->phone}}">
                                    <div class="invalid-feedback" v-for="error in errors.phone">
                                        @{{ error }}
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.email? 'is-invalid' : ''" value="{{Auth::user()->email}}">
                                    <div class="invalid-feedback" v-for="error in errors.email">
                                        @{{ error }}
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Пароль</label>
                                    <input type="password" class="form-control" id="password" name="password" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.password? 'is-invalid' : ''">
                                    <div class="invalid-feedback" v-for="error in errors.password">
                                        @{{ error }}
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Повторите пароль</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.password_confirmation? 'is-invalid' : ''">
                                    <div class="invalid-feedback" v-for="error in errors.password_confirmation">
                                        @{{ error }}
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="mb-3">
                                        <label for="old_password" class="form-label">Подтвердите старый пароль</label>
                                        <input type="password" class="form-control" id="old_password" name="old_password" style="border: 1px solid #265BE3; height: 2.9rem; border-radius: 5px" :class="errors.old_password? 'is-invalid' : ''">
                                        <div class="invalid-feedback" v-for="error in errors.old_password">
                                            @{{ error }}
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const EditProfile = {
            data() {
                return {
                    errors: [],
                    message: '',
                }
            },
            methods: {
                async EditProfile() {
                    const form_data = new FormData(document.querySelector('#form'));
                    const response = await fetch('{{route('EditProfile')}}',{
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
        Vue.createApp(EditProfile).mount('#EditPage');
    </script>
@endsection
