@extends('layout.app')
@section('title')
    Билеты
@endsection
@section('main')
    <div class="container" id="TicketsPage">
        <div class="row align-items-center justify-content-center" style="margin-top: 2.2rem; margin-bottom: 1rem;">
            <div class="col-3">
                <h3 style="font-weight: 500; font-size: 2.6rem; color: rgba(38, 91, 227, 1)">Пользователи</h3>
            </div>
            <div class="col-2">
                <div style="height: 5px; background: rgba(38, 91, 227, 1)" class="w-100"></div>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <table class="table align-middle" style="font-size: 0.9rem">
                    <thead>
                    <tr style="color: rgba(38, 91, 227, 1); font-size: 1rem; border-bottom: 2px solid rgba(38, 91, 227, 1)">
                        <th scope="col" style="font-weight: 500">ID</th>
                        <th scope="col" style="font-weight: 500">ФИО</th>
                        <th scope="col" style="font-weight: 500">Дата рождения</th>
                        <th scope="col" style="font-weight: 500">Паспорт</th>
                        <th scope="col" style="font-weight: 500">Email</th>
                        <th scope="col" style="font-weight: 500">Телефон</th>
                        <th scope="col" style="font-weight: 500">Логин</th>
                        <th scope="col" style="font-weight: 500">Роль</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr style="border-color: #fff;">
                        <td>1</td>
                        <td>Грязнов Никита Сергеевич</td>
                        <td>2003-04-16</td>
                        <td>2217680200</td>
                        <td>airlines@me.ru</td>
                        <td>88005553535</td>
                        <td>airlines</td>
                        <td>admin</td>
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

                    this.tickets = data.tickets_admin;
                },
            },

            computed: {
               filterStat() {
                  let tickets = this.tickets;

                  if (this.status != 'все') {
                      tickets = this.tickets.filter(ticket=>ticket.status === this.status);
                  }

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
