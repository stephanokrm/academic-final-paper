<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/bootstrap.js') }}" defer></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/controllers.js') }}" defer></script>
        <script src="{{ asset('js/services.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap">
        <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"/>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <meta name="theme-color" content="#03a9f4">
        <base href="/academic-final-paper/public">
        <link rel="manifest" href="{{ asset('manifest.json') }}">
    </head>
    <body ng-app="academic" ng-cloak layout="column">
    <md-toolbar class="md-primary md-whiteframe-2dp" ng-show="authenticated">
        <div class="md-toolbar-tools" ng-controller="navController">
            <md-button class="md-icon-button" aria-label="Settings" ng-click="toggleLeft()" hide-gt-xs>
                <md-icon class="material-icons">menu</md-icon>
            </md-button>
            <h2>Academic</h2>
            <span flex></span>
            <md-button hide-xs class="md-icon-button" aria-label="Início" ui-sref=".home">
                <md-icon class='material-icons'>home</md-icon>
                <md-tooltip md-direction="down">Início</md-tooltip>
            </md-button>
            <md-button hide-xs class="md-icon-button" aria-label="Calendários" ui-sref=".calendars">
                <md-icon class='material-icons'>event</md-icon>
                <md-tooltip md-direction="down">Calendários</md-tooltip>
            </md-button>
            <md-button hide-xs class="md-icon-button" aria-label="Atividades" ng-click="goToActivities()" ng-if="!isTeacher">
                <md-icon class='material-icons'>import_contacts</md-icon>
                <md-tooltip md-direction="down">Atividades</md-tooltip>
            </md-button>
            <md-button hide-xs class="md-icon-button" aria-label="Notas" ng-click="navigateTo('userGrades')" ng-if="!isTeacher">
                <md-icon class='material-icons'>timeline</md-icon>
                <md-tooltip md-direction="down">Notas</md-tooltip>
            </md-button>
            <md-button hide-xs class="md-icon-button" aria-label="Turmas" ng-click="goToTeams()" ng-if="isTeacher">
                <md-icon class='material-icons'>people_outline</md-icon>
                <md-tooltip md-direction="down">Turmas</md-tooltip>
            </md-button>
            <md-menu hide-xs class="md-menu-profile">
                <img alt="Foto" ng-src="@{{ user.google.profile_image }}" class="md-avatar md-toolbar-avatar"
                     ng-click="$mdOpenMenu($event)"/>
                <md-menu-content width="4" ng-controller="navController">
                    <md-menu-item>
                        <md-button>
                            <img alt="Foto" ng-src="@{{  user.google.profile_image }}"
                                 class="md-avatar md-toolbar-menu-avatar" ng-click="$mdOpenMenu($event)"/>
                            @{{ user.name }}
                        </md-button>
                    </md-menu-item>
                    <md-menu-item ng-hide="google_authenticated">
                        <md-button ng-href="@{{  googleUrl }}">
                            Entrar com Google
                        </md-button>
                    </md-menu-item>
                    <md-menu-item ng-show="google_authenticated">
                        <md-button ng-click="doGoogleLogout()">
                            Sair do Google
                        </md-button>
                    </md-menu-item>
                    <md-menu-item>
                        <md-button ng-click="doLogout()">
                            Sair
                        </md-button>
                    </md-menu-item>
                </md-menu-content>
            </md-menu>
        </div>
    </md-toolbar>
    <md-content flex>
        <div ui-view flex></div>
    </md-content>
    <md-sidenav class="md-sidenav-left" md-component-id="left" md-whiteframe="4" ng-cloak>
        <md-list ng-controller="navController">
            <md-list-item class="md-2-line">
                <img ng-src="@{{  user.google.profile_image }}" class="md-avatar"/>
                <div class="md-list-item-text">
                    <h3>@{{ user.name }}</h3>
                    <p>@{{ user.google.email }}</p>
                </div>
            </md-list-item>
            <md-list-item ng-show="google_not_authenticated" ng-href="@{{ googleUrl }}">
                <md-icon class='material-icons'>voicemail</md-icon>
                <p>Entrar com Google</p>
            </md-list-item>
            <md-list-item ng-show="google_authenticated" ng-click="doGoogleLogout()">
                <md-icon class='material-icons'>voicemail</md-icon>
                <p>Sair do Google</p>
            </md-list-item>
            <md-list-item ng-click="doLogout()">
                <md-icon class='material-icons'>clear</md-icon>
                <p>Sair</p>
            </md-list-item>
            <md-divider></md-divider>
            <md-list-item ui-sref=".home">
                <md-icon class='material-icons'>home</md-icon>
                <p>Início</p>
            </md-list-item>
            <md-list-item ng-if="isTeacher" ui-sref=".teamsIndex">
                <md-icon class='material-icons'>people_outline</md-icon>
                <p>Turmas</p>
            </md-list-item>
            <md-divider></md-divider>
            <md-list-item ui-sref=".calendars">
                <md-icon class='material-icons'>event</md-icon>
                <p>Calendários</p>
            </md-list-item>
            <md-divider></md-divider>
            <md-list-item ui-sref=".activitiesIndex">
                <md-icon class='material-icons'>import_contacts</md-icon>
                <p>Atividades</p>
            </md-list-item>
        </md-list>
    </md-sidenav>
</body>
</html>
