<header class="main-header">

    <a href="{{URL::to('/')}}" class="logo">
        <span class="logo-mini">
            <img src="{{asset('images/logotatical.png')}}" alt="Tatical Monitoramento" style="max-height: 500px; max-width: 33px">
        </span>

        <span class="logo-lg">
            <img src="{{asset('images/logotatical.png')}}" alt="Tatical Monitoramento" style="max-height: 500px; max-width: 33px">
        </span>
    </a>


    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle fa fa-bars" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div style="    margin-left: 50px; position: absolute; margin-top: 15px;">
            <p>{{config('app.name')}}</p>
        </div>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <li class="dropdown user user-menu">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class=""><i class="fa fa-user"></i></span>
                    </a>
                    <div class="dropdown-menu">
                        <div class="col-md-12">
                            <b>{{strtoupper(auth()->user()->name)}} <i class="fa fa-user"></i></b>
                        </div>
                        <div class="col-md-12">
                            <a href="{{URL::to('/')}}/password">Alterar Senha <i class="fas fa-cog"></i></a>
                        </div>
                        <div class="col-md-12">
                            <a href="{{URL::to('/')}}/logout"> Sair <i class="fas fa-sign-out-alt"></i></a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>