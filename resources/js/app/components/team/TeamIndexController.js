(function () {
    'use strict';

    angular
        .module('academic')
        .controller('TeamIndexController', TeamIndexController);

    TeamIndexController.$inject = ['$rootScope', '$state', 'TeamService'];
    function TeamIndexController($rootScope, $state, TeamService) {
        var vm = this;
        vm.teams = [];
        vm.showTeamActivities = showTeamActivities;
        $rootScope.pageTitle = 'Turmas';

        getTeams();

        function getTeams() {
            return TeamService.getAllFromTeacher(function (teams) {
                vm.teams = teams;
                return vm.teams;
            }, function () {
                alert('Error');
            });
        }

        function showTeamActivities(team) {
            $state.go('activitiesIndex', {id: team.id});
        }
    }

})();