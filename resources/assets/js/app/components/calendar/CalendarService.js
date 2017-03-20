(function () {
    'use strict';

    angular
        .module('academic')
        .factory('CalendarService', CalendarService);

    CalendarService.$inject = ['$http', '$mdToast'];
    function CalendarService($http, $mdToast) {
        var service = {
            getCalendars: getCalendars,
            storeCalendar: storeCalendar,
            updateCalendar: updateCalendar,
            removeCalendar: removeCalendar,
            getAttendees: getAttendees,
            getNotAttendees: getNotAttendees,
            addAttendee: addAttendee,
            removeAttendee: removeAttendee,
            showMessage: showMessage
        };

        return service;

        function getCalendars() {
            return $http.get(laroute.route('calendars.index'))
                .then(getCalendarsComplete)
                .catch(getCalendarsFailed);

            function getCalendarsComplete(response) {
                return response.data;
            }

            function getCalendarsFailed() {
                $mdToast.show($mdToast.simple()
                    .textContent('Ocorreu um erro ao buscar os calendários.')
                    .position('bottom right')
                    .hideDelay(4000));
            }
        }

        function storeCalendar(calendar) {
            return $http.post(laroute.route('calendars.store'), calendar)
                .then(storeCalendarComplete)
                .catch(storeCalendarFailed);

            function storeCalendarComplete(response) {
                showMessage('Calendário salvo!');
                return response.data;
            }

            function storeCalendarFailed() {
                showMessage('Ocorreu um erro ao buscar os calendários.');
            }
        }

        function updateCalendar(calendar) {
            return $http.put(laroute.route('calendars.update', {calendars: calendar.id}), calendar)
                .then(updateCalendarComplete)
                .catch(updateCalendarFailed);

            function updateCalendarComplete(response) {
                showMessage('Calendário editado!');
                return response.data;
            }

            function updateCalendarFailed() {
                showMessage('Ocorreu um erro ao editar o calendário.');
            }
        }

        function removeCalendar(calendar) {
            return $http.delete(laroute.route('calendars.destroy', {calendars: calendar.id}))
                .then(removeCalendarComplete)
                .catch(removeCalendarFailed);

            function removeCalendarComplete(response) {
                showMessage('Calendário excluído!');
                return response.data;
            }

            function removeCalendarFailed() {
                showMessage('Ocorreu um erro ao excluir o calendário.');
            }
        }

        function getAttendees(calendar) {
            return $http.get(laroute.route('calendars.attendees', {id: calendar.id}))
                .then(getAttendeesComplete)
                .catch(getAttendeesFailed);

            function getAttendeesComplete(response) {
                return response.data;
            }

            function getAttendeesFailed() {
                $mdToast.show($mdToast.simple()
                    .textContent('Ocorreu um erro ao buscar os convidados.')
                    .position('bottom right')
                    .hideDelay(4000));
            }
        }

        function getNotAttendees(calendar) {
            return $http.get(laroute.route('calendars.notAttendees', {id: calendar.id}))
                .then(getNotAttendeesComplete)
                .catch(getNotAttendeesFailed);

            function getNotAttendeesComplete(response) {
                return response.data;
            }

            function getNotAttendeesFailed() {
                $mdToast.show($mdToast.simple()
                    .textContent('Ocorreu um erro ao buscar os não convidados.')
                    .position('bottom right')
                    .hideDelay(4000));
            }
        }

        function addAttendee(calendar) {
            return $http.post(laroute.route('calendars.addAttendee'), calendar)
                .then(addAttendeeComplete)
                .catch(addAttendeeFailed);

            function addAttendeeComplete(response) {
                showMessage('Convidado adicionado!');
                return response.data;
            }

            function addAttendeeFailed() {
                showMessage('Ocorreu um erro ao adicionar o convidado.');
            }
        }

        function removeAttendee(calendar) {
            return $http.post(laroute.route('calendars.removeAttendee'), calendar)
                .then(removeAttendeeComplete)
                .catch(removeAttendeeFailed);

            function removeAttendeeComplete(response) {
                showMessage('Convidado removido!');
                return response.data;
            }

            function removeAttendeeFailed() {
                showMessage('Ocorreu um erro ao remover o convidado.');
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
