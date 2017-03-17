(function () {
    'use strict';

    angular
            .module('academic')
            .controller('ActivityCreateController', ActivityCreateController);

    ActivityCreateController.$inject = ['$rootScope', '$state', '$stateParams', 'ActivityService', 'CalendarService'];
    function ActivityCreateController($rootScope, $state, $stateParams, ActivityService, CalendarService) {
        var vm = this;
        vm.activity = {team_id: $stateParams.id};
        vm.calendars = [];
        vm.colors = [
            {id: 10, background: {"background-color": "#51b749", "color": "white"}, name: "Exercício"},
            {id: 5, background: {"background-color": "#fbd75b", "color": "white"}, name: "Atividade avaliativa"},
            {id: 11, background: {"background-color": "#dc2127", "color": "white"}, name: "Prova"}
        ];
        vm.storeActivity = storeActivity;
        $rootScope.pageTitle = 'Nova Atividade';

        getCalendars();

        function getCalendars() {
            return CalendarService.getCalendars().then(function (calendars) {
                vm.calendars = calendars;
                return vm.calendars;
            });
        }

        function storeActivity() {
            return ActivityService.storeActivity(vm.activity).then(function () {
                $state.go('activitiesIndex', {id: vm.activity.team_id});
            });
        }
    }

})();