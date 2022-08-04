@extends('layout')

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('content')
<div class="row main_cards">
                <div class="col s10 m6 l6 ">
                    <div class="card grey lighten-4">
                        <div class="card-content black-text ">
                            <span class="card-title center-align">Viagem Bahia</span>
                            <canvas id="myChart" width="200" height="100"></canvas>
                            <div class="center-align">
                                <a class="waves-effect red btn"><i class="material-icons right">delete</i>Deletar</a>
                                <a class="waves-effect orange btn"><i class="material-icons right">edit</i>Editar</a>
                                <a class="waves-effect blue darken-1 btn"><i class="material-icons right">visibility</i>Detalhes</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s10 m6 l6 ">
                    <div class="card grey lighten-4">
                        <div class="card-content black-text ">
                            <span class="card-title center-align">Notebook</span>
                            <canvas id="myChart2" width="200" height="100"></canvas>
                            <div class="center-align">
                                <a data-target="modalDelete" data-id="2" class="waves-effect red btn modal-trigger"><i class="material-icons right">delete</i>Deletar</a>
                                <a data-target="modalEdit"   data-id="2" class="waves-effect orange btn modal-trigger"><i class="material-icons right">edit</i>Editar</a>
                                <a data-target="modalDetail" data-id="2" class="waves-effect blue darken-1 btn modal-trigger"><i class="material-icons right">visibility</i>Detalhes</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Trigger -->

  <!-- Modal Structure -->
    <div id="modalDetail" class="modal">
      <div class="modal-content">
        <h4 id="nameModal">Notebook</h4>
        <div class="row">
            <div class="input-field col s6">
              <input value="" id="name" type="text" class="validate" disabled>
              <label class="active" for="name">Nome</label>
            </div>
            <div class="input-field col s6">
                <input value="" id="final_date" type="text" class="validate" disabled>
                <label class="active" for="final_date">Data final</label>
              </div>
              <div class="input-field col s6">
                <input value="" id="actual_balance" type="text" class="validate" disabled>
                <label class="active" for="actual_balance">Valor atual</label>
              </div>
              <div class="input-field col s6">
                <input value="" id="end_balance" type="text" class="validate" disabled>
                <label class="active" for="end_balance">Valor final</label>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect blue darken-1 btn">Fechar</a>
      </div>
    </div>

    <div id="modalEdit" class="modal">
        <div class="modal-content">
          <h4 id="nameModal">AAAA</h4>
          <div class="row">
              <div class="input-field col s6">
                <input value="" id="name" type="text" class="validate" disabled>
                <label class="active" for="name">Nome</label>
              </div>
              <div class="input-field col s6">
                  <input value="" id="final_date" type="text" class="validate" disabled>
                  <label class="active" for="final_date">Data final</label>
                </div>
                <div class="input-field col s6">
                  <input value="" id="actual_balance" type="text" class="validate" disabled>
                  <label class="active" for="actual_balance">Valor atual</label>
                </div>
                <div class="input-field col s6">
                  <input value="" id="end_balance" type="text" class="validate" disabled>
                  <label class="active" for="end_balance">Valor final</label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-close waves-effect blue darken-1 btn">Fechar</a>
        </div>
      </div>

      <div id="modalDelete" class="modal">
        <div class="modal-content">
          <h4 id="nameModal">Deletar?</h4>

        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect red darken-1 btn">Sim, deletar</a>
            <a href="#!" class="modal-close waves-effect blue darken-1 btn">Fechar</a>
        </div>
    <script>
        let goalsTab = document.getElementById("goals")
        goalsTab.classList.add("active");

        document.addEventListener('DOMContentLoaded', function() {
            let elems = document.querySelectorAll('.modal');
            let instances = M.Modal.init(elems, {});
      });

      $('.modal-trigger').click(function(e){
        let data_target =$(e.target).data('id');
        });


        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto'],
                datasets: [{
                    label: 'Valor Atual',
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
                    label: 'Valor Desejado',
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
    const ctx2 = document.getElementById('myChart2').getContext('2d');
        const myChart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto'],
                datasets: [{
                    label: 'Valor Atual',
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
                    label: 'Valor Desejado',
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
