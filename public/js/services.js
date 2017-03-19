angular
        .module('academic')
        .factory('userService', ['localStorageService', 'Restangular', function (localStorageService, Restangular) {

                function isLoggedIn() {
                    return localStorageService.get('user') ? true : false;
                }

                function authenticate(data, onSuccessActive, onSuccessInactive, onError) {
                    Restangular.all(laroute.route('users.authenticate')).post(data).then(function (user) {
                        if (Object.keys(user).length > 0) {
                            localStorageService.set('user', user);
                            user.active == true ? onSuccessActive(user) : onSuccessInactive(user);
                        }
                    }, function (response) {
                        onError(response);
                    });

                }

                function update(userId, data, onSuccess, onError) {

                    Restangular.one(laroute.route('users.update', {users: userId})).customPUT(data).then(function (user) {
                        localStorageService.set('user', user);
                        onSuccess(user);
                    }, function (response) {
                        onError(response);
                    });

                }

                function getByTeam(onSuccess, onError) {
                    Restangular.all(laroute.route('users.byTeam')).getList().then(function (users) {
                        onSuccess(users);
                    }, function (response) {
                        onError(response);
                    });
                }

                function logout() {
                    Restangular.one(laroute.route('users.logout')).get();
                    localStorageService.clearAll();
                }

                function getCurrentUser() {
                    return localStorageService.get('user');
                }

                function isActive() {
                    return getCurrentUser().active == true ? true : false;
                }

                function isTeacher() {
                    return getCurrentUser().teacher == null ? false : true;
                }

                return {
                    isLoggedIn: isLoggedIn,
                    authenticate: authenticate,
                    update: update,
                    logout: logout,
                    getCurrentUser: getCurrentUser,
                    isActive: isActive,
                    isTeacher: isTeacher,
                    getByTeam: getByTeam
                };

            }]);

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

(function () {
    'use strict';

    angular
            .module('academic')
            .factory('GoogleService', GoogleService);

    GoogleService.$inject = ['$http', '$mdToast', 'localStorageService'];
    function GoogleService($http, $mdToast, localStorageService) {
        var service = {
            createAuthUrl: createAuthUrl,
            getAuthUrl: getAuthUrl,
            authenticate: authenticate,
            checkIfIsLogged: checkIfIsLogged,
            logout: logout,
            showMessage: showMessage
        };

        return service;

        function createAuthUrl() {
            return $http.get(laroute.route('googles.createAuthUrl'))
                    .then(createAuthUrlComplete)
                    .catch(createAuthUrlFailed);

            function createAuthUrlComplete(response) {
                localStorageService.set('url', response.data);
                return response.data;
            }

            function createAuthUrlFailed() {
                showMessage('Ocorreu um erro ao conectar com o Google.');
            }
        }

        function authenticate() {
            return $http.get(laroute.route('googles.authenticate'))
                    .then(authenticateComplete)
                    .catch(authenticateFailed);

            function authenticateComplete(response) {
                localStorageService.set('access_token', response.data);
                showMessage('Autenticação Google realizada com sucesso!');
                return response.data;
            }

            function authenticateFailed() {
                showMessage('Ocorreu um erro ao conectar com o Google.');
            }
        }

        function logout() {
            return $http.get(laroute.route('googles.logout'))
                    .then(logoutComplete)
                    .catch(logoutFailed);

            function logoutComplete(response) {
                localStorageService.remove('access_token');
                showMessage('Você saiu do Google!');
                return response.data;
            }

            function logoutFailed() {
                showMessage('Ocorreu um erro ao sair do Google.');
            }
        }

        function getAuthUrl() {
            return localStorageService.get('url');
        }

        function checkIfIsLogged() {
            return localStorageService.get('access_token') ? true : false;
        }

        function showMessage(message) {
            $mdToast.show($mdToast.simple()
                    .textContent(message)
                    .position('bottom right')
                    .hideDelay(4000));
        }
    }
})();

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
//# sourceMappingURL=services.js.map
