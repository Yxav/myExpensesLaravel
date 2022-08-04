
  <!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <title>My Expenses - Login</title>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
      <link rel="stylesheet" type="text/css" href="{{ url ('css/app.css')}}">

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body>

    <form action="{{ route('login.post') }}" method="POST">

@csrf

<div class="form-group row">

    <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

    <div class="col-md-6">

        <input type="text" id="email_address" class="form-control" name="email" required autofocus>

        @if ($errors->has('email'))

            <span class="text-danger">{{ $errors->first('email') }}</span>

        @endif

    </div>

</div>



<div class="form-group row">

    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

    <div class="col-md-6">

        <input type="password" id="password" class="form-control" name="password" required>

        @if ($errors->has('password'))

            <span class="text-danger">{{ $errors->first('password') }}</span>

        @endif

    </div>

</div>



<div class="form-group row">

    <div class="col-md-6 offset-md-4">

        <div class="checkbox">

            <label>

                <input type="checkbox" name="remember"> Remember Me

            </label>

        </div>

    </div>

</div>



<div class="col-md-6 offset-md-4">

    <button type="submit" class="btn btn-primary">

        Login

    </button>

</div>

</form>



      <!--JavaScript at end of body for optimized loading-->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

      <div class="col s12 m8 l9"> <!-- Note that "m8 l9" was added -->
                @yield('content')
            </div>
        </div>
    </body>
  </html>
