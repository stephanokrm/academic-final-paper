<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
        <meta name="csrf-token" content="{{ csrf_token()}}"/>
        <title>Academic - @yield('title')</title>
        <link rel="icon" href="{{ asset('/images/academic-logo.ico') }}">
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('/materialize/css/materialize.min.css')}}"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('/font-awesome/css/font-awesome.min.css')}}" media="screen"/>
        @yield('css')
        <link type="text/css" rel="stylesheet" property="" href="{{ asset('/css/style.css')}}"/>
    </head>
    <body>
        @if(Session::has('user') && !isset($showNav))
        <ul id='user-options' class='dropdown-content'>
            <li><a href="#!"><i class="material-icons left">perm_identity</i>Perfil</a></li>
            @if(Session::has('credentials'))
            <li><a href="{{ route('google.logout')}}"><i class="material-icons left">open_in_new</i>Sair do Google</a></li>
            @else
            <li><a href="{{ Session::get('authUrl') }}"><i class="material-icons left">input</i>Entrar no Google</a></li>
            @endif
            <li><a href="{{ route('auth.logout')}}"><i class="material-icons left">clear</i>Sair</a></li>
        </ul>
        <ul id="activity-options" class="dropdown-content">
            <li><a href="#!"><i class="material-icons left">assignment</i>Tarefas</a></li>
            <li><a href="#!"><i class="material-icons left">class</i>Avaliações</a></li>
            <li><a href="#!"><i class="material-icons left">import_contacts</i>Todas atividades</a></li>
        </ul>
        <ul id="menu-options" class="dropdown-content">
            <li><a href="{{ route('home.index')}}"><i class="material-icons left">home</i>Início</a></li>
            @if(Session::get('user')->isTeacher()) 
            <li><a href="{{ route('teams.index')}}"><i class="material-icons left">people_outline</i>Turmas</a></li>
            @else
            <li><a href="#!"><i class="material-icons left">people_outline</i>Turma</a></li>
            <li><a href="#!"><i class="material-icons left">school</i>Professores</a></li>
            @endif
        </ul>
        <header>
            <div class="navbar-fixed main-navbar">
                <nav class="light-blue">
                    <div class="nav-wrapper container-fluid">
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <a href="{{ route('home.index')}}" class="brand-logo">
                                    <span class="academic-navbar left">Academic</span><i class="material-icons left icon-nav">chevron_right</i><span class="no-bold right page-title">@yield('title')</span>
                                </a>
                                <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                                <ul class="right hide-on-med-and-down">
                                    <li><a data-constrainwidth="false" data-alignment="right" class="dropdown-button" href="#!" data-activates="menu-options">Menu<i class="material-icons right">arrow_drop_down</i></a></li>
                                    <li><a data-constrainwidth="false" data-alignment="right" class="dropdown-button" href="#!" data-activates="activity-options">Atividades<i class="material-icons right">arrow_drop_down</i></a></li>
                                    <li><a href="{{ route('calendars.index', Session::get('user')->getTeamFromUser()) }}">Calendários</a></li>
                                    <li class="waves-effect waves-light"><a><i class="material-icons">notifications</i></a></li>
                                    <li><a data-constrainwidth="false" data-alignment="right" class="dropdown-button profile-img" data-activates='user-options'><img alt="Imagem de Perfil" class="circle left" src="{{ asset(Session::get('user')->google->profile_image) }}"><i class="material-icons right">arrow_drop_down</i><span class="right user-name">{{ Session::get('user')->name }}</span></a></li>
                                </ul>
                                <ul class="side-nav" id="mobile-demo">
                                    <li>
                                        <div class="userView">
                                            <img alt="Imagem de Capa" class="background" src="{{ asset('/images/office.jpg')}}">
                                            <a><img alt="Imagem de Perfil" class="circle" src="{{ asset(Session::get('user')->google->profile_image) }}"></a>
                                            <a><span class="white-text name">{{ Session::get('user')->name }}</span></a>
                                            <a><span class="white-text email">{{ Session::get('user')->google->email }}</span></a>
                                        </div>
                                    </li>
                                    <li><a href="{{ route('home.index')}}">Início</a></li>
                                    @if(Session::get('user')->isTeacher()) 
                                    <li><a href="{{ route('teams.index')}}">Turmas</a></li>
                                    @else
                                    <li><a href="#!">Turma</a></li>
                                    <li><a href="#!">Professores</a></li>
                                    @endif
                                    <li><div class="divider"></div></li>
                                    <li><a href="#!">Tarefas</a></li>
                                    <li><a href="#!">Avaliações</a></li>
                                    <li><a href="#!">Todas atividades</a></li>
                                    <li><div class="divider"></div></li>
                                    <li><a href="{{ route('calendars.index', Session::get('user')->getTeamFromUser()) }}">Calendários</a></li>
                                    <li><div class="divider"></div></li>
                                    <li><a>Notificações</a></li>
                                    <li><div class="divider"></div></li>
                                    <li><a href="#!">Perfil</a></li>
                                    @if(Session::has('credentials'))
                                    <li><a href="{{ route('google.logout')}}">Sair do Google</a></li>
                                    @else
                                    <li><a href="{{ Session::get('authUrl') }}">Entrar no Google</a></li>
                                    @endif
                                    <li><a href="{{ route('auth.logout')}}">Sair</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="progress hide">
                        <div class="indeterminate"></div>
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
                    <div class="progress hide">
                        <div class="indeterminate"></div>
                    </div>
                </nav>
            </div>
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

        <script type="text/javascript" src="{{ asset('/js/jquery-3.1.0.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('/materialize/js/materialize.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('/js/main.js')}}"></script>
        <script type="text/javascript" src="{{ asset('/js/jquery.mask.min.js')}}"></script>
        @yield('js')
    </body>
</html>
