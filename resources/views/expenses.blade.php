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
                    <p id="totalExpenses" class="red-text center-align actual_balance_font"></p>
                </div>
                </div>
            </div>
            </div>
            <div class="controlButtonsTable">
            <div class="filterDates">
                <div class="input-field col s6">
                    <input value="" id="start_date" type="text" class="datepicker">
                    <label for="start_date">Data Inicial</label>
                </div>
                <div class="input-field col s6">
                    <input value="" id="final_date" type="text" class="datepicker">
                    <label for="final_date">Data Final</label>
                </div>
                <a id="filterButton" class="waves-effect waves-light "><i class="material-icons left">search</i></a>
                <a id="resetFilterButton" class="waves-effect waves-light "><i class="material-icons left">refresh</i></a>
            </div>

            <a data-target="modalCreate" id="newButton" class="waves-effect waves-light blue btn modal-trigger"><i class="material-icons left">add</i>Adicionar novo</a>
        </div>
        <ul class="col s10 m6 l12">
            <table id="dataTable" class="display">
            </table>
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
    <div id="modalView" class="modal">
        <div class="modal-content">
            <img id="invoicePicture" src="" alt="">
        </div>
        <div class="modal-footer">
            <a href="javascript:void(0)" class="modal-close waves-effect red darken-1 btn">Fechar</a>
            <a href="javascript:void(0)" id="addButton" class="waves-effect blue darken-1 btn">Salvar</a>
        </div>
    </div>


<script>
    fetchData();
    var storagePath = "{!! storage_path() !!}";
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

    function dataTableGenerate(result){
        table = $('#dataTable').DataTable({
            data: result,
            paging: true,
            bDestroy: true,
            columns: [
                {data: 'id'},
                {data: 'short_name'},
                {
                    data: 'date_operation',
                    render: function(data, type, row, meta) {
                        data = new Date(row.date_operation);
                        return data.toLocaleDateString('pt-BR', {timeZone: 'UTC'});
                    }

                },
                {data: 'amount'},
                {
                data: null,
                className: "dt-center editor-edit",
                defaultContent: '<i class="fa fa-pencil"/>',
                orderable: false
            },
            {
                data: null,
                defaultContent: '<a href="javascript:void(0)" data-target="modalCreate" class="secondary-content editIcon modal-trigger"><i class="material-icons">edit</i></a>',
                orderable: false
            },
            {
                data: null,
                defaultContent: '<a href="javascript:void(0)" class="secondary-content delete_icon red-text"><i class="material-icons">delete</i></a>',
                orderable: false
            },
            {
                data: null,
                defaultContent: '<a href="javascript:void(0)" class="secondary-content viewIcon"><i class="material-icons">visibility</i></a>',
                orderable: false
            }
            ],
            dom: "<'row'<'col s12 m6 l12'l><'col-sm-12 col-md-4'B><'col s12 m6 l12'f>><'row'<'col s12 l12'tr>><'row'<'col s12 m12 l12'i><'col s12 m12 l12 center'p>>",
            buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
        });
    }

    function fetchData(start_date, final_date){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('json/expenses') }}",
            method: 'get',
            dataType: 'json',
            data:{
                start_date: start_date,
                final_date: final_date,
            },
            success: function(result){
                dataTableGenerate(result)
            }
        });

        $.ajax({
            url: "{{ url('total/expenses') }}",
            method: 'get',
            dataType: 'json',
            success: function(result){
                $("p#totalExpenses").text("R$ " + result.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,"))
            }
        });
    }

    $(document).on("click", "#filterButton", function(e){
            e.preventDefault();
            let start_date= $("#start_date").val();
            let final_date= $("#final_date").val();
            if(start_date == "" || final_date == ""){
                M.toast({html: 'Preencha os dois campos de data, por favor!', classes: 'red'});
                return
            }
            $('#dataTable').DataTable().destroy();
            fetchData(start_date, final_date);
        })
        $(document).on("click", "#resetFilterButton", function(e){
            e.preventDefault();
            let start_date= $("#start_date").val('');
            let final_date= $("#final_date").val('');
            $('#dataTable').DataTable().destroy();
            fetchData();
        })

        $('#dataTable').on('click', ".editIcon", function() {
            var row = $(this).parents('tr')[0];
            let id = table.row(row).data().id;
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
        });

        $('#dataTable').on('click', ".delete_icon", function() {
            var row = $(this).parents('tr')[0];
            let id = table.row(row).data().id;
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
                    M.toast({html: 'Despesa exclúida com sucesso!', classes: 'green'});
                    fetchData();
                }
            });
        });

        $('#dataTable').on('click', ".viewIcon", function() {
            var row = $(this).parents('tr')[0];
            let filePath = table.row(row).data().file_path;

            if(!filePath){
                M.toast({html: 'Esta receita não possui comprovante!', classes: 'red'});
                return
            }

            let modal = document.getElementById("modalView");
            let instance = M.Modal.getInstance(modal);
            instance.open();

            $("#invoicePicture").attr("src", "{{ Storage::url('expenses/') }}" + filePath);
        });


    $("#newButton").click(function(){
        $("#addExpense").trigger("reset")
        $("#id").trigger('reset')
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
                    fetchData();
                }});}
        else {
            $.ajax({
                url: "{{ url('/expenses') }}",
                method: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(result){
                    fetchData();
                }});}
        let modal = document.getElementById("modalCreate");
        let instance = M.Modal.getInstance(modal);
        instance.close();
    });
    </script>
@endsection
