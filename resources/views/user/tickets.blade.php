@extends('layout.app')
@section('title')
    Мои билеты
@endsection
@section('main')
    <div class="container" id="TicketsPage">
        <div class="row align-items-center justify-content-center" style="margin-top: 2.2rem; margin-bottom: 1rem;">
            <div class="col-3">
                <h3 style="font-weight: 500; font-size: 2.6rem; color: rgba(38, 91, 227, 1)">Мои билеты</h3>
            </div>
            <div class="col-2">
                <div style="height: 5px; background: rgba(38, 91, 227, 1)" class="w-100"></div>
            </div>
        </div>

        <div class="row justify-content-end">
            <div class="col-2">
                <p class="text-center">Статус</p>
                <select name="status" id="status" class="form-select" v-model="status">
                    <option value="все">все</option>
                    <option value="оформлен">оформлен</option>
                    <option value="отменен">отменен</option>
                    <option value="использован">использован</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <table class="table align-middle text-center" style="font-size: 0.9rem">
                    <thead>
                    <tr style="color: rgba(38, 91, 227, 1); font-size: 1rem; border-bottom: 2px solid rgba(38, 91, 227, 1)">
                        <th scope="col" style="font-weight: 500">ID</th>
                        <th scope="col" style="font-weight: 500">ФИО</th>
                        <th scope="col" style="font-weight: 500">Дата рождения</th>
                        <th scope="col" style="font-weight: 500">Паспорт</th>
                        <th scope="col" style="font-weight: 500">Свидетельство</th>
                        <th scope="col" style="font-weight: 500">Номер рейса</th>
                        <th scope="col" style="font-weight: 500">Место</th>
                        <th scope="col" style="font-weight: 500">Цена</th>
                        <th scope="col" style="font-weight: 500">Статус</th>
                        <th scope="col" style="font-weight: 500">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr style="border-color: #fff;" v-for="ticket in filterStat">
                        <td>@{{ ticket.id }}</td>
                        <td>@{{ ticket.fio }}</td>
                        <td>@{{ ticket.birthday }}</td>
                        <td>@{{ ticket.passport }}</td>
                        <td>@{{ ticket.certificate }}</td>
                        <td>@{{ ticket.flight_id  }}</td>
                        <td>@{{ ticket.seat }}</td>
                        <td>@{{ ticket.price }}</td>
                        <td>@{{ ticket.status }}</td>
                        <td><button class="btn btn-danger col-12" @click="noTicket(ticket.id)" v-if="ticket.status == 'оформлен'">отменить</button></td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const ShowTickets = {
            data() {
                return {
                    tickets: [],
                    status: 'все',
                }
            },
            methods: {
                async getTickets() {
                    const response = await fetch('{{route('getTickets')}}');
                    const data =  await response.json();

                    this.tickets = data.tickets_user;
                },

                async noTicket(id) {
                    const response = await fetch('{{route('noTicket')}}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id:id,
                        })
                    });

                    this.getTickets();
                },
            },
            computed: {
                filterStat() {
                    let tickets = this.tickets;

                    if (this.status != 'все') {
                        tickets = this.tickets.filter(ticket=>ticket.status === this.status);
                    }

                    console.log(tickets)
                    return tickets;
                }
            },
            mounted() {
                this.getTickets();
            }
        }
        Vue.createApp(ShowTickets).mount('#TicketsPage');
    </script>
@endsection
