(function () {
    'use strict';

    angular
            .module('academic')
            .controller('LoginController', LoginController);

    LoginController.$inject = ['$state', '$rootScope', '$mdToast', 'userService', 'GoogleService'];
    function LoginController($state, $rootScope, $mdToast, userService, GoogleService) {
        var vm = this;
        vm.user = {};
        vm.doLogin = doLogin;

        function doLogin() {
            GoogleService.createAuthUrl().then(function (url) { 
                $rootScope.googleUrl = url;
                return $rootScope.googleUrl;
            });

            userService.authenticate(
                    vm.user,
                    function () {
                        showToast('Login efetuado com sucesso!');
                        $state.go('home');
                    },
                    function () {
                        $state.go('register');
                    },
                    function (response) {
                        showToast(response.data.authentication);
                        vm.user.password = '';
                    }
            );
        }

        function showToast(message) {
            $mdToast.show($mdToast.simple()
                    .textContent(message)
                    .position('bottom right')
                    .hideDelay(4000));
        }
    }

})();
angular
        .module('academic')
        .controller('RegisterController', ['$scope', '$location', '$mdToast', 'userService', 'teamService', '$rootScope', function ($scope, $location, $mdToast, userService, teamService, $rootScope) {

                function showToast(message) {
                    $mdToast.show($mdToast.simple()
                            .textContent(message)
                            .position('bottom right')
                            .hideDelay(4000));
                }

                $scope.userName = userService.getCurrentUser().name;

                teamService.getAll(function (response) {
                    $scope.teams = response;
                }, function () {
                    showToast('Ocorreram alguns erros durante a comunicação com o serviço. Tente mais tarde.');
                });

                $scope.doRegister = function () {
                    userService.update(
                            userService.getCurrentUser().id,
                            $scope.user,
                            function (response) {
                                showToast('Registro efetuado com sucesso!');
                                $location.path('/');
                            },
                            function (response) {
                                showToast('Login efetuado com sucesso!');
                                alert('Algo deu errado com o processo de registro. Tente mais tarde.');
                            });

                };
            }]);
