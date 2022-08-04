<div class="row">
    <div class="col s12 m4 l3 sidebar_container">
        <!-- Note that "m4 l3" was added -->
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
                <li id="expenses"><a href="{{ route('expenses') }}"><i
                            class="material-icons red-text">money_off</i>Despesas</a></li>
                <li id="incomes"><a href="{{ route('incomes') }}"><i
                            class="material-icons green-text">attach_money</i>Entradas</a></li>
                <li id="goals"><a href="{{ route('goals') }}"><i
                            class="material-icons orange-text">flag</i>Objetivos</a></li>

                <li>
                    <div class="divider"></div>
                </li>
                <li><a class="waves-effect" href="{{ route('logout') }}"><i
                            class="material-icons red-text">logout</i>Logout</a></li>
            </ul>
            <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        </div>

    </div>
