<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0""/>
        <title>Academic - @yield('title')</title>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="{{ asset('/materialize/css/materialize.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    </head>
    <body>
        @if (Session::has('user'))
        <ul id='user-dropdown' class='dropdown-content'>
            <li><a href="#!">one</a></li>
            <li><a href="#!">two</a></li>
            <li class="divider"></li>
            <li><a href="{{ route('auth.logout') }}"><i class="material-icons left">clear</i> Sair</a></li>
        </ul>
        <div class="navbar-fixed">
            <nav>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div class="nav-wrapper">
                                <a href="{{ route('home.index') }}" class="brand-logo">Academic</a>
                                <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                                <ul class="right hide-on-med-and-down">
                                    <li><a href="sass.html">Sass</a></li>
                                    <li><a href="badges.html">Components</a></li>
                                    <li><a href="collapsible.html">Javascript</a></li>
                                    <li><a class='dropdown-button' href='#' data-activates='user-dropdown'>{{ Session::get('user')->nome_completo }}<i class="material-icons right">arrow_drop_down</i></a></li>
                                </ul>
                                <ul class="side-nav" id="mobile-demo">
                                    <li><a href="sass.html">Sass</a></li>
                                    <li><a href="badges.html">Components</a></li>
                                    <li><a href="collapsible.html">Javascript</a></li>
                                    <li><a href="mobile.html">Mobile</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
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
