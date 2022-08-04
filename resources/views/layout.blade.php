
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
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body>

      <div class="navbar-fixed ">
        <nav>
          <div class="nav-wrapper blue darken-2 ">
            <a href="#!" class="brand-logo ">My Expenses</a>
            <ul class="right hide-on-med-and-down">
              <li><a href="#">Hello, {{ auth()->user()->name }}</a></li>
            </ul>
          </div>
        </nav>
      </div>

        <div class="row">
          <div class="col s12 m4 l3 sidebar_container"> <!-- Note that "m4 l3" was added -->
            <div>
              <ul id="slide-out" class="sidenav sidenav-fixed">
                <li>
                  <div class="user-view ">
                    <a href="#user"><img class="circle" src="800px-Amazing_Office.jpg"></a>
                    <a href="#name"><span class="black-text name">{{ auth()->user()->name }}</span></a>
                    <a href="#email"><span class="black-text email">{{ auth()->user()->email }}</span></a>
                </div>
                </li>
                <li id="home"><a href="{{ route('dashboard') }}"><i class="material-icons">home</i>Home</a></li>
                <li id="expenses"><a href="{{ route('expenses') }}"><i class="material-icons red-text">money_off</i>Expenses</a></li>
                <li id="incomes"><a href="{{ route('incomes') }}"><i class="material-icons green-text">attach_money</i>Incomes</a></li>
                <li id="goals"><a href="{{ route('goals') }}"><i class="material-icons orange-text">flag</i>Goals</a></li>

                <li><div class="divider"></div></li>
                <li><a class="waves-effect" href="{{ route('logout') }}"><i class="material-icons red-text">logout</i>Logout</a></li>
              </ul>
              <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            </div>

          </div>




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
