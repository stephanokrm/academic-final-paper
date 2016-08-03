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
        @if(Session::has('user') && !isset($showNav))
        <header>
            <div class="navbar-fixed main-navbar">
                <nav class="light-blue">
                    <div class="nav-wrapper">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <a href="#" data-activates="slide-out" class="button-collapse">
                                        <i class="material-icons menu-navbar-button left">menu</i>
                                        <span class="academic-navbar left">Academic</span><i class="material-icons left icon-nav">chevron_right</i><span class="no-bold right page-title">@yield('title')</span>
                                    </a>
                                    <ul class="right hide-on-med-and-down">
                                        <li><a href="{{ URL::current() }}"><i class="material-icons">refresh</i></a></li>
                                        <li><a><i class="material-icons">notifications</i></a></li>
                                        <li><a class="profile-img"><img class="circle" src="{{ asset(Session::get('user')->google->profile_image) }}"></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="navbar-fixed second-navbar hide">
                <nav class="light-blue lighten-5">
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
            </div>
            <ul id="slide-out" class="side-nav">
                <li class="close-sidenav"><a href="#!" class="close-sidenav"><i class="material-icons close-sidenav">arrow_back</i>Fechar</a></li>
                <li>
                    <div class="userView">
                        <img class="background" src="{{ asset('/images/office.jpg') }}">
                        <a href="#!user"><img class="circle" src="{{ asset(Session::get('user')->google->profile_image) }}"></a>
                        <a href="#!name"><span class="white-text name">{{ Session::get('user')->name }}</span></a>
                        <a href="#!email"><span class="white-text email">{{ Session::get('user')->google->email }}</span></a>
                    </div>
                </li>
                <li><a href="{{ route('home.index') }}"><i class="material-icons">home</i>Início</a></li>
                <li><div class="divider"></div></li>
                @if(Session::get('user')->hasRole(2)) 
                <li><a><i class="material-icons">group</i>Turmas</a></li>
                @else
                <li><a href="{{ route('activities.index', Session::get('user')->getTeamFromUser()) }}"><i class="material-icons">import_contacts</i>Atividades</a></li>
                @endif
                <li><a href="{{ route('calendars.index') }}"><i class="material-icons">event_note</i>Calendários</a></li>
                <li><div class="divider"></div></li>
                @if(Session::has('credentials'))
                <li><a href="{{ route('google.logout') }}"><i class="material-icons">open_in_new</i>Sair do Google</a></li>
                @else
                <li><a href="{{ Session::get('authUrl') }}"><i class="material-icons">open_in_new</i>Entrar no Google</a></li>
                @endif
                <li><a href="{{ route('auth.logout') }}"><i class="material-icons">clear</i>Sair</a></li>
            </ul>
        </header>

        @endif
        @if(Session::has('message'))
        <div id="message" data-message="{{ Session::get('message') }}"></div>
        @endif
        <main>
            <div class="container-fluid">
                <div class="row">
                    @yield('content')
                </div>
            </div>
        </main>
        <script src="{{ asset('/js/jquery-3.1.0.min.js') }}"></script>
        <script src="{{ asset('/materialize/js/materialize.min.js') }}"></script>
        <script src="{{ asset('/js/main.js') }}"></script>
        <script src="{{ asset('/js/jquery.mask.min.js') }}"></script>

        @yield('js')
    </body>
</html>
