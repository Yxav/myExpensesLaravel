@extends('layout')

@section('sidebar')
    @include('partials.sidebar')
@endsection
@section('content')

<div class="row  main_cards">
            <div class="col s10 m6 l12 ">
                <div class="card grey lighten-4">
                <div class="card-content black-text">
                    <span class="card-title center-align actual_balance_font_bold">Total Despesas (Mês corrente)</span>
                    <p class="red-text center-align actual_balance_font">R$ {{ number_format($total, 2, ',', '.')  }}</p>
                </div>
                </div>
            </div>
            </div>
            <div class="right-align">
                <a id="newButton" data-target="modalCreate" class="waves-effect waves-light blue btn modal-trigger"><i class="material-icons left">add</i>Adicionar novo</a>
            </div>
            <ul class="collection">
                @foreach ($expenses as $expense)
                    <li class="collection-item avatar">
                        <a href=""><i class="material-icons red circle">money_off</i></a>
                        <span class="title">{{ $expense->short_name }}</span>
                        <p>
                        <span class="red-text"> R$ {{ number_format($expense->amount, 2, ',', '.')  }}</span> <br>
                            {{ \Carbon\Carbon::parse($expense->date_operation)->format('d/m/Y')}}

                        </p>
                        @if($expense->file_path)
                            <img id="invoice{{ $expense->id }}" style="display: none;" src="{{ Storage::url('expenses/' .$expense->file_path) }}" alt="" title=""></a>
                        @endif

                        <a href="javascript:void(0)" data-id="{{ $expense->id }}" class="secondary-content viewIcon"><i class="material-icons">visibility</i></a>
                        <a href="javascript:void(0)" data-id="{{ $expense->id }}" data-target="modalCreate" class="secondary-content editIcon modal-trigger"><i class="material-icons">edit</i></a>
                        <a href="javascript:void(0)" data-id= "{{ $expense->id }}" class="secondary-content delete_icon red-text"><i class="material-icons">delete</i></a>
                    </li>
                @endforeach
            </ul>

        <div id="modalCreate" class="modal">
            <div class="modal-content">
                <h4 id="nameModal">Insira os dados da despesa</h4>
                <div class="row">
                    <form id="addExpense">
                        <meta name="csrf-token" content="<?php echo csrf_token(); ?>">
                        <div class="input-field col s6">
                        <input type="hidden" name="id" id="id">
                        <input value="" id="short_name" type="text" class="validate">
                        <label for="short_name">Nome</label>
                        </div>
                        <div class="input-field col s6">
                            <input value="" id="date_operation" type="text" class="datepicker">
                            <label for="date_operation">Data</label>
                        </div>
                        <div class="input-field col s12">
                            <input value="" id="amount" type="text" class="validate">
                            <label for="amount">Valor</label>
                        </div>
                        <div class="input-field col s12">
                            <input value="" id="description" type="text" class="validate">
                            <label for="description">Descrição</label>
                        </div>
                        <div class="input-field col s12">
                            <div class="container">
                                <div id="drag_and_drop">
                                Arraste seu arquivo aqui
                                </div>
                                <input type="file" name="invoice" id="invoice">
                            </div>
                            <label for="invoice">Recibo</label>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0)" class="modal-close waves-effect red darken-1 btn">Fechar</a>
                <a href="javascript:void(0)" id="addButton" class="waves-effect blue darken-1 btn">Salvar</a>
            </div>
        </div>

        <div id="modalInvoice" class="modal">
            <div class="modal-content">
                <div class="row">

                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0)" class="modal-close waves-effect red darken-1 btn">Fechar</a>
                <a href="javascript:void(0)" id="addButton" class="waves-effect blue darken-1 btn">Salvar</a>
            </div>
        </div>
    </div>


<script>
    let expenseTab = document.getElementById("expenses")
    expenseTab.classList.add("active")

    document.addEventListener('DOMContentLoaded', function() {
        let elems = document.querySelectorAll('.modal');
        let instances = M.Modal.init(elems, {});
      });

    $(document).ready(function(){
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
    });


    $("#newButton").click(function(){
        $("#addExpense").trigger("reset")
        $("#id").trigger('reset')
    })

    $(".editIcon").click(function(e){
        let id = $(this).attr("data-id");
        let url = '{{ route("expenses.show", ":id") }}';
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
                $("#description").val(data.description);
                $("#id").val(data.id);
            }
        });
      })


      let clicked = false;
      $(".viewIcon").click(function(e){
        let id = "invoice" + $(this).attr("data-id");
        let invoice = document.getElementById(id);

        if(!invoice){
            M.toast({html: 'Esta despesa não possui comprovante!', classes: 'red'});
            return
        }
        if(clicked){
            invoice.style.display = "none "
            clicked = false
        } else {
            invoice.style.display = "flex"
            clicked = true;

        }
      })

    $(".delete_icon").click(function(e){
        let id = $(this).attr("data-id");
        let url = '{{ route("expenses.destroy", ":id") }}';
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

    $(document).ready(function () {
        $("html").on("dragover", function (e) {
            e.preventDefault();
            e.stopPropagation();
        });

        $("html").on("drop", function (e) {
            e.preventDefault();
            e.stopPropagation();
        });

        $('#drag_and_drop').on('dragover', function () {
            $(this).addClass('drag_over');
            return false;
        });

        $('#drag_and_drop').on('dragleave', function () {
            $(this).removeClass('drag_over');
            return false;
        });

        $('#drag_and_drop').on('drop', function (e) {
            e.preventDefault();
            let fileInput = document.querySelector('input[type="file"]');
            $(this).removeClass('drag_over');
                var formData = new FormData();
                var files = e.originalEvent.dataTransfer.files;
                const dT = new DataTransfer();
                dT.items.add(files[0]);
                fileInput.files = dT.files;
            });
        })

    $('#addButton').click(function(e){
        e.preventDefault();
        let expenseId;
        var fd = new FormData();
        var files = $('#invoice')[0].files[0];

        fd.append('file',files);
        fd.append('short_name', $('#short_name').val());
        fd.append('date_operation', $('#date_operation').val());
        fd.append('amount', $('#amount').val());
        fd.append('description', $('#description').val());

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        if($("#id").val()){
            fd.append('id', $('#id').val());
            $.ajax({
                url: "{{ url('/expenses/update') }}",
                method: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(result){
                    location.reload()
                }});}
        else {
            $.ajax({
                url: "{{ url('/expenses') }}",
                method: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(result){
                    location.reload()
                }});}
    });
    </script>
@endsection
