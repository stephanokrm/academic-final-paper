(function () {
    'use strict';

    angular
            .module('academic')
            .factory('EventService', EventService);

    EventService.$inject = ['$http'];
    function EventService($http) {
        var service = {
            index: index,
            store: store,
            update: update,
            destroy: destroy
        };

        return service;

        function index(ids, onSuccess, onError, onFinally) {
            $http.post(laroute.route('events.index'), ids).success(function (events) {
                onSuccess(events);
            }).error(function () {
                onError();
            }).finally(function () {
                onFinally();
            });
        }

        function store(event, onSuccess, onError, onFinally) {
            $http.post(laroute.route('events.store'), event).success(function (event) {
                onSuccess(event);
            }).error(function () {
                onError();
            }).finally(function () {
                onFinally();
            });
        }

        function update(event, onSuccess, onError, onFinally) {
            $http.put(laroute.route('events.update', {events: event.id}), event).success(function (event) {
                onSuccess(event);
            }).error(function () {
                onError();
            }).finally(function () {
                onFinally();
            });
        }

        function destroy(event, onSuccess, onError, onFinally) {
            $http.post(laroute.route('events.destroy', {id: event.id}), event).success(function () {
                onSuccess();
            }).error(function () {
                onError();
            }).finally(function () {
                onFinally();
            });
        }
    }
})();