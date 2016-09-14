/* global Materialize */

$(document).ready(function () {
    var ids = [];
    var calendar;
    var eventModal = $('#event');
    var route = laroute.route('events.index');

    $('.time').mask('23:59', {'translation': {2: {pattern: /[0-2]/}, 3: {pattern: /[0-9]/}, 5: {pattern: /[0-5]/}, 9: {pattern: /[0-9]/}}});
    $('.date').mask('39/19/2999', {'translation': {1: {pattern: /[0-1]/}, 2: {pattern: /[1-2]/}, 3: {pattern: /[0-9]/}, 9: {pattern: /[0-9]/}}});
    $('#description').characterCounter();

    $('#all_day').trigger('change');

    $('.modal-trigger').leanModal({
        ready: function () {
            Materialize.updateTextFields();
            $('input, textarea').blur();
            $('body').css('position', 'fixed');
        },
        complete: function () {
            $('input').val('');
            $('#colors_select, #calendar_select').val('');
            $('#colors_select, #calendar_select').material_select();
            $('#description').val('');
            $('#event-create').find('h4').text('Adicionar Evento');
            $('input, textarea').blur();
            Materialize.updateTextFields();
            $('body').css('position', 'initial');
        }});

    $('#calendars-collapsible-header').click(function () {
        $('#keyboard_arrow_up').toggleClass('hide');
        $('#keyboard_arrow_down').toggleClass('hide');
    });

    calendar = $('#calendar').fullCalendar({
        displayEventTime: false,
        contentHeight: 750,
        header: {center: '', right: '', left: ''},
        titleFormat: 'DD - MMMM YYYY',
        lang: 'pt-br',
        editable: true,
        droppable: true,
        events: {
            url: route,
            type: 'post',
            data: function () {
                return {
                    ids: getIds()
                };
            },
            error: function () {
                Materialize.toast('Ocorreu um erro ao carregar os eventos.', 4000);
            }
        },
        eventClick: function (event, jsEvent, view) {
            createEventModal(event);
        },
        dayClick: function (date, jsEvent, view) {

        },
        eventDrop: function (event, delta, revertFunc) {
            updateEventOnDropOrResize(event, revertFunc);
        },
        eventResize: function (event, delta, revertFunc) {
            updateEventOnDropOrResize(event, revertFunc);
        },
        views: {
            month: {
                titleFormat: 'MMMM YYYY'
            },
            week: {
                titleFormat: 'MMM DD, YYYY'
            },
            day: {
                titleFormat: 'MMMM DD, YYYY'
            }
        }
    });

    updateDateInHeader(calendar);

    $('.filled-in').change(function () {
        calendar.fullCalendar('refetchEvents');
    });

    $('#month_view').click(function () {
        calendar.fullCalendar('changeView', 'month');
        updateDateInHeader(calendar);
    });

    $('#week_view').click(function () {
        calendar.fullCalendar('changeView', 'basicWeek');
        updateDateInHeader(calendar);
    });

    $('#day_view').click(function () {
        calendar.fullCalendar('changeView', 'basicDay');
        updateDateInHeader(calendar);
    });

    $('#today').click(function () {
        calendar.fullCalendar('today');
        updateDateInHeader(calendar);
    });

    $('#right_arrow').click(function () {
        calendar.fullCalendar('next');
        updateDateInHeader(calendar);
    });

    $('#left_arrow').click(function () {
        calendar.fullCalendar('prev');
        updateDateInHeader(calendar);
    });

    $('.remove-calendar').click(function () {
        $(this).parent('li').parent('form').submit();
    });

    function updateDateInHeader(calendar) {
        var view = calendar.fullCalendar('getView');
        $('#calendar_date').text(view.title);
    }

    function getIds() {
        ids = [];
        $('.filled-in').each(function () {
            if ($(this).prop('checked')) {
                ids.push($(this).data('id'));
            }
        });
        return ids;
    }

    function updateEventOnDropOrResize(event, revertFunc) {
        var id = event.id;
        var calendar = event.calendar;
        var data = createPostForEvent(event);
        $.ajax({
            url: laroute.route('events.update', {calendar: calendar, id: id}),
            data: data,
            type: 'post',
            dataType: 'json',
            success: function (response) {
                console.log(response);
                response.status == 'success' ? Materialize.toast(response.message, 4000) : revertFunc();
            },
            error: function (e) {
                revertFunc();
                Materialize.toast('Ocorreu um erro ao salvar as mudanças.', 4000);
            }
        });
    }

    function createPostForEvent(event) {
        var time = '';
        var allDay = '&all_day=Y';
        var color = event.color;
        var title = event.title;
        var description = event.description;
        var startDate = event.start.format('DD/MM/YYYY');
        var endDate = (event.end == null) ? startDate : event.end.format('DD/MM/YYYY');
        if (event.start.hasTime()) {
            var startTime = event.start.format('HH:SS');
            var endTime = event.end.format('HH:SS');
            allDay = '';
            time = '&begin_time=' + startTime + '&end_time=' + endTime;
        }
        return 'summary=' + title + '&description=' + description + '&color=' + color + '&begin_date=' + startDate + '&end_date=' + endDate + time + allDay;
    }

    function createEventModal(event) {
        var start = event.start.format('MMMM DD, YYYY');
        var end = event.end.format('MMMM DD, YYYY');
        var description;
        if (typeof event.description == 'undefined') {
            description = 'Sem descrição';
        } else {
            description = event.description;
            $('#description').val(description);
        }
        if (event.start.hasTime()) {
            start = event.start.format('MMMM DD YYYY, HH:SS');
            end = event.end.format('MMMM DD YYYY, HH:SS');
            $('#begin-time').val(event.start.format('HH:SS'));
            $('#end-time').val(event.end.format('HH:SS'));
        }
        eventModal.find('.event-title-text').html(event.title);
        eventModal.children('.modal-header').css('background-color', event.backgroundColor);
        eventModal.children('.modal-header').css('color', event.textColor);
        eventModal.find('.event-date').html(start + ' - ' + end);
        eventModal.find('.description').html(description);

        $('#summary').val(event.title);
        $('#begin-date').val(event.start.format('DD/MM/YYYY'));
        $('#end-date').val(event.end.format('DD/MM/YYYY'));
        $('#colors_select').val(event.color);
        $('#calendar_select').val(event.calendar);
        $('#colors_select, #calendar_select').material_select();
        $('#event-create').find('h4').text('Editar Evento');
        $('body').css('position', 'fixed');

        eventModal.openModal();
    }

    $('#event_edit').click(function () {
        eventModal.closeModal();
    });

    $('#event_crete_form').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: laroute.route('events.store'),
            method: 'post',
            data: $(this).serialize()
        }).done(function (response) {
            console.log(response);
            if (response.success) {
                calendar.fullCalendar('renderEvent', response.event);
                $('#event-create').closeModal();
                Materialize.toast(response.message, 4000);
            } else {
                Materialize.toast('Deu ruim.', 4000);
            }

        });
    });
});