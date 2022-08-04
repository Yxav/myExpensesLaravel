<!DOCTYPE html>
<html>

<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <title>My Expenses</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="{{ url ('css/app.css')}}">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>

    <div class="navbar-fixed ">
        <nav>
            <div class="nav-wrapper blue darken-2 ">
                <a href="#!" class="brand-logo ">My Expenses</a>
                <ul class="right hide-on-med-and-down">
                    @auth
                        <li><a href="#">Hello, {{ auth()->user()->name }}</a></li>
                    @endauth
                    @guest
                        <li><a href="{{ route('register') }}">Registrar</a></li>
                    @endguest
                </ul>
            </div>
        </nav>
    </div>

 @yield('sidebar')

        <!--JavaScript at end of body for optimized loading-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
            integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"
            integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <div class="col s12 m8 l9">
            <!-- Note that "m8 l9" was added -->
            @yield('content')
        </div>
    </div>
</body>

</html>
