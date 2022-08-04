@extends('layout')

@section('sidebar')
    @include('partials.sidebar')
@endsection
@section('content')

<div class="row  main_cards">
            <div class="col s10 m6 l12 ">
                <div class="card grey lighten-4">
                <div class="card-content black-text">
                    <span class="card-title center-align actual_balance_font_bold">Total Despesas</span>
                    <p class="red-text center-align actual_balance_font">R$ 1500,00</p>
                </div>
                </div>
            </div>
            </div>
            <div class="right-align">
                <a data-target="modalCreate" class="waves-effect waves-light blue btn modal-trigger"><i class="material-icons left">add</i>Adicionar novo</a>
            </div>
            <ul class="collection">
                <li class="collection-item avatar">
                    <a href=""><i class="material-icons red circle">money_off</i></a>
                    <span class="title">Pagamento Fatura</span>
                    <p>R$ 89,90 <br>
                        28/05/2022
                    </p>
                    <a href="#!" data-id="1" data-target="modalUpdate" class="secondary-content editIcon modal-trigger"><i class="material-icons">edit</i></a>
                    <a href="#!" id="deleteIcon" data-target="modalDelete" class="secondary-content delete_icon red-text modal-trigger"><i class="material-icons">delete</i></a>
                </li>
                <li class="collection-item avatar">
                    <a href=""><i class="material-icons red circle">money_off</i></a>
                    <span class="title">Pagamento Fatura</span>
                    <p>R$ 89,90 <br>
                        28/05/2022
                    </p>
                    <a href="#!" data-id="2" data-target="modalUpdate" class="secondary-content editIcon modal-trigger"><i class="material-icons">edit</i></a>
                    <a href="#!" id="deleteIcon" data-target="modalDelete" class="secondary-content delete_icon red-text modal-trigger"><i class="material-icons">delete</i></a>
                </li>
            </ul>

        <div id="modalCreate" class="modal">
            <div class="modal-content">
                <h4 id="nameModal">Proventos</h4>
                <div class="row">
                <form id="addExpense">
                    <meta name="csrf-token" content="<?php echo csrf_token(); ?>">
                    <div class="input-field col s6">
                    <input type="hidden" name="id" id="id">
                    <input value="" id="short_name" type="text" class="validate">
                    <label class="active" for="short_name">Nome</label>
                    </div>
                    <div class="input-field col s6">
                        <input value="" id="date_operation" type="text" class="validate">
                        <label class="active" for="date_operation">Data</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="" id="amount" type="text" class="validate">
                        <label class="active" for="amount">Valor</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="" id="description" type="text" class="validate">
                        <label class="active" for="description">Descrição</label>
                    </div>
                    <div class="input-field col s12">
                        <div class="container">
                            <div id="drag_and_drop">
                              Drag and Drop Files Here
                            </div>
                            <input type="file" name="invoice" id="invoice">
                          </div>
                        <label class="active" for="invoice">Recibo</label>
                    </div>
                </form>

                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect red darken-1 btn">Fechar</a>
                <a href="#!" id="addButton" class="waves-effect blue darken-1 btn">Salvar</a>

            </div>
            </div>
        </div>
        <div id="modalUpdate" class="modal">
            <div class="modal-content">
              <h4 id="nameModal">Proventos</h4>
              <div class="row">

                    <div class="input-field col s6">
                        <input value="" id="name" type="text" class="validate">
                        <label class="active" for="name">Nome</label>
                    </div>
                    <div class="input-field col s6">
                        <input value="" id="date_operation" type="text" class="validate">
                        <label class="active" for="date_operation">Data</label>
                    </div>
                    <div class="input-field col s12">
                      <input value="" id="amount" type="text" class="validate">
                      <label class="active" for="amount">Valor</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="" id="end_balance" type="text" class="validate">
                        <label class="active" for="end_balance">Descrição</label>
                    </div>
                    <div class="input-field col s12">
                        <input value="" id="end_balance" type="file" class="validate">
                        <label class="active" for="end_balance">Descrição</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <a href="#!" class="modal-close waves-effect blue darken-1 btn">Fechar</a>
              <a href="#!" id="updateButton" class="waves-effect blue darken-1 btn">Atualizar</a>

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
        let expenseTab = document.getElementById("expenses")
        expenseTab.classList.add("active")
        document.addEventListener('DOMContentLoaded', function() {
            let elems = document.querySelectorAll('.modal');
            let instances = M.Modal.init(elems, {});
      });
      $(".editIcon").click(function(e){
        console.log($(this).attr("data-id"))
      })
      $('.modal-trigger').click(function(e){
        let data_target =$(e.target).data('id');
        });

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
            $.ajax({
                url: "{{ url('/expenses') }}",
                method: 'post',
                data: fd,
                contentType: false,
              processData: false,
                success: function(result){
                }
                });
        });


    </script>
@endsection
