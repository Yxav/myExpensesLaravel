
    @include('layout')
    <body>
        <div class="row form_login">
            <form class="col s12" method="POST">
                <meta name="csrf-token" content="<?php echo csrf_token(); ?>">

              <div class="row center-align ">
                <div class="col s12">
                  <div class="input-field inline">
                    <input id="email" name="email" type="email" class="validate">
                    <label for="email">Email</label>
                    @if ($errors->has('email'))
                        <span class="helper-text" data-error="wrong" data-success="right">{{ $errors->first('email') }}</span>
                    @endif
                  </div>
                </div>
              </div>
              <div class="row center-align ">
                <div class="col s12">
                  <div class="input-field inline">
                    <input id="password" name="password" type="password" class="validate">
                    <label for="password">Senha</label>
                    @if ($errors->has('password'))
                        <span class="helper-text" data-error="wrong" data-success="right">{{ $errors->first('password') }}</span>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 offset-md-4">
                    <button type="submit" id="loginButton" class="btn btn-primary">
                        Login
                    </button>
                </div>
              </div>
            </form>
          </div>
    </body>
    <script>
         jQuery(document).ready(function(){
            jQuery('#loginButton').click(function(e){
               e.preventDefault();
               $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
               jQuery.ajax({
                  url: "{{ url('/post-login') }}",
                  method: 'post',
                  data: {
                     email: jQuery('#email').val(),
                     password: jQuery('#password').val(),
                  },
                  success: function(result){
                    window.location.href = "/"
                },
                error: function(error){
                    M.toast({html: 'Falha no login, verifique suas credenciais!', classes: 'red'});
                }
                });
               });
            });
    </script>
