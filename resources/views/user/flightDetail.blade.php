@extends('layout.app')
@section('title')
    Выбор места
@endsection
@section('main')
    <div class="container" id="FlightDetailPage">
        <div class="row align-items-center" style="margin-top: 6.2rem; margin-bottom: 2.6rem;">
            <div class="col-6">
                <h3 style="font-weight: 500; font-size: 2.6rem; color: rgba(38, 91, 227, 1)">Выбор места</h3>
            </div>
            <div class="col-6">
                <div style="height: 5px; background: rgba(38, 91, 227, 1)" class="w-100"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-5" style="border-right: #265BE3 solid 2px; padding: 0; margin-bottom: 2.6rem; color: #265BE3;">
                <div style="background: #265BE3; min-height: 2.7rem;" class="text-white d-flex align-items-center justify-content-around">
                    <span style="font-weight: 700">{{$flight->airplane->title}}</span>
                    <span>
                                     {{$flight->city->title}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"/>
                                </svg>
                                {{$flight->city_to->title}}
                                </span>
                </div>
                <div class="row align-items-center" style="margin-top: 2rem">
                    <div class="col-4">
                        <p style="font-size: 1rem">28 января 2023</p>
                        <p style="font-weight: 500; font-size: 2rem">{{\Carbon\Carbon::createFromFormat('H:i:s',$flight->time_from)->format('H:i')}}</p>
                        <p style="font-size: 1.1rem">{{$flight->city->title}}</p>
                    </div>
                    <div class="col-3">
                        {{\Carbon\Carbon::createFromFormat('H:i:s',$flight->timeWay)->format('H')}} ч {{\Carbon\Carbon::createFromFormat('H:i:s',$flight->timeWay)->format('i')}} мин
                    </div>
                    <div class="col-4">
                        <p style="font-size: 1rem">28 января 2023</p>
                        <p style="font-weight: 500; font-size: 2rem">{{\Carbon\Carbon::createFromFormat('H:i:s',$flight->time_to)->format('H:i')}}</p>
                        <p style="font-size: 1.1rem">{{$flight->city_to->title}}</p>
                    </div>
                </div>
                <div class="row align-items-center" style="font-weight: 700">
                    <p class="col-6" style="font-size: 1.25rem">Стоимость</p>
                    <p class="col-5" style="font-size: 2rem">12500 руб.</p>
                </div>
            </div>
            <div class="col-7">
                <div class="row">
                    <div class="col-12">
                        <p style="font-weight: 500; font-size: 1.25rem">Выберите одно из предлагаемых мест.</p>
                        <p style="font-size: 1.25rem; font-weight: 300" class="fst-italic">Выход из самолёта находится в левой части расположения мест:</p>
                    </div>
                </div>
                <div class="row">
                    @if(count($flight->tickets) == 0)
                        @foreach($flight->airplane->seats as $seat)
                            <div class="col-1">
                                <div class="detail-card">
                                    <input type="radio" name="radio" id="radio-{{$seat->seat}}" value="{{$seat->seat}}" v-model="picked">
                                    <label for="radio-{{$seat->seat}}">{{$seat->seat}}</label>
                                </div>
                            </div>
                        @endforeach
                        @else
                            @foreach($flight->airplane->seats as $seat)
                                @foreach($flight->tickets as $ticket)
                                    @if($ticket->seat == $seat->seat && $ticket->status == 'оформлен')
                                        <div class="col-1">
                                            <div class="detail-card">
                                                <input type="radio" name="radio" id="radio-{{$seat->seat}}" value="{{$seat->seat}}" v-model="picked" disabled>
                                                <label for="radio-{{$seat->seat}}">{{$seat->seat}}</label>
                                            </div>
                                        </div>
                                    @break
                                    @endif
                                @endforeach
                                @if($ticket->seat != $seat->seat || $ticket->status != 'оформлен')
                                    <div class="col-1">
                                        <div class="detail-card">
                                            <input type="radio" name="radio" id="radio-{{$seat->seat}}" value="{{$seat->seat}}" v-model="picked">
                                            <label for="radio-{{$seat->seat}}">{{$seat->seat}}</label>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                    @endif



                </div>
{{--                --}}
               <div class="row">
                   <div class="col-4">
                      <div class="row">
                          <div class="col-2"><div class="detail-card-free" style="height: 20px; width: 20px; border-radius: 5px"></div></div>
                          <div class="col-10">свободно</div>
                      </div>
                   </div>
                   <div class="col-4">
                       <div class="row">
                           <div class="col-2"><div class="detail-card-busy" style="height: 20px; width: 20px; border-radius: 5px"></div></div>
                           <div class="col-10">занято</div>
                       </div>
            </div>
                   <div class="col-4">
                       <div class="row">
                           <div class="col-2"><div class="detail-card-select" style="height: 20px; width: 20px; border-radius: 5px"></div></div>
                           <div class="col-10">выбрано вами</div>
                       </div>
                   </div>
    </div>
            </div>
        </div>
{{--    Form    --}}
        <div class="row">
            <div class="row align-items-center" style="margin-top: 2.8rem; margin-bottom: 2.8rem;">
                <div class="col-6">
                    <h3 style="font-weight: 500; font-size: 2.6rem; color: rgba(38, 91, 227, 1)">Регистрация на рейс</h3>
                </div>
                <div class="col-6">
                    <div style="height: 5px; background: rgba(38, 91, 227, 1)" class="w-100"></div>
                </div>
            </div>

            <div class="row" style="font-size: 1.25rem">
                <p>Заполните личные данные для покупки и оформления билета</p>
                <p><span class="fw-bold">ВНИМАНИЕ!</span> Если вы покупаете билет не для себя, введите данные человека, на которого оформляете билет</p>
            </div>

            <div class="row" v-if="picked">
                <form action="" @submit.prevent="ticketReg({{$flight->airplane->price}})" id="form">
                    <div class="row mb-3">
                        <div class="col-4">
                            <input type="text" class="form-control" name="fio" placeholder="ФИО" :class="errors.fio? 'is-invalid' : ''">
                            <div class="invalid-feedback" v-for="error in errors.fio">
                                @{{ error }}
                            </div>
                        </div>
                        <div class="col-4">
                            <input type="date" class="form-control" name="birthday" placeholder="дата рождения" :class="errors.birthday? 'is-invalid' : ''">
                            <div class="invalid-feedback" v-for="error in errors.birthday">
                                @{{ error }}
                            </div>
                        </div>
                        <div class="col-4">
                            <input type="number" min="0" class="form-control" name="passport" placeholder="серия и номер паспорта" :class="errors.passport? 'is-invalid' : ''">
                            <div class="invalid-feedback" v-for="error in errors.passport">
                                @{{ error }}
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <input type="number" min="0" class="form-control" name="certificate" placeholder="номер свидетельства о рождении" aria-describedby="emailHelp" :class="errors.certificate? 'is-invalid' : ''">
                            <div class="invalid-feedback" v-for="error in errors.certificate">
                                @{{ error }}
                            </div>
                            <div id="emailHelp" class="form-text" style="color: #000; font-size: 1rem">*eсли билет оформляется для ребёнка</div>
                        </div>
                        <div class="col-2">
                            <input type="text" class="form-control" name="seat" :value="picked" :placeholder="`номер места - ` + picked" readonly :class="errors.seat? 'is-invalid' : ''">
                            <div class="invalid-feedback" v-for="error in errors.seat">
                                @{{ error }}
                            </div>
                        </div>
                        <div class="col-2">
                            <input type="text" class="form-control" name="flight_id" :value="`{{$flight->id}}`" readonly>
                        </div>
                        <div class="col-4">
                            <input type="password" class="form-control" name="password" placeholder="введите пароль" :class="errors.password? 'is-invalid' : ''">
                            <div class="invalid-feedback" v-for="error in errors.password">
                                @{{ error }}
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="rules" id="rules" checked :class="errors.rules? 'is-invalid' : ''">
                            <label class="form-check-label" for="rule">Я знаком с политикой конфиденциальности и даю свое согласие на обработку персональных данных.</label>
                            <div class="invalid-feedback" v-for="error in errors.rules">
                                @{{ error }}
                            </div>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-3">
                            <button type="submit" class="btn btn-warning text-white" style="height: 2.75rem; width: 12.25rem">оформить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const FlightDetail = {
            data() {
                return {
                    picked: '',
                    errors: [],
                }
            },
            methods: {
                async ticketReg(price) {
                    const form_data = new FormData(document.querySelector('#form'));
                    form_data.append('price',price);
                    const response = await fetch('{{route('ticketReg')}}',{
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                        },
                        body:form_data
                    });

                    if (response.status === 400) {
                        this.errors = await response.json();

                        setTimeout(()=> {
                            this.errors = []
                        }, 2500);
                    }

                    if (response.status === 200) {
                        window.location = response.url;
                    }
                }
            },
        }
        Vue.createApp(FlightDetail).mount('#FlightDetailPage');
    </script>
@endsection
