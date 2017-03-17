(function () {
    'use strict';

    angular
            .module('academic')
            .factory('teamService', teamService);

    teamService.$inject = ['Restangular'];
    function teamService(Restangular) {
        var service = {
            getAll: getAll,
            getAllFromTeacher: getAllFromTeacher
        };

        return service;

        function getAll(onSuccess, onError) {
            Restangular.all(laroute.route('teams.index')).getList().then(function (response) {
                onSuccess(response);
            }, function (response) {
                onError(response);
            });
        }

        function getAllFromTeacher(onSuccess, onError) {
            Restangular.all(laroute.route('teams.create')).getList().then(function (teams) {
                onSuccess(teams);
            }, function (response) {
                onError(response);
            });
        }
    }
})();
