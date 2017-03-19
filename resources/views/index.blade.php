<html lang="pt-br">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
        <meta name="theme-color" content="#03a9f4"> 
        <title>Academic</title>
        <base href="/">
        <link rel="manifest" href="manifest.json">
        <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"/>
        <link type="text/css" rel="stylesheet" href="bower_components/angular-material/angular-material.min.css"/>
        <link type="text/css" rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.css"/>
        <link type="text/css" rel="stylesheet" href="css/app.css"/>
        <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
        <link type="text/css" rel="stylesheet" href="bower_components/angular-loading-bar/build/loading-bar.min.css"/>
        <link type="text/css" rel="stylesheet" href="bower_components/angular-material-data-table/dist/md-data-table.min.css"/>
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
                <img alt="Foto" ng-src="{{user.google.profile_image}}" class="md-avatar md-toolbar-avatar" ng-click="$mdOpenMenu($event)"/>
                <md-menu-content width="4" ng-controller="navController">
                    <md-menu-item>
                        <md-button>
                            <img alt="Foto" ng-src="{{user.google.profile_image}}" class="md-avatar md-toolbar-menu-avatar" ng-click="$mdOpenMenu($event)"/>
                            {{user.name}}
                        </md-button>
                    </md-menu-item>
                    <md-menu-item ng-hide="google_authenticated">
                        <md-button ng-href="{{googleUrl}}">
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
                <img ng-src="{{user.google.profile_image}}" class="md-avatar" />
                <div class="md-list-item-text">
                    <h3>{{user.name}}</h3>
                    <p>{{user.google.email}}</p>
                </div>
            </md-list-item>
            <md-list-item ng-show="google_not_authenticated" ng-href="{{googleUrl}}">
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
    <script type="text/javascript" src="bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="bower_components/moment/min/moment.min.js"></script>
    <script type="text/javascript" src="bower_components/angular/angular.min.js"></script>
    <script type="text/javascript" src="bower_components/lodash/dist/lodash.min.js"></script>
    <script type="text/javascript" src="bower_components/angular-ui-router/release/angular-ui-router.min.js"></script>
    <script type="text/javascript" src="bower_components/angular-local-storage/dist/angular-local-storage.min.js"></script>
    <script type="text/javascript" src="bower_components/restangular/dist/restangular.min.js"></script>
    <script type="text/javascript" src="bower_components/angular-animate/angular-animate.min.js"></script>
    <script type="text/javascript" src="bower_components/angular-aria/angular-aria.min.js"></script>
    <script type="text/javascript" src="bower_components/angular-messages/angular-messages.min.js"></script>
    <script type="text/javascript" src="bower_components/angular-material/angular-material.min.js"></script>
    <script type='text/javascript' src='bower_components/angular-loading-bar/build/loading-bar.min.js'></script>
    <script type="text/javascript" src="bower_components/angular-input-masks/angular-input-masks-standalone.min.js"></script>
    <script type="text/javascript" src="bower_components/angular-ui-calendar/src/calendar.js"></script>
    <script type="text/javascript" src="bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
    <script type="text/javascript" src="bower_components/fullcalendar/dist/lang-all.js"></script>
    <script type="text/javascript" src="bower_components/angular-material-data-table/dist/md-data-table.min.js"></script>
    <script type="text/javascript" src="js/laroute.js"></script>
    <script type="text/javascript" src="js/app.js"></script>
    <script type="text/javascript" src="js/controllers.js"></script>
    <script type="text/javascript" src="js/services.js"></script>
    <script type="text/javascript" src="js/directives.js"></script>
</body>
</html>