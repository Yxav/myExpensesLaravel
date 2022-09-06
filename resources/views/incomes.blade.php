@extends('layout')
@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('content')
    <div class="row  main_cards">
        <div class="col s12 m12 l12 ">
            <div class="card grey lighten-4">
                <div class="card-content black-text">
                <span class="card-title center-align actual_balance_font_bold">Total Receitas (Mês corrente)</span>
                <p id="totalValue" class="green-text center-align actual_balance_font"></p>
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
    </div>

    <div id="modalCreate" class="modal">
        <div class="modal-content">
            <h4 id="nameModal">Insira os dados da receita</h4>
            <div class="row">
                <form id="addRegister">
                    <meta name="csrf-token" content="<?php echo csrf_token(); ?>">
                    <div class="input-field col s6">
                    <input type="hidden" name="id" id="id">
                    <input placeholder=" " value="" id="short_name" type="text" class="validate">
                    <label for="short_name">Nome</label>
                    </div>
                    <div class="input-field col s6">
                        <input placeholder=" " value="" id="date_operation" type="text" class="datepicker">
                        <label for="date_operation">Data</label>
                    </div>
                    <div class="input-field col s12">
                        <input placeholder=" " value="" id="amount" type="text" class="validate">
                        <label for="amount">Valor</label>
                    </div>
                    <div class="input-field col s12">
                        <input placeholder=" " value="" id="description" type="text" class="validate">
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

    <div id="modalView" class="modal">
        <div class="modal-content">
            <img id="invoicePicture" src="" alt="">
        </div>
        <div class="modal-footer">
            <a href="javascript:void(0)" class="modal-close waves-effect red darken-1 btn">Fechar</a>
        </div>
    </div>
    <script>

        let incomesTab = document.getElementById("incomes")
        incomesTab.classList.add("active")

        let urlGetRegisters = "{{ url('json/incomes') }}";
        let urlGetTotalValue = "{{ url('total/incomes') }}";
        let urlRegister = "{{ url('/incomes') }}";
        let urlUpdateRegister = "{{ url('/incomes/update') }}";
        let urlDeleteRegister = "{{ route('incomes.destroy', ':id') }}";
        let urlShowRegister = "{{ route('incomes.show', ':id') }}";
        let urlGetInvoice = "{{ Storage::url('incomes/') }}";
        let idDivResult = "p#totalValue";
        let typeRegister = "Receita";

        fetchData();


    </script>
@endsection
