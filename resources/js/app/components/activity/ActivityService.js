(function () {
    'use strict';

    angular
        .module('academic')
        .factory('ActivityService', ActivityService);

    ActivityService.$inject = ['$http', '$mdToast'];
    function ActivityService($http, $mdToast) {
        let service = {
            getActivities: getActivities,
            storeActivity: storeActivity,
            getActivity: getActivity,
            updateActivity: updateActivity,
            removeActivity: removeActivity,
            showActivity: showActivity,
            saveDetails: saveDetails,
            getActivitiesFromStudent: getActivitiesFromStudent
        };

        return service;

        function getActivities(id) {
            return $http.get(laroute.route('activities.index', {team: id}))
                .then(getActivitiesComplete)
                .catch(getActivitiesFailed);

            function getActivitiesComplete(response) {
                return response.data;
            }

            function getActivitiesFailed() {
                showMessage('Ocorreu um erro ao buscar as atividades.');
            }
        }

        function getActivity(id) {
            return $http.get(laroute.route('activities.edit', {activities: id}))
                .then(getActivityComplete)
                .catch(getActivityFailed);

            function getActivityComplete(response) {
                return response.data;
            }

            function getActivityFailed() {
                showMessage('Ocorreu um erro ao buscar a atividade.');
            }
        }

        function storeActivity(activity) {
            return $http.post(laroute.route('activities.store'), activity)
                .then(storeActivityComplete)
                .catch(storeActivityFailed);

            function storeActivityComplete(response) {
                showMessage('Atividade salva!');
                return response.data;
            }

            function storeActivityFailed() {
                showMessage('Ocorreu um erro ao salvar a atividade.');
            }
        }

        function updateActivity(activity) {
            return $http.put(laroute.route('activities.update', {activities: activity.id}), activity)
                .then(updateActivityComplete)
                .catch(updateActivityFailed);

            function updateActivityComplete(response) {
                showMessage('Atividade atualizada!');
                return response.data;
            }

            function updateActivityFailed() {
                showMessage('Ocorreu um erro ao atualizar a atividade.');
            }
        }

        function removeActivity(activity) {
            return $http.delete(laroute.route('activities.destroy', {activities: activity.activity.id}))
                .then(removeActivityComplete)
                .catch(removeActivityFailed);

            function removeActivityComplete(response) {
                showMessage('Atividade removida!');
                return response.data;
            }

            function removeActivityFailed() {
                showMessage('Ocorreu um erro ao remover a atividade.');
            }
        }

        function showActivity(id) {
            return $http.get(laroute.route('activities.show', {activities: id}))
                .then(showActivityComplete)
                .catch(showActivityFailed);

            function showActivityComplete(response) {
                return response.data;
            }

            function showActivityFailed() {
                showMessage('Ocorreu um erro ao buscar os detalhes atividade.');
            }
        }

        function saveDetails(user, activity) {
            return $http.post(laroute.route('activities.details', {id: activity.id}), user)
                .then(saveDetailsComplete)
                .catch(saveDetailsFailed);

            function saveDetailsComplete(response) {
                showMessage('Detalhes salvos!');
                return response.data;
            }

            function saveDetailsFailed() {
                showMessage('Ocorreu um erro ao salvar os detalhes.');
            }
        }

        function getActivitiesFromStudent() {
            return $http.get(laroute.route('activities.fromStudent'))
                .then(getActivitiesFromStudentComplete)
                .catch(getActivitiesFromStudentFailed);

            function getActivitiesFromStudentComplete(response) {
                return response.data;
            }

            function getActivitiesFromStudentFailed(response) {
                showMessage('Não foi possível buscar as atividades.');
            }
        }

        function showMessage(message) {
            $mdToast.show($mdToast.simple()
                .textContent(message)
                .position('bottom right')
                .hideDelay(4000));
        }
    }
})();