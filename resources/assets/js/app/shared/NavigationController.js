(function () {
    'use strict';

    angular
        .module('academic')
        .controller('navController', navController);

    navController.$inject = ['$state', '$scope', '$location', '$rootScope', '$mdSidenav', 'UserService', 'GoogleService'];
    function navController($state, $location, $rootScope, $mdSidenav, UserService, GoogleService) {
        let vm = this;
        vm.toggleLeft = buildToggler('left');
        vm.goToActivities = goToActivities;
        vm.goToTeams = goToTeams;
        vm.doLogout = doLogout;
        vm.doGoogleLogout = doGoogleLogout;

        function doGoogleLogout() {
            GoogleService.logout().then(() => {
                $rootScope.google_authenticated = false;
                $state.go('home');
            });
        }

        function doLogout() {
            UserService.logout();
            $location.path('/login');
        }

        function buildToggler(componentId) {
            return function () {
                $mdSidenav(componentId).toggle();
            };
        }

        function goToActivities() {
            let user = UserService.getCurrentUser();
            $state.go('activitiesIndex', {id: user.student.team_id});
        }

        function goToTeams() {
            $state.go('teamsIndex', {});
        }

        function navigateTo(state) {
            $state.go(state, {});
        }
    }

})();
