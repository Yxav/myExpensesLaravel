@extends('layout')
@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('content')
    <div class="row  main_cards">
        <div class="col s10 m6 l12 ">
            <div class="card grey lighten-4">
                <div class="card-content black-text">
                <span class="card-title center-align actual_balance_font_bold">Total Receitas (Mês corrente)</span>
                <p class="green-text center-align actual_balance_font">R$ {{ number_format($total, 2, ',', '.')  }}</p>
                </div>
            </div>
            </div>
        </div>
        <div class="right-align">
            <a data-target="modalCreate" id="newButton" class="waves-effect waves-light blue btn modal-trigger"><i class="material-icons left">add</i>Adicionar novo</a>
        </div>
        <ul class="collection">
            @foreach ($incomes as $income)
                <li class="collection-item avatar">
                    <a href=""><i class="material-icons green circle">savings</i></a>
                    <span class="title">{{ $income->short_name }} </span>
                    <p>
                        <span class="green-text"> R$ {{ number_format($income->amount, 2, ',', '.')  }} </span> <br>
                        {{ \Carbon\Carbon::parse($income->date_operation)->format('d/m/Y')}}
                    </p>
                    @if($income->file_path)
                            <img id="invoice{{ $income->id }}" style="display: none;" src="{{ Storage::url('incomes/' .$income->file_path) }}" alt="" title=""></a>
                        @endif

                    <a href="javascript:void(0)" data-id="{{ $income->id }}" class="secondary-content viewIcon"><i class="material-icons">visibility</i></a>
                    <a href="javascript:void(0)" data-id="{{ $income->id }}" data-target="modalCreate" class="secondary-content editIcon modal-trigger"><i class="material-icons">edit</i></a>
                    <a href="javascript:void(0)" data-id= "{{ $income->id }}" class="secondary-content delete_icon red-text"><i class="material-icons">delete</i></a>
                </li>
            @endforeach
        </ul>
    </div>

    <div id="modalCreate" class="modal">
        <div class="modal-content">
            <h4 id="nameModal">Insira os dados da receita</h4>
            <div class="row">
                <form id="addIncome">
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
                            Drag and Drop Files Here
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

        $(document).ready(function(){
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd'
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

        $(".editIcon").click(function(e){
            let id = $(this).attr("data-id");
            let url = '{{ route("incomes.show", ":id") }}';
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

        $(".delete_icon").click(function(e){
            let id = $(this).attr("data-id");
            let url = '{{ route("incomes.destroy", ":id") }}';
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


        $('#addButton').click(function(e){
            e.preventDefault();
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
                    url: "{{ url('/incomes/update') }}",
                    method: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(result){
                        location.reload()
                    }});}
            else {
                $.ajax({
                    url: "{{ url('/incomes') }}",
                    method: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(result){
                        location.reload()
                }});
            }
         });

        $("#newButton").click(function(){
            $("#addIncome").trigger("reset")
            $("#id").trigger('reset')
        })

    </script>
@endsection
