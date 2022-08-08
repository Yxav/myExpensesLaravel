
    @include('layout')
    <body>
        <div class="row form_login">
            <form class="col s12" method="POST">
                <meta name="csrf-token" content="<?php echo csrf_token(); ?>">

                <div class="row center-align ">
                  <p class="textResetPassword">Confirme seu email, vamos verificar no nosso sistema e você receberá um token no seu email cadastrado</p>
                <div class="col s12">
                  <div class="input-field inline">
                    <input id="email" name="email" type="email" class="validate">
                    <label for="email">Email</label>
                </div>
            </div>
            <span id="emailMessage"></span>

                <div class="col-md-6 offset-md-4 buttonReset">
                    <button type="submit" id="resetButton" class="btn btn-primary">
                        Redefinir senha
                    </button>
                </div>
                <a href="{{ route('login') }}">Já é registrado? Logue no sistema</a>
                <span class="helper-text" id="errorBox" data-error="wrong" data-success="right"></span>
              </div>
            </form>
          </div>
    </body>
    <script>
         jQuery(document).ready(function(){
            jQuery('#resetButton').click(function(e){
               e.preventDefault();
               if(!validateEmail()) return;
               $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
               jQuery.ajax({
                  url: "{{ url('/reset-password-submit') }}",
                  method: 'post',
                  data: {
                     email: jQuery('#email').val(),
                  },
                  success: function(result){
                    M.toast({html: 'Foi enviado um token para seu email, por favor verifique :) !', classes: 'green'});
                },
                error: function(error){
                    M.toast({html: 'Este email não está cadastrado na nossa base de dados :( !', classes: 'red'});
                }});
               });
            });

            $("#email").on('keyup', function(){
                if(!validateEmail()){
                    $("#emailMessage").html("Email inválido!").css("color", "red");
                    $("#email").addClass('invalid');
                }
                else{
                    $("#emailMessage").html("Email válido !").css("color", "green");
                    $("#email").removeClass('invalid');
                }
            })


            function validateEmail(){
            let email = $("#email").val();
            if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
                return false
            }
                return true
            }

            function emailAlreadyTaken(messageError){
                if(messageError.email[0] === 'The email has already been taken.'){
                        M.toast({html: 'Email já cadastrado!', classes: 'red'});
                        $("#emailMessage").html("Email já cadastrado!").css("color", "red");
                        $("#email").addClass('invalid');
                    }
            }

    </script>
