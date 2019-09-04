(function () {
    'use strict';

    angular
        .module('academic')
        .controller('GradesController', GradesController);

    GradesController.$inject = ['$rootScope', '$location', '$state', 'ActivityService'];
    function GradesController($rootScope, $location, $state, ActivityService) {
        let vm = this;
        vm.activities = [];
        vm.back = back;

        ActivityService.getActivitiesFromStudent().then(function (data) {
            vm.activities = data.activities;
        });

        function back() {
            $location.path($rootScope.previousUrl);
        }
    }

})();