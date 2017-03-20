angular
    .module('academic')
    .constant('ROUTE', 'http://localhost:8000/')
    .config(['$stateProvider', '$urlRouterProvider', '$locationProvider', function ($stateProvider, $urlRouterProvider, $locationProvider) {
        $locationProvider.html5Mode(true);
        $urlRouterProvider.otherwise('/');
        $stateProvider.state('login', {
            url: '/login',
            templateUrl: 'views/user/userLogin.html',
            controller: 'LoginController as vm',
            authorize: false,
            authorize_google: false
        }).state('register', {
            url: '/registro',
            templateUrl: 'views/user/userRegister.html',
            controller: 'RegisterController as vm',
            authorize: true,
            authorize_google: false
        }).state('calendars', {
            url: '/calendarios',
            templateUrl: 'views/calendar/calendarIndex.html',
            controller: 'CalendarController as vm',
            authorize: true,
            authorize_google: true
        }).state('home', {
            url: '/',
            templateUrl: 'views/home.html',
            controller: 'HomeController as vm',
            authorize: true,
            authorize_google: false
        }).state('activitiesIndex', {
            url: '/turma/:id/atividades',
            templateUrl: 'views/activity/index.html',
            controller: 'ActivityIndexController as vm',
            authorize: true,
            authorize_google: true
        }).state('activitiesCreate', {
            url: '/turma/:id/atividades/criar',
            templateUrl: 'views/activity/create.html',
            controller: 'ActivityCreateController as vm',
            authorize: true,
            authorize_google: true
        }).state('activitiesEdit', {
            url: '/atividades/:id/editar',
            templateUrl: 'views/activity/edit.html',
            controller: 'ActivityEditController as vm',
            authorize: true,
            authorize_google: true
        }).state('activitiesShow', {
            url: '/atividades/:id/detalhes',
            templateUrl: 'views/activity/show.html',
            controller: 'ActivityShowController as vm',
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
    .run(["$rootScope", "$location", '$window', '$mdToast', 'UserService', 'GoogleService', 'localStorageService', function ($rootScope, $location, $window, $mdToast, UserService, GoogleService, localStorageService) {
        $rootScope.google_authenticated = GoogleService.checkIfIsLogged();
        $rootScope.googleUrl = GoogleService.getAuthUrl();
        $rootScope.$on("$stateChangeStart", function (e, toState) {
            $rootScope.authenticated = false;
            if (toState.authorize === true) {
                if (UserService.isLoggedIn()) {
                    $rootScope.isTeacher = UserService.isTeacher();
                    if (UserService.isActive()) {
                        $rootScope.authenticated = true;
                        $rootScope.user = UserService.getCurrentUser();
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