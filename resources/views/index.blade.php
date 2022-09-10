@extends('layout')

@section('sidebar')
    @include('partials.sidebar')
@endsection
@section('content')

    <div class="row  main_cards">
        <div class="col s12 m12 l6 ">
            <div class="card grey lighten-4">
                <div class="card-content black-text">
                    <span class="card-title center-align actual_balance_font_bold">Total Receitas</span>
                    <p id="totalIncomes" class="green-text center-align actual_balance_font"></p>
                </div>
            </div>
        </div>
        <div class="col s12 m12 l6 ">
            <div class="card grey lighten-4">
                <div class="card-content black-text">
                    <span class="card-title center-align actual_balance_font_bold">Total despesas</span>
                    <p id="totalExpenses" class="red-text center-align actual_balance_font"></p>
                </div>
            </div>
        </div>
        <div class="col s12 m12 l12 ">
            <div class="card grey lighten-4">
                <div class="card-content black-text">
                    <span class="card-title center-align actual_balance_font_bold">Balanço atual</span>
                    <p id="totalBalance" class="center-align actual_balance_font"></p>
                </div>
            </div>
        </div>

        <div class="col s12 m12 l12 ">
            <div class="card grey lighten-4">
                <div class="card-content black-text">
                    <span class="card-title center-align">Gráfico balanço</span>
                    <canvas id="myChart" width="200" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script>
        let homeTab = document.getElementById("home")
        homeTab.classList.add("active")

        let dataIncome = [];
        let dataExpense = [];

                const months = {
                    0: 'janeiro',
                    1: 'fevereiro',
                    2: 'março',
                    3: 'abril',
                    4: 'maio',
                    5: 'junho',
                    6: 'julho',
                    7: 'agosto',
                    8: 'setembro',
                    9: 'outubro',
                    10: 'novembro',
                    11: 'dezembro'
                }
                let incomesMonth = Array(11).fill(0);
                let expensesMonth = Array(11).fill(0);

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/dashboard',
                method: 'get',
                success: function(result){
                    result.forEach(element => {
                        incomesMonth[element.month - 1] = element.incomes;
                        expensesMonth[element.month - 1] = element.expenses;
                    });
            }});

            let labelsDash = [];
            let dataDash = [];

            for (let index = 0; index < new Date().getMonth(); index++) {
                labelsDash.push(months[index]);
            }

            setTimeout(() => {
                const ctx = document.getElementById('myChart').getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels:labelsDash,
                        datasets: [{
                            label: 'Despesas',
                            data: expensesMonth,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                            ],
                            borderWidth: 1
                        },
                        {
                            label: 'Receitas',
                            data: incomesMonth,
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.2)',
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: false,
                            },
                        },
                        scales: {
                            y: {
                                ticks: {
                                    stepSize: 100,
                                    precision: 1,
                                    callback: function(value, index, ticks) {
                                        return 'R$ ' + value;
                                    }
                                }
                            }
                        }
                    }
                });
            }, 100)

            let incomes =0;
            let expenses =0;

            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            $.ajax({
                url: "{{ url('total/incomes') }}",
                method: 'get',
                dataType: 'json',
                success: function(result){
                    incomes = result;
                    $("p#totalIncomes").text("R$ " + result.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,"))

                }
            });
            $.ajax({
            url: "{{ url('total/expenses') }}",
            method: 'get',
            dataType: 'json',
            success: function(result){
                expenses = result;
                $("p#totalExpenses").text("R$ " + result.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,"))
            }
        });

        setTimeout(()=>{
            total = incomes - expenses;
            $("p#totalBalance").text("R$ " + total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,"))
            if(total > 0){
                $("p#totalBalance").addClass('green-text')
            } else {
                $("p#totalBalance").addClass('red-text')
            }
        }, 1000)






    </script>

@endsection