(function () {
    'use strict';

    angular
            .module('academic')
            .controller('CalendarController', CalendarController);

    CalendarController.$inject = ['$timeout', '$rootScope', '$mdToast', '$mdDialog', 'CalendarService', 'teamService', 'userService', 'EventService', 'DEFAULT_ERROR_MESSAGE'];
    function CalendarController($timeout, $rootScope, $mdToast, $mdDialog, CalendarService, teamService, userService, EventService, DEFAULT_ERROR_MESSAGE) {
        var vm = this;
        var index;
        var emails = [];
        var calendarIds = [];
        var colors = [];
        var selectedColor;
        var calendarElement = $('#calendar');
        var color = {
            "1": {"background": "#a4bdfc", "foreground": "#1d1d1d", "name": "Azul Claro"},
            "2": {"background": "#7ae7bf", "foreground": "#1d1d1d", "name": "Cerceta"},
            "3": {"background": "#dbadff", "foreground": "#1d1d1d", "name": "Roxo"},
            "4": {"background": "#ff887c", "foreground": "#1d1d1d", "name": "Rosa"},
            "5": {"background": "#fbd75b", "foreground": "#1d1d1d", "name": "Amarelo"},
            "6": {"background": "#ffb878", "foreground": "#1d1d1d", "name": "Laranja"},
            "7": {"background": "#46d6db", "foreground": "#1d1d1d", "name": "Ciano"},
            "8": {"background": "#e1e1e1", "foreground": "#1d1d1d", "name": "Cinza"},
            "9": {"background": "#5484ed", "foreground": "#1d1d1d", "name": "Azul"},
            "10": {"background": "#51b749", "foreground": "#1d1d1d", "name": "Verde"},
            "11": {"background": "#dc2127", "foreground": "#1d1d1d", "name": "Vermelho"}
        };
        $rootScope.pageTitle = 'Calendários';

        vm.agendaDay = true;

        for (var id in color) {
            colors.push(color[id]);
        }

        getCalendars();

        $timeout(function () {
            calendarElement.fullCalendar('render');
            bindFullcalendarViewTitle();
        }, 0);

        vm.uiConfig = {
            calendar: {
                displayEventTime: false,
                height: 'auto',
                editable: false,
                droppable: false,
                titleFormat: 'DD - MMMM YYYY',
                lang: 'pt-br',
                events: {
                    url: laroute.route('events.index'),
                    type: 'post',
                    data: function () {
                        return {
                            ids: getIds()
                        };
                    },
                    error: function () {
                        alert('error');
                    }
                },
                header: {left: '', center: '', right: ''},
                eventClick: function (event, jsEvent, view) {
                    editEvent(event);
                },
                dayClick: function (date, jsEvent, view) {
                    vm.createEvent(date);
                },
                views: {
                    month: {titleFormat: 'MMMM YYYY'},
                    week: {titleFormat: 'MMM DD, YYYY'},
                    day: {titleFormat: 'MMMM DD, YYYY'}
                }
            }
        };

        vm.calendarAction = function (action) {
            calendarElement.fullCalendar(action);
            bindFullcalendarViewTitle();
        };

        vm.changeView = function (view) {
            switch (view) {
                case 'agendaDay':
                    vm.agendaDay = false;
                    vm.agendaWeek = true;
                    break;
                case 'agendaWeek':
                    vm.agendaWeek = false;
                    vm.month = true;
                    break;
                case 'month':
                    vm.month = false;
                    vm.agendaDay = true;
                    break;
            }

            calendarElement.fullCalendar('changeView', view);
            bindFullcalendarViewTitle();
        };

        vm.refrashEvents = function () {
            refreshEvents();
        };

        vm.createCalendar = function () {
            $mdDialog.show({
                controller: CalendarCreateDialogController,
                controllerAs: 'vm',
                templateUrl: 'views/calendar/calendarCreate.html',
                parent: angular.element(document.body),
                clickOutsideToClose: true,
                fullscreen: true
            });
        };

        vm.editCalendar = function (calendar) {
            $mdDialog.show({
                controller: CalendarEditDialogController,
                controllerAs: 'vm',
                templateUrl: 'views/calendar/calendarEdit.html',
                parent: angular.element(document.body),
                clickOutsideToClose: true,
                fullscreen: true,
                locals: {calendar: calendar}
            });
        };

        vm.destroyCalendar = function (calendar) {
            CalendarService.removeCalendar(calendar).then(function () {
                getCalendars();
            });
        };

        vm.createEvent = function (date) {
            $mdDialog.show({
                controller: EventDialogController,
                controllerAs: 'vm',
                templateUrl: 'views/event/eventForm.html',
                parent: angular.element(document.body),
                clickOutsideToClose: true,
                fullscreen: true,
                locals: {date: date, calendars: vm.calendars}
            });
        };

        function editEvent(event) {
            $mdDialog.show({
                controller: EventDialogController,
                controllerAs: 'vm',
                templateUrl: 'views/event/eventForm.html',
                parent: angular.element(document.body),
                clickOutsideToClose: true,
                fullscreen: true,
                locals: {calendars: vm.calendars, event: event}
            });
        }

        function bindFullcalendarViewTitle() {
            vm.viewTitle = calendarElement.fullCalendar('getView').title;
        }

        function showMessageToast(message) {
            $mdToast.show($mdToast.simple()
                    .textContent(message)
                    .position('bottom right')
                    .hideDelay(4000));
        }

        function refreshEvents() {
            calendarElement.fullCalendar('refetchEvents');
            $rootScope.isActionLoading = false;
        }

        function getCalendars() {
            return CalendarService.getCalendars().then(function (calendars) {
                vm.calendars = calendars;
                refreshEvents();
                return vm.calendars;
            });
        }

        function getIds() {
            calendarIds = [];

            angular.forEach(vm.calendars, function (calendar) {
                if (calendar.selected == true) {
                    calendarIds.push(calendar.id);
                }
            });

            return calendarIds;
        }

        function CalendarCreateDialogController($mdDialog) {
            var vm = this;
            vm.calendarCreate = {};
            vm.calendarCreate.attendees = [];
            vm.isTeacher = userService.isTeacher();
            vm.storeCalendar = storeCalendar;
            vm.toggleUser = toggleUser;

            if (userService.isTeacher()) {
                teamService.getAllFromTeacher(function (teams) {
                    $rootScope.isActionLoading = false;
                    vm.teams = teams;
                }, function () {
                    showMessageToast(DEFAULT_ERROR_MESSAGE);
                });
            } else {
                userService.getByTeam(function (users) {
                    $rootScope.isActionLoading = false;
                    vm.users = users;
                }, function () {
                    showMessageToast(DEFAULT_ERROR_MESSAGE);
                });
            }

            vm.closeModal = function () {
                $mdDialog.hide();
            };

            function storeCalendar() {
                CalendarService.storeCalendar(vm.calendarCreate).then(function () {
                    getCalendars();
                    $mdDialog.hide();
                });
            }

            function toggleUser(user) {
                index = emails.indexOf(user.email);
                user.selected ? vm.calendarCreate.attendees.push(user.email) : vm.calendarCreate.attendees.splice(index, 1);
            }
        }

        function CalendarEditDialogController($mdDialog, locals) {
            var vm = this;
            vm.calendarEdit = locals.calendar;
            vm.isTeacher = userService.isTeacher();

            vm.toggleUser = function (attendee) {
                index = emails.indexOf(attendee.email);
                attendee.selected ? emails.push(attendee.email) : emails.splice(index, 1);
            };

            if (userService.isTeacher()) {
                teamService.getAllFromTeacher(function (teams) {
                    vm.teams = teams;
                }, function () {
                    showMessageToast(DEFAULT_ERROR_MESSAGE);
                }, function () {});
            } else {
                CalendarService.getNotAttendees(locals.calendar).then(function (users) {
                    vm.notAttendees = users;
                });
                CalendarService.getAttendees(locals.calendar).then(function (attendees) {
                    vm.attendees = attendees;
                });
            }

            vm.addAttendee = function (attendee) {
                vm.calendarEdit.attendee = attendee;
                CalendarService.addAttendee(vm.calendarEdit).then(function () {
                    index = vm.notAttendees.indexOf(attendee);
                    vm.notAttendees.splice(index, 1);
                    vm.attendees.push({profile_image: attendee.profile_image, email: attendee.email, user: {name: attendee.name}});
                });
            };

            vm.removeAttendee = function (attendee) {
                vm.calendarEdit.attendee = attendee;
                CalendarService.removeAttendee(vm.calendarEdit).then(function () {
                    index = vm.attendees.indexOf(attendee);
                    vm.attendees.splice(index, 1);
                    vm.notAttendees.push({profile_image: attendee.profile_image, name: attendee.user.name, email: attendee.user.email});
                });
            };

            vm.closeModal = function () {
                $mdDialog.hide();
            };

            vm.updateCalendar = function (calendar) {
                CalendarService.updateCalendar(calendar).then(function () {
                    $mdDialog.hide();
                });
            };
        }

        function EventDialogController($mdDialog, locals) {
            var vm = this;
            vm.editing = false;
            vm.event = {};
            vm.eventAction = 'Novo evento';
            vm.calendarsEvent = locals.calendars;
            vm.colors = colors;

            if (locals.event) {
                vm.editing = true;
                var start = new Date(locals.event.start._i);
                var end = new Date(locals.event.start._i);
                if (locals.event.end) {
                    end = new Date(locals.event.end._i);
                }
                vm.eventAction = 'Editar evento';
                vm.event = locals.event;
                vm.event.summary = locals.event.title;
                vm.event.all_day = locals.event.allDay;
                vm.event.begin_date = start;
                vm.event.end_date = end;
                if (!vm.event.all_day) {
                    vm.event.begin_time = start.toLocaleTimeString().substring(0, 5);
                    vm.event.end_time = end.toLocaleTimeString().substring(0, 5);
                }
                changeColor(locals.event.color);
            }

            vm.showConfirm = function (event) {
                var confirm = $mdDialog.confirm()
                        .title('Gostaria de excluir esse evento?')
                        .ok('Excluir')
                        .cancel('Cancelar');

                $mdDialog.show(confirm).then(function () {
                    EventService.destroy(event, function () {
                        calendarElement.fullCalendar('removeEvents', event.id);
                        showMessageToast('Evento removido!');
                    }, function () {
                        showMessageToast(DEFAULT_ERROR_MESSAGE);
                    }, function () {});
                });
            };

            vm.closeModal = function () {
                $mdDialog.hide();
            };

            vm.changeEventColor = function () {
                changeColor(vm.event.color);
            };

            function changeColor(color) {
                index = color;
                selectedColor = colors[index - 1];
                if (selectedColor) {
                    vm.style = "background-color: " + selectedColor.background;
                } else {
                    vm.style = "background-color: #9fe1e7";
                }

            }

            vm.saveEvent = function () {
                if (vm.editing) {
                    updateEvent();
                } else {
                    EventService.store(vm.event, function (event) {
                        $mdDialog.hide();
                        calendarElement.fullCalendar('renderEvent', event);
                        showMessageToast('Evento criado!');
                    }, function () {
                        showMessageToast(DEFAULT_ERROR_MESSAGE);
                    }, function () {});
                }
            };

            function updateEvent() {
                EventService.update(vm.event, function (event) {
                    $mdDialog.hide();
                    calendarElement.fullCalendar('removeEvents', vm.event.id);
                    calendarElement.fullCalendar('renderEvent', event);
                    showMessageToast('Evento editado!');
                }, function () {
                    showMessageToast(DEFAULT_ERROR_MESSAGE);
                }, function () {});
            }
        }

    }
})();
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
(function () {
    'use strict';

    angular
        .module('academic')
        .controller('ActivityCreateController', ActivityCreateController);

    ActivityCreateController.$inject = ['$rootScope', '$state', '$location', '$stateParams', 'ActivityService', 'CalendarService'];
    function ActivityCreateController($rootScope, $state, $location, $stateParams, ActivityService, CalendarService) {
        let vm = this;
        vm.activity = {team_id: $stateParams.id};
        vm.calendars = [];
        vm.colors = [
            {id: 10, background: {"background-color": "#51b749", "color": "white"}, name: "Exercício"},
            {id: 5, background: {"background-color": "#fbd75b", "color": "white"}, name: "Atividade avaliativa"},
            {id: 11, background: {"background-color": "#dc2127", "color": "white"}, name: "Prova"}
        ];
        vm.storeActivity = storeActivity;
        vm.back = back;
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

        function back() {
            $location.path($rootScope.previousUrl);
        }
    }

})();
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
(function () {
    'use strict';

    angular
            .module('academic')
            .controller('ActivityShowController', ActivityShowController);

    ActivityShowController.$inject = ['$rootScope', '$stateParams', '$mdDialog', 'ActivityService', 'userService'];
    function ActivityShowController($rootScope, $stateParams, $mdDialog, ActivityService, userService) {
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
            vm.isTeacher = userService.isTeacher();
        }

    }

})();
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
(function () {
    'use strict';

    angular
            .module('academic')
            .controller('TeamIndexController', TeamIndexController);

    TeamIndexController.$inject = ['$rootScope', '$state', 'teamService'];
    function TeamIndexController($rootScope, $state, teamService) {
        var vm = this;
        vm.teams = [];
        vm.showTeamActivities = showTeamActivities;
        $rootScope.pageTitle = 'Turmas';

        getTeams();

        function getTeams() {
            return teamService.getAllFromTeacher(function (teams) {
                vm.teams = teams;
                return vm.teams;
            }, function () {
                alert('Error');
            });
        }

        function showTeamActivities(team) {
            $state.go('activitiesIndex', {id: team.id});
        }
    }

})();
(function () {
    'use strict';

    angular
        .module('academic')
        .controller('navController', navController);

    navController.$inject = ['$state', '$scope', '$location', '$rootScope', '$mdSidenav', 'userService', 'GoogleService'];
    function navController($state, $location, $rootScope, $mdSidenav, userService, GoogleService) {
        let vm = this;
        vm.toggleLeft = buildToggler('left');
        vm.goToActivities = goToActivities;
        vm.goToTeams = goToTeams;
        vm.doLogout = doLogout;
        vm.doGoogleLogout = doGoogleLogout;

        function doGoogleLogout() {
            GoogleService.logout().then(() => {
                $rootScope.google_authenticated = false;
                $state.go('home');
            });
        }

        function doLogout() {
            userService.logout();
            $location.path('/login');
        }

        function buildToggler(componentId) {
            return function () {
                $mdSidenav(componentId).toggle();
            };
        }

        function goToActivities() {
            let user = userService.getCurrentUser();
            $state.go('activitiesIndex', {id: user.student.team_id});
        }

        function goToTeams() {
            $state.go('teamsIndex', {});
        }

        function navigateTo(state) {
            $state.go(state, {});
        }
    }

})();

angular
        .module('academic')
        .controller('HomeController', [
            '$location',
            '$rootScope',
            'GoogleService',
            'localStorageService',
            function ($location, $rootScope, GoogleService, localStorageService) {
                $rootScope.pageTitle = 'Início';
                
                if (!GoogleService.checkIfIsLogged() && getURLParameter('code')) {
                    GoogleService.authenticate().then(function () {
                        $rootScope.google_authenticated = true;
                        $location.path(localStorageService.get('requestedUrl'));
                    });
                }

                function getURLParameter(name) {
                    return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [null, ''])[1].replace(/\+/g, '%20')) || null;
                }

            }]);


//# sourceMappingURL=controllers.js.map
