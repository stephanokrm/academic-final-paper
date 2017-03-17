angular
        .module('academic')
        .controller('navController', [
            '$state',
            '$scope',
            '$location',
            '$rootScope',
            '$mdSidenav',
            'userService',
            'GoogleService',
            function ($state, $scope, $location, $rootScope, $mdSidenav, userService, GoogleService) {

                $scope.toggleLeft = buildToggler('left');
                $scope.goToActivities = goToActivities;
                $scope.goToTeams = goToTeams;

                $scope.doLogout = function () {
                    userService.logout();
                    $location.path('/login');
                };

                $scope.doGoogleLogout = function () {
                    GoogleService.logout().then(function () {
                        $rootScope.google_authenticated = false;
                        $state.go('home');
                    });
                };

                function buildToggler(componentId) {
                    return function () {
                        $mdSidenav(componentId).toggle();
                    };
                }
                
                function goToActivities(user) {
                    var user = userService.getCurrentUser();
                    $state.go('activitiesIndex', {id: user.student.team_id});
                }
                
                function goToTeams() {
                    $state.go('teamsIndex', {});
                }

            }]);
