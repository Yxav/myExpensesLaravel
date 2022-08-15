@extends('layout')

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('content')
    <div class="row main_cards">
        <div class="main_cards" id="cards">

        </div>



        <div class="fixed-action-btn">
            <a data-target="modalCreate" class="btn-floating btn-large blue modal-trigger" id="newButton">
                <i class="large material-icons">add</i>
            </a>

        </div>


    </div>
      <!-- Modal Structure -->
    <div id="modalDetail" class="modal">
      <div class="modal-content">
        <h4 id="name_modal_detail"></h4>
        <div class="row">
            <div class="input-field col s6">
                <input placeholder=" " value="" id="short_name_detail" type="text" class="validate" disabled>
                <label class="active" for="short_name_detail">Nome</label>
            </div>
            <div class="input-field col s6">
                <input placeholder=" " value="" id="date_operation_detail" type="text" class="datepicker" disabled>
                <label class="active" for="date_operation_detail">Data final</label>
              </div>
              <div class="input-field col s6">
                  <input placeholder=" " value="" id="amount_detail" type="text" class="validate" disabled>
                  <label class="active" for="amount_detail">Valor final</label>
              </div>
              <div class="input-field col s6">
                  <input placeholder=" " value="" id="balance_now_detail" type="text" class="validate" disabled>
                  <label class="active" for="balance_now_detail">Valor atual</label>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <a href="javascript:void(0)" class="modal-close waves-effect blue darken-1 btn">Fechar</a>
      </div>
    </div>

    <div id="modalCreate" class="modal">
        <div class="modal-content">
          <h4 id="nameModal">Insira os dados do objetivo</h4>
          <div class="row">
          <form id="addRegister">
                <meta name="csrf-token" content="<?php echo csrf_token(); ?>">
                <div class="input-field col s6">
                <input type="hidden" name="id" id="idGoal">
                <label for="short_name">Nome</label>
                <input value="" id="short_name" type="text" class="validate">
                </div>
                <div class="input-field col s6">
                    <label for="date_operation">Data</label>
                    <input value="" id="date_operation" type="text" class="datepicker">
                </div>
                <div class="input-field col s12">
                    <label for="amount">Valor final</label>
                    <input value="" id="amount" type="text" class="validate">
                </div>
                <div class="input-field col s12">
                    <label for="balance_now">Valor atual</label>
                    <input value="" id="balance_now" type="text" class="validate">
                </div>
        </form>
            </div>
        </div>
        <div class="modal-footer">
            <a href="javascript:void(0)" class="modal-close waves-effect red darken-1 btn">Fechar</a>
            <a href="javascript:void(0)" id="addButtonGoal" class="waves-effect blue darken-1 btn">Salvar</a>
        </div>
    </div>

    <div id="modalDeposit" class="modal">
        <div class="modal-content">
          <h4 id="nameModal">Insira o valor do depósito</h4>
          <div class="row">
          <form id="addRegister">
                <meta name="csrf-token" content="<?php echo csrf_token(); ?>">
                <div class="input-field col s12">
                    <input value="" type="hidden" name="id" id="idGoalDeposit">
                    <label for="amount">Valor depósito</label>
                    <input value="" id="deposit" type="text" class="validate">
                </div>
        </form>
            </div>
        </div>
        <div class="modal-footer">
            <a href="javascript:void(0)" class="modal-close waves-effect red darken-1 btn">Fechar</a>
            <a href="javascript:void(0)" id="addButtonDeposit" class="waves-effect green darken-1 btn">Depositar</a>
        </div>
    </div>

    <script>
        let goalsTab = document.getElementById("goals")
        goalsTab.classList.add("active");

        document.addEventListener('DOMContentLoaded', function() {
            let elems = document.querySelectorAll('.modal');
            let instances = M.Modal.init(elems, {});
        });

       $(document).on("click", ".editIcon", function(e){
        let id = $(this).attr("data-id");
        let url = '{{ route("goals.show", ":id") }}';
        url = url.replace(':id', id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            method: 'get',
            success: function(result){
                let data = JSON.parse(result)[0]
                $("#short_name").val(data.short_name);
                $("#date_operation").val(data.date_operation);
                $("#amount").val(data.amount);
                $("#balance_now").val(data.actual_balance);
                $("#idGoal").val(data.id);
            }
            });
        })

        $(document).on("click", ".detailIcon", function(e){
            let id = $(this).attr("data-id");
            let url = '{{ route("goals.show", ":id") }}';
            url = url.replace(':id', id);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'get',
                success: function(result){
                    let data = JSON.parse(result)[0]
                    $("#name_modal_detail").text(data.short_name);
                    $("#short_name_detail").val(data.short_name);
                    $("#date_operation_detail").val(data.date_operation);
                    $("#amount_detail").val(data.amount);
                    $("#balance_now_detail").val(data.actual_balance);
                }
                });
        })

        $(document).on("click", ".delete_icon_goal", function(e){
            let id = $(this).attr("data-id");
            let url = '{{ route("goals.destroy", ":id") }}';
            url = url.replace(':id', id);
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });
            $.ajax({
                url: url,
                method: 'get',
                success: function(result){
                    M.toast({html: 'Objetivo exclúido com sucesso!', classes: 'green'});
                    clearGraphs(canvasIds)
                    $('#cards').empty();
                    fetchGoals()
                }
            });
        })

        $(document).on("click", ".depositIcon", function(e){
            $("#deposit").val("")
            let id = $(this).attr("data-id");
            console.log(id)
            $("#idGoalDeposit").val(id)

        })

        let canvasIds = [];
        let dataGoals = [];

        fetchGoals();

        function fetchGoals(){
            getDataFromServer();
            setTimeout(()=>{
                displayCards(dataGoals);
                generateCharts(dataGoals)
            } , 1000)
        }

        function getDataFromServer(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ route("goals.json") }}',
                method: 'get',
                success: function(result){
                    let data = JSON.parse(result)
                    dataGoals = data
                }
            });
        }

        function displayCards(data){
            data.forEach(goal => {
                $("#cards").append(
                    "<div class='col s10 m12 l6'>" +
                        "<div class='card grey lighten-4'>" +
                            "<div class='card-content black-text'> " +
                                "<span class='card-title center-align'>" + goal.short_name + "</span> " +
                                "<canvas id='myChart" + goal.id + "' width='200' height='100'></canvas>" +
                                "<div class='action_buttons'>" +
                                    "<a data-id='" + goal.id + "' class='waves-effect delete_icon_goal red btn'><i class='material-icons right'>delete</i>Deletar</a>" +
                                    "<a data-target='modalCreate' data-id='" + goal.id + "' class='waves-effect editIcon orange btn modal-trigger'><i class='material-icons right'>edit</i>Editar</a>" +
                                    "<a data-target='modalDetail' data-id='" + goal.id + "' class='waves-effect detailIcon blue darken-1 btn modal-trigger'><i class='material-icons right'>visibility</i>Detalhes</a>"+
                                    "<a data-target='modalDeposit' data-id='" + goal.id + "' class='waves-effect depositIcon green darken-1 btn modal-trigger'><i class='material-icons right'>money</i>Depositar</a>"+
                                "</div>" +
                            "</div>" +
                        "</div>" +
                    "</div>"
                )
            });
        }


    function generateCharts(data){
        data.map(goal => {
            let ctx = {}
            ctx['ctx' + goal.id] = document.getElementById('myChart'+goal.id).getContext('2d');
            let canvaGraph = new Chart(ctx['ctx' + goal.id], {
                type: 'bar',
                redraw: true,
                data: {
                    labels: ['Montante'],
                    datasets: [{
                        label: 'Valor Atual',
                        data: [goal.actual_balance],
                        backgroundColor: [
                            'rgba(60,179,113, 0.5)',
                        ],
                        borderColor: [
                            'rgba(60,179,113, 0.5)',

                        ],
                        borderWidth: 1
                    },
                    {
                        label: 'Valor Esperado',
                        data: [goal.amount],
                        backgroundColor: [
                            'rgba(3, 120, 255, 0.8)'
                        ],
                        borderColor: [
                            'rgba(3, 120, 255, 0.8)'

                        ],
                        borderWidth: 1
                    }
                ]
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
            canvasIds.push(canvaGraph)
    })

    }

    function clearGraphs(charts){
         charts.map(chart => chart.destroy());
    }



    $('#addButtonGoal').click(function(e){
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let data = {
            short_name: $('#short_name').val(),
            date_operation: $('#date_operation').val(),
            amount: $('#amount').val(),
            actual_balance: $('#balance_now').val(),
        };
        if($("#idGoal").val() != ""){
            data.id = $('#idGoal').val();
            $.ajax({
                url: "{{ url('/goals/update') }}",
                method: 'post',
                data: data,
                success: function(result){
                }});}
                else {
                    $.ajax({
                        url: "{{ url('/goals') }}",
                        method: 'post',
                        data: data,
                        success: function(result){
                            M.toast({html: 'Objetivo atualizado com sucesso!', classes: 'green'});

                        }});
                    }
                    let modal = document.getElementById("modalCreate");
                    let instance = M.Modal.getInstance(modal);
                    instance.close();
                    clearGraphs(canvasIds)
                    $('#cards').empty();
                    fetchGoals()

    });

    $('#addButtonDeposit').click(function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let data = {
            deposit: $('#deposit').val(),
            id: $("#idGoalDeposit").val()
        };
        $.ajax({
            url: "{{ url('/goals/update') }}",
            method: 'post',
            data: data,
            success: function(result){
                M.toast({html: 'Depositado com sucesso!', classes: 'green'});

            }});

            let modal = document.getElementById("modalDeposit");
            let instance = M.Modal.getInstance(modal);
            instance.close();
            clearGraphs(canvasIds)
            $('#cards').empty();
            fetchGoals()

    });
        </script>

@endsection
