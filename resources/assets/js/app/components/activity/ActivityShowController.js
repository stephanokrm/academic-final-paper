(function () {
    'use strict';

    angular
        .module('academic')
        .controller('ActivityShowController', ActivityShowController);

    ActivityShowController.$inject = ['$rootScope', '$stateParams', '$mdDialog', 'ActivityService', 'UserService'];
    function ActivityShowController($rootScope, $stateParams, $mdDialog, ActivityService, UserService) {
        var vm = this;
        vm.activity = {};
        vm.isTeacher = false;
        vm.openDetailsDialog = openDetailsDialog;
        vm.sendEmail = sendEmail;
        $rootScope.pageTitle = 'Detalhes Atividade';

        isTeacher();
        getActivity();

        function getActivity() {
            return ActivityService.showActivity($stateParams.id).then(function (data) {
                vm.users = data.users;
                vm.activity = data.activity;
                return vm.users;
            });
        }

        function openDetailsDialog(user, ev) {
            $mdDialog.show({
                controller: ActivityUserController,
                controllerAs: 'vm',
                templateUrl: 'views/activity/activityUser.html',
                parent: angular.element(document.body),
                targetEvent: ev,
                clickOutsideToClose: true,
                fullscreen: true,
                locals: {user: user, activity: vm.activity}
            });
        }

        function sendEmail(user) {

        }

        function ActivityUserController(locals) {
            var vm = this;
            vm.user = locals.user;
            vm.activity = locals.activity;

            vm.hide = function () {
                $mdDialog.hide();
            };

            vm.cancel = function () {
                $mdDialog.cancel();
            };

            vm.conclude = function () {
                ActivityService.saveDetails(vm.user, vm.activity).then(function () {
                    $mdDialog.hide();
                });
            };

        }

        function isTeacher() {
            vm.isTeacher = UserService.isTeacher();
        }

    }

})();