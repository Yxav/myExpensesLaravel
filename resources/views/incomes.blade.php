@extends('layout')

@section('content')
<div class="row  main_cards">
              <div class="col s10 m6 l12 ">
                <div class="card grey lighten-4">
                  <div class="card-content black-text">
                    <span class="card-title center-align actual_balance_font_bold">Total Receitas</span>
                   <p class="green-text center-align actual_balance_font">R$ 1500,00</p>
                  </div>
                </div>
              </div>
            </div>
            <ul class="collection">
                <li class="collection-item avatar">
                    <a href=""><i class="material-icons green circle">savings</i></a>
                    <span class="title">Proventos </span>
                    <p> <span class="green-text"> R$ 9,90 </span> <br>
                        28/05/2022
                    </p>
                    <a href="#!" class="secondary-content"><i class="material-icons">edit</i></a>
                    <a href="#!" class="secondary-content delete_icon red-text"><i class="material-icons">delete</i></a>

                </li>
                <li class="collection-item avatar">
                    <a href=""><i class="material-icons green circle">attach_money</i></a>
                    <span class="title">Salário </span>
                    <p><span class="green-text"> R$ 99999,90 </span> <br>
                        28/05/2022
                    </p>
                    <a href="#!" data-target="modalUpdate" class="secondary-content modal-trigger"><i class="material-icons">edit</i></a>
                    <a href="#!" data-target="modalDelete" class="secondary-content delete_icon red-text modal-trigger"><i class="material-icons">delete</i></a>
                </li>
            </ul>
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
        let incomesTab = document.getElementById("incomes")
        incomesTab.classList.add("active")
        document.addEventListener('DOMContentLoaded', function() {
            let elems = document.querySelectorAll('.modal');
            let instances = M.Modal.init(elems, {});
      });

      $('.modal-trigger').click(function(e){
        let data_target =$(e.target).data('id');
        });
    </script>

@endsection
