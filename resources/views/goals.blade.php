@extends('layout')

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('content')
    <div class="row main_cards">
        @foreach($goals as $goal)
            <div class="col s10 m6 l6 ">
                    <div class="card grey lighten-4">
                        <div class="card-content black-text ">
                            <span class="card-title center-align">{{ $goal->short_name }}</span>
                            <canvas id="myChart{{$goal->id}}" width="200" height="100"></canvas>
                            <div class="center-align">
                                <a data-id="{{ $goal->id }}" class="waves-effect delete_icon_goal red btn"><i class="material-icons right">delete</i>Deletar</a>
                                <a data-target="modalCreate" data-id="{{ $goal->id }}" class="waves-effect editIcon orange btn modal-trigger"><i class="material-icons right">edit</i>Editar</a>
                                <a data-target="modalDetail" data-id="{{ $goal->id }}" class="waves-effect detailIcon blue darken-1 btn modal-trigger"><i class="material-icons right">visibility</i>Detalhes</a>
                            </div>
                        </div>
                    </div>
                </div>
        @endforeach



        <div class="fixed-action-btn">
            <a data-target="modalCreate" class="btn-floating btn-large blue modal-trigger" id="newButton">
                <i class="large material-icons">add</i>
            </a>

        </div>


    </div>
      <!-- Modal Structure -->
    <div id="modalDetail" class="modal">
      <div class="modal-content">
        <h4 id="name_modal_detail">Notebook</h4>
        <div class="row">
            <div class="input-field col s6">
              <label class="active" for="short_name_detail">Nome</label>
              <input value="" id="short_name_detail" type="text" class="validate" disabled>
            </div>
            <div class="input-field col s6">
                <label class="active" for="date_operation_detail">Data final</label>
                <input value="" id="date_operation_detail" type="text" class="datepicker" disabled>
              </div>
              <div class="input-field col s6">
                <label class="active" for="amount_detail">Valor final</label>
                <input value="" id="amount_detail" type="text" class="validate" disabled>
              </div>
              <div class="input-field col s6">
                <label class="active" for="balance_now_detail">Valor atual</label>
                <input value="" id="balance_now_detail" type="text" class="validate" disabled>
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
          <form id="addGoal">
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
            <a href="javascript:void(0)" id="addButton" class="waves-effect blue darken-1 btn">Salvar</a>
        </div>
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

        $(document).ready(function(){
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
        });

        $("#newButton").click(function(){
            $("#idGoal").val(null)
            $("#addGoal").trigger("reset")
        })

        $(".editIcon").click(function(e){
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

        $(".detailIcon").click(function(e){
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
                    $("#short_name_detail").val(data.short_name);
                    $("#date_operation_detail").val(data.date_operation);
                    $("#amount_detail").val(data.amount);
                    $("#balance_now_detail").val(data.actual_balance);
                }
                });
        })

        $(".delete_icon_goal").click(function(e){
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
                    alert("Deletado com sucesso")
                    location.reload()
                }
            });
        })

        generateCharts()
        function generateCharts(){
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
                    let ctx = {}
                    data.forEach(goal => {
                        ctx['ctx' + goal.id] = document.getElementById('myChart'+goal.id).getContext('2d');
                            new Chart(ctx['ctx' + goal.id], {
                                type: 'bar',
                                data: {
                                    labels: ['Montante'],
                                    datasets: [{
                                        label: 'Valor Atual',
                                        data: [goal.actual_balance],
                                        backgroundColor: [
                                            'rgba(60,179,113, 0.5)',
                                            // 'rgba(3, 120, 255, 0.8)'
                                        ],
                                        borderColor: [
                                            'rgba(60,179,113, 0.5)',
                                            // 'rgba(3, 120, 255, 0.8)'

                                        ],
                                        borderWidth: 1
                                    },
                                    {
                                        label: 'Valor Esperado',
                                        data: [goal.amount],
                                        backgroundColor: [
                                            // 'rgba(60,179,113, 0.5)',
                                            'rgba(3, 120, 255, 0.8)'
                                        ],
                                        borderColor: [
                                            // 'rgba(60,179,113, 0.5)',
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

                    });
                }
            });
        }





    $('#addButton').click(function(e){
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
                    location.reload()
                }});}
        else {
            $.ajax({
                url: "{{ url('/goals') }}",
                method: 'post',
                data: data,
                success: function(result){
                    location.reload()
                }});}
    });
        </script>

@endsection
