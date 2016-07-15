<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0""/>
        <title>Academic - @yield('title')</title>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="{{ asset('/materialize/css/materialize.min.css') }}">
        <link type="text/css" rel="stylesheet" href="{{ asset('/font-awesome/css/font-awesome.min.css') }}" media="screen,projection"/>
        @yield('css')
        <link type="text/css" rel="stylesheet" href="{{ asset('/css/style.css') }}">
    </head>
    <body>
        @if (Session::has('user') && !isset($showNav))
        <ul id='user-dropdown' class='dropdown-content navbar-dropdown'>
            <li><a href="{{ route('users.show', Session::get('user')->id) }}"><i class="material-icons left">portrait</i> Perfil</a></li>
            @if(Session::has('credentials'))
            <li><a href="{{ route('google.logout') }}"><i class="material-icons left">open_in_new</i> Sair do Google</a></li>
            @endif
            <li class="divider"></li>
            <li><a href="{{ route('auth.logout') }}"><i class="material-icons left">clear</i> Sair</a></li>
        </ul>
        <div class="navbar-fixed main-navbar">
            <nav class="light-blue">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div class="nav-wrapper">
                                <a href="{{ route('home.index') }}" class="brand-logo"><i class="fa fa-graduation-cap" aria-hidden="true"></i> Academic</a>
                                <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                                <ul class="right hide-on-med-and-down">
                                    <li><a href="{{ route('home.index') }}">Início</a></li>
                                    <li><a href="{{ route('calendars.index') }}">Calendários</a></li>
                                    @if(!Session::has('credentials'))
                                    <li><a href="{{ Session::get('authUrl') }}">Entrar no Google</a></li>
                                    @endif
                                    <li><a class='dropdown-button' href='#' data-activates='user-dropdown'>{{ Session::get('user')->name }}<i class="material-icons right">arrow_drop_down</i></a></li>
                                </ul>
                                <ul class="side-nav" id="mobile-demo">
                                    <li><a href="#!">{{ Session::get('user')->name }}</a></li>
                                    <li class="divider"></li>
                                    <li><a href="{{ route('home.index') }}"><i class="material-icons left">home</i> Início</a></li>
                                    <li><a href="{{ route('users.show', Session::get('user')->id) }}"><i class="material-icons left">portrait</i> Perfil</a></li>
                                    @if(Session::has('credentials'))
                                    <li><a href="{{ route('google.logout') }}"><i class="material-icons left">open_in_new</i> Sair do Google</a></li>
                                    @else
                                    <li><a href="{{ Session::get('authUrl') }}"><i class="material-icons left">open_in_new</i> Entrar no Google</a></li>
                                    @endif
                                    <li><a href="{{ route('calendars.index') }}"><i class="material-icons left">event_note</i> Calendário</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <nav class="second-navbar light-blue lighten-5 hide">
            <div class="nav-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col s12 m8 offset-m2 l8 offset-l2">
                            <div class="count left black-text"></div>
                            <div class="delete right">
                                <a href="#" class="delete-action">
                                    <i class="material-icons black-text">delete</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        @yield('breadcrumb')
        @endif
        @if(Session::has('message'))
        <div id="message" data-message="{{ Session::get('message') }}"></div>
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

        @yield('js')
    </body>
</html>
