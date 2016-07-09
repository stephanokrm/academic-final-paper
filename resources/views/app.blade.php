<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0""/>
        <title>Academic - @yield('title')</title>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="{{ asset('/materialize/css/materialize.min.css') }}" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="{{ asset('/font-awesome/css/font-awesome.min.css') }}" media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('/css/style.css') }}" rel="stylesheet">
    </head>
    <body>
        @if (Session::has('user'))
        <ul id='user-dropdown' class='dropdown-content'>
            <li><a href="#!"><i class="material-icons left">portrait</i> Perfil</a></li>
            @if(Session::has('credentials'))
            <li><a href="{{ route('google.logout') }}"><i class="material-icons left">open_in_new</i> Sair do Google</a></li>
            @else
            <li><a href="{{ Session::get('authUrl') }}"><i class="material-icons left">open_in_new</i> Entrar no Google</a></li>
            @endif
            <li class="divider"></li>
            <li><a href="{{ route('auth.logout') }}"><i class="material-icons left">clear</i> Sair</a></li>
        </ul>
        <div class="navbar-fixed">
            <nav class="light-blue">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div class="nav-wrapper">
                                <a href="{{ route('home.index') }}" class="brand-logo"><i class="fa fa-graduation-cap" aria-hidden="true"></i> Academic</a>
                                <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                                <ul class="right hide-on-med-and-down">
                                    <li><a href="{{ route('calendars.index') }}">Calendários</a></li>
                                    <li><a class='dropdown-button' href='#' data-activates='user-dropdown'>{{ Session::get('user')->nome_completo }}<i class="material-icons right">arrow_drop_down</i></a></li>
                                </ul>
                                <ul class="side-nav" id="mobile-demo">
                                    <li><a href="#!">{{ Session::get('user')->nome_completo }}</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#!"><i class="material-icons left">portrait</i> Perfil</a></li>
                                    @if(Session::has('credentials'))
                                    <li><a href="{{ route('google.logout') }}"><i class="material-icons left">open_in_new</i> Sair do Google</a></li>
                                    @else
                                    <li><a href="{{ Session::get('authUrl') }}"><i class="material-icons left">open_in_new</i> Entrar no Google</a></li>
                                    @endif
                                    <li><a href="sass.html"><i class="material-icons left">event_note</i> Calendário</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        @yield('breadcrumb')
        @endif
        <div class="container-fluid">
            <div class="row">
                @yield('content')
            </div>
        </div>
        <script src="{{ asset('/js/jquery-3.0.0.min.js') }}"></script>
        <script src="{{ asset('/materialize/js/materialize.min.js') }}"></script>
        <script src="{{ asset('/js/main.js') }}"></script>
        <script src="{{ asset('/js/jquery.mask.min.js') }}"></script>
    </body>
</html>
