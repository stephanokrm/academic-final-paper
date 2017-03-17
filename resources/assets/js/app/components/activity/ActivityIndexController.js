(function () {
    'use strict';

    angular
            .module('academic')
            .controller('ActivityIndexController', ActivityIndexController);

    ActivityIndexController.$inject = ['$rootScope', '$state', '$stateParams', '$mdDialog', 'ActivityService', 'userService'];
    function ActivityIndexController($rootScope, $state, $stateParams, $mdDialog, ActivityService, userService) {
        var vm = this;
        vm.activities = [];
        vm.isTeacher = false;
        vm.createActivity = createActivity;
        vm.editActivity = editActivity;
        vm.removeActivity = removeActivity;
        vm.showActivity = showActivity;
        $rootScope.pageTitle = 'Atividades';

        isTeacher();
        getActivities();

        function getActivities() {
            return ActivityService.getActivities($stateParams.id)
                    .then(function (activities) {
                        vm.activities = activities;
                        return vm.activities;
                    });
        }

        function createActivity() {
            $state.go('activitiesCreate', {id: $stateParams.id});
        }

        function editActivity(activity) {
            $state.go('activitiesEdit', {id: activity.activity.id});
        }

        function removeActivity(activity) {
            var confirm = $mdDialog.confirm()
                    .title('Gostaria de excluir essa atividade?')
                    .ok('Excluir')
                    .cancel('Cancelar');

            $mdDialog.show(confirm).then(function () {
                ActivityService.removeActivity(activity).then(function () {
                    var index = vm.activities.indexOf(activity);
                    vm.activities.splice(index, 1);
                });
            });
        }

        function showActivity(activity) {
            $state.go('activitiesShow', {id: activity.activity.id});
        }

        function isTeacher() {
            vm.isTeacher = userService.isTeacher();
        }
    }

})();