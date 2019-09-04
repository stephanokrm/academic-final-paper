(function () {
    'use strict';

    angular
        .module('academic')
        .controller('ActivityEditController', ActivityEditController);

    ActivityEditController.$inject = ['$rootScope', '$state', '$stateParams', 'ActivityService', 'CalendarService'];
    function ActivityEditController($rootScope, $state, $stateParams, ActivityService, CalendarService) {
        var vm = this;
        vm.activity = {};
        vm.calendars = [];
        vm.colors = [
            {id: 10, background: {"background-color": "#51b749", "color": "white"}, name: "Exercício"},
            {id: 5, background: {"background-color": "#fbd75b", "color": "white"}, name: "Atividade avaliativa"},
            {id: 11, background: {"background-color": "#dc2127", "color": "white"}, name: "Prova"}
        ];
        vm.updateActivity = updateActivity;
        $rootScope.pageTitle = 'Editar Atividade';

        getCalendars();
        getActivity();

        function getCalendars() {
            return CalendarService.getCalendars().then(function (calendars) {
                vm.calendars = calendars;
                return vm.calendars;
            });
        }

        function getActivity() {
            return ActivityService.getActivity($stateParams.id).then(function (data) {
                vm.activity.id = data.activity.id;
                vm.activity.calendar = data.activity.event.calendar.calendar;
                vm.activity.summary = data.event.summary;
                vm.activity.weight = data.activity.weight;
                vm.activity.total_score = data.activity.total_score;
                vm.activity.date = new Date(data.date);
                vm.activity.description = data.event.description;
                vm.activity.color = data.event.colorId;
                return vm.activity;
            });
        }

        function updateActivity() {
            return ActivityService.updateActivity(vm.activity).then(function () {
                $state.go('activitiesIndex');
            });
        }
    }

})();