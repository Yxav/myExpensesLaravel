@extends('layout')

@section('sidebar')
    @include('partials.sidebar')
@endsection
@section('content')

<div class="row  main_cards">
            <div class="col s12 m12 l12 ">
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
        <ul class="col s12 m12 l12">
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
    let expenseTab = document.getElementById("expenses")
    expenseTab.classList.add("active")

    let urlGetRegisters = "{{ url('json/expenses') }}";
    let urlGetTotalValue = "{{ url('total/expenses') }}";
    let idDivResult = "p#totalExpenses"

    fetchData()





    $('#dataTable').on('click', ".delete_icon", function() {
        deleteRecord(this, table, '{{ route("expenses.destroy", ":id") }}' )
    });



        $('#dataTable').on('click', ".editIcon", function() {
            openModalEdit(this, table, '{{ route("expenses.show", ":id") }}')
        });

        $('#dataTable').on('click', ".viewIcon", function() {
            openModalInvoice(this, table, 'despesa', "{{ Storage::url('expenses/') }}")
        });




    $('#addButton').click(function(e){
        e.preventDefault();

        if(validateForm()){
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
        }
    });


    function validateForm(){
            if(!validateNumberInput("amount")){
                $("#amount").addClass("invalid");
                M.toast({html: 'O campo valor deve ser numérico!', classes: 'red'});

                return false
            }
            return true
        }
    </script>
@endsection
