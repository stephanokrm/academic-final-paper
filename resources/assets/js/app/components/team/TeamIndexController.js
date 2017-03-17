(function () {
    'use strict';

    angular
            .module('academic')
            .controller('TeamIndexController', TeamIndexController);

    TeamIndexController.$inject = ['$rootScope', '$state', 'teamService'];
    function TeamIndexController($rootScope, $state, teamService) {
        var vm = this;
        vm.teams = [];
        vm.showTeamActivities = showTeamActivities;
        $rootScope.pageTitle = 'Turmas';

        getTeams();

        function getTeams() {
            return teamService.getAllFromTeacher(function (teams) {
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