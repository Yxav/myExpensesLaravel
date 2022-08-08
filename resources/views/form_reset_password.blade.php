
    @include('layout')
    <body>
        <div class="row form_login">
            <form class="col s12" method="POST">
                <meta name="csrf-token" content="<?php echo csrf_token(); ?>">
                <div class="row center-align ">
              <div class="row center-align ">
                <div class="col s12">
                  <div class="input-field inline">
                    <input id="password" name="password" type="password">
                    <label for="password">Senha</label>
                    @if ($errors->has('password'))
                        <span class="helper-text" data-error="wrong" data-success="right">{{ $errors->first('password') }}</span>
                    @endif
                  </div>
                </div>
                <div class="row center-align ">
                  <div class="col s12">
                    <div class="input-field inline">
                      <input id="confirm_password" name="confirm_password" type="password">
                      <label for="confirm_password">Confirmar senha</label>
                    </div>
                </div>
                <span id="messagePassword" ></span>
              </div>
                <div class="col-md-6 offset-md-4">
                    <button type="submit" id="registerButton" class="btn btn-primary">
                        Registrar
                    </button>
                </div>
                <span class="helper-text" id="errorBox" data-error="wrong" data-success="right"></span>
              </div>
            </form>
          </div>
    </body>
    <script>
        let token = "{{ request()->get('token') }}";

         jQuery(document).ready(function(){
            jQuery('#registerButton').click(function(e){
               e.preventDefault();
               if(!checkPassword() && !validateEmail()) return;
               $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
               jQuery.ajax({
                  url: "{{ url('/reset-password-processed') }}",
                  method: 'post',
                  data: {
                     password: jQuery('#password').val(),
                     token: token
                  },
                  success: function(result){
                    location.href = "/home"

                },
                error: function(error){
                    console.log(error)

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

            $("#confirm_password").on('keyup', function() {
                let password = $("#password").val();
                let confirmPassword = $("#confirm_password").val();
                if (password != confirmPassword){
                    $("#messagePassword").html("Senhas não conferem!").css("color", "red");
                    $("#password").addClass('invalid');
                    $("#confirm_password").addClass('invalid');
                }
                else{
                    $("#messagePassword").html("Senhas corretas !").css("color", "green");
                    $("#password").removeClass('invalid');
                    $("#confirm_password").removeClass('invalid');
                    $("#password").addClass('valid');
                    $("#confirm_password").addClass('valid');
                }
                if(confirmPassword.length < 6){
                    $("#messagePassword").html("Senha curta! São necessários, no mínimo, 6 caracteres").css("color", "red");
                    $("#password").removeClass('valid');
                    $("#confirm_password").removeClass('valid');
                    $("#password").addClass('invalid');
                    $("#confirm_password").addClass('invalid');
                }
            });

            function checkPassword(){
                let password = $("#password").val();
                let confirmPassword = $("#confirm_password").val();
                if (password != confirmPassword || confirmPassword.length < 6){
                    return false;
                }
                return true
            }
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
