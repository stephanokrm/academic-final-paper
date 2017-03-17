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