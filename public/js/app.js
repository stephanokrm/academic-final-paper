angular.module('academic', [
    'ngMaterial',
    'ngMessages',
    'ngAnimate',
    'LocalStorageModule',
    'ui.utils.masks',
    'ui.router',
    'ui.calendar',
    'restangular',
    'angular-loading-bar'
]);
angular
    .module('academic')
    .constant('ROUTE', 'http://localhost:8000/')
    .config(['$stateProvider', '$urlRouterProvider', '$locationProvider', function ($stateProvider, $urlRouterProvider, $locationProvider) {
        $locationProvider.html5Mode(true);
        $urlRouterProvider.otherwise('/');
        $stateProvider.state('login', {
            url: '/login',
            templateUrl: 'views/user/userLogin.html',
            controller: 'LoginController',
            controllerAs: 'vm',
            authorize: false,
            authorize_google: false
        }).state('register', {
            url: '/registro',
            templateUrl: 'views/user/userRegister.html',
            controller: 'RegisterController',
            authorize: true,
            authorize_google: false
        }).state('calendars', {
            url: '/calendarios',
            templateUrl: 'views/calendar/calendarIndex.html',
            controller: 'CalendarController',
            controllerAs: 'vm',
            authorize: true,
            authorize_google: true
        }).state('home', {
            url: '/',
            templateUrl: 'views/home.html',
            controller: 'HomeController',
            authorize: true,
            authorize_google: false
        }).state('activitiesIndex', {
            url: '/turma/:id/atividades',
            templateUrl: 'views/activity/index.html',
            controller: 'ActivityIndexController',
            controllerAs: 'vm',
            authorize: true,
            authorize_google: true
        }).state('activitiesCreate', {
            url: '/turma/:id/atividades/criar',
            templateUrl: 'views/activity/create.html',
            controller: 'ActivityCreateController',
            controllerAs: 'vm',
            authorize: true,
            authorize_google: true
        }).state('activitiesEdit', {
            url: '/atividades/:id/editar',
            templateUrl: 'views/activity/edit.html',
            controller: 'ActivityEditController',
            controllerAs: 'vm',
            authorize: true,
            authorize_google: true
        }).state('activitiesShow', {
            url: '/atividades/:id/detalhes',
            templateUrl: 'views/activity/show.html',
            controller: 'ActivityShowController',
            controllerAs: 'vm',
            authorize: true,
            authorize_google: true
        }).state('teamsIndex', {
            url: '/turmas',
            templateUrl: 'views/team/index.html',
            controller: 'TeamIndexController as vm',
            authorize: true,
            authorize_google: false
        }).state('userGrades', {
            url: '/notas',
            templateUrl: 'views/user/userGrades.html',
            controller: 'GradesController as vm',
            authorize: true,
            authorize_google: true
        });
    }])
    .run(["$rootScope", "$location", '$window', '$mdToast', 'userService', 'GoogleService', 'localStorageService', function ($rootScope, $location, $window, $mdToast, userService, GoogleService, localStorageService) {
        $rootScope.google_authenticated = GoogleService.checkIfIsLogged();
        $rootScope.googleUrl = GoogleService.getAuthUrl();
        $rootScope.$on("$stateChangeStart", function (e, toState) {
            $rootScope.authenticated = false;
            if (toState.authorize === true) {
                if (userService.isLoggedIn()) {
                    $rootScope.isTeacher = userService.isTeacher();
                    if (userService.isActive()) {
                        $rootScope.authenticated = true;
                        $rootScope.user = userService.getCurrentUser();
                    } else {
                        $location.path("/registro");
                    }
                } else {
                    $location.path("/login");
                }
            }
            if (toState.authorize_google === true) {
                if (!GoogleService.checkIfIsLogged()) {
                    localStorageService.set('requestedUrl', toState.url);
                    e.preventDefault();
                    $window.location.href = GoogleService.getAuthUrl();
                }
            }
        });
    }]);
/* global NaN, moment */

angular
        .module('academic')
        .constant('DEFAULT_ERROR_MESSAGE', 'Algo deu errado. Verifique novamente mais tarde.');

angular
        .module('academic')
        .config(function ($mdThemingProvider) {
            $mdThemingProvider.theme('default')
                    .primaryPalette('light-blue', {
                        'default': '600'
                    })
                    .accentPalette('light-blue', {
                        'default': '700'
                    });
        });

angular
        .module('academic')
        .config(function ($mdDateLocaleProvider) {
            $mdDateLocaleProvider.months = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', ' Dezembro'];
            $mdDateLocaleProvider.shortMonths = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', ' Dez'];
            $mdDateLocaleProvider.days = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
            $mdDateLocaleProvider.shortDays = ['Do', 'Se', 'Te', 'Qu', 'Qu', 'Se', 'Sá'];
            $mdDateLocaleProvider.firstDayOfWeek = 1;

            $mdDateLocaleProvider.formatDate = function (date) {
                return date ? moment(date).format('DD/MM/YYYY') : '';
            };

            $mdDateLocaleProvider.parseDate = function (dateString) {
                var m = moment(dateString, 'DD/MM/YYYY', true);
                return m.isValid() ? m.toDate() : new Date(NaN);
            };
        });

angular.module('academic')
        .config(['cfpLoadingBarProvider', function (cfpLoadingBarProvider) {
                cfpLoadingBarProvider.includeSpinner = false;
            }]);



//# sourceMappingURL=app.js.map
