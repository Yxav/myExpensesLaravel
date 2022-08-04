@extends('layout')

@section('sidebar')
    @include('partials.sidebar')
@endsection
@section('content')

<div class="row  main_cards">

              <div class="col s10 m6 l6 ">
                <div class="card grey lighten-4">
                  <div class="card-content black-text">
                    <span class="card-title center-align actual_balance_font_bold">Total Receitas</span>
                   <p class="green-text center-align actual_balance_font">R$ 1500,00</p>
                  </div>
                </div>
              </div>
              <div class="col s10 m6 l6 ">
                <div class="card grey lighten-4">
                  <div class="card-content black-text">
                    <span class="card-title center-align actual_balance_font_bold">Total despesas</span>
                   <p class="red-text center-align actual_balance_font">R$ 500,00</p>
                  </div>
                </div>
              </div>
              <div class="col s10 m6 l12 ">
                <div class="card grey lighten-4">
                  <div class="card-content black-text">
                    <span class="card-title center-align actual_balance_font_bold">Balanço atual</span>
                   <p class="green-text center-align actual_balance_font">R$ 1000,00</p>
                  </div>
                </div>
              </div>

              <div class="col s10 m6 l12 ">
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

          const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto'],
                datasets: [{
                    label: 'Despesas',
                    data: [120.99, 659.99, 800, 5.99, 2999, 3.99, 5220],
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
                    data: [5000, 5000, 5000, 5000,5000,5000],
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
      </script>

@endsection
