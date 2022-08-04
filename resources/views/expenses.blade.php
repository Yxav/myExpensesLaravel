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
                    <a href="#!" class="secondary-content"><i class="material-icons">edit</i></a>
                    <a href="#!" class="secondary-content delete_icon red-text"><i class="material-icons">delete</i></a>

                </li>
                <li class="collection-item avatar">
                    <a href=""><i class="material-icons red circle">money_off</i></a>
                    <span class="title">Pagamento Fatura</span>
                    <p>R$ 89,90 <br>
                        28/05/2022
                    </p>
                    <a href="#!" class="secondary-content"><i class="material-icons">edit</i></a>
                    <a href="#!" class="secondary-content delete_icon red-text"><i class="material-icons">delete</i></a>

                </li>
                <li class="collection-item avatar">
                    <a href=""><i class="material-icons red circle">money_off</i></a>
                    <span class="title">Pagamento Fatura</span>
                    <p>R$ 89,90 <br>
                        28/05/2022
                    </p>
                    <a href="#!" data-target="modalUpdate" class="secondary-content modal-trigger"><i class="material-icons">edit</i></a>
                    <a href="#!" data-target="modalDelete" class="secondary-content delete_icon red-text modal-trigger"><i class="material-icons">delete</i></a>

                </li>

            </ul>

        <div id="modalCreate" class="modal">
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
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect blue darken-1 btn">Fechar</a>
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
                      <input value="" id="final_date" type="text" class="validate">
                      <label class="active" for="final_date">Data</label>
                    </div>
                    <div class="input-field col s12">
                      <input value="" id="end_balance" type="text" class="validate">
                      <label class="active" for="end_balance">Valor</label>
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
        let expenseTab = document.getElementById("expenses")
        expenseTab.classList.add("active")
        document.addEventListener('DOMContentLoaded', function() {
            let elems = document.querySelectorAll('.modal');
            let instances = M.Modal.init(elems, {});
      });

      $('.modal-trigger').click(function(e){
        let data_target =$(e.target).data('id');
        });
    </script>
@endsection
