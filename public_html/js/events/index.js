/* global Materialize */

$(document).ready(function () {

    var calendar;
    var eventModal = $('#event');
    var route = laroute.route('events.events', {id: $('#calendar_id').data('id')});
    var json_events;

    $.ajax({
        url: route,
        type: 'get',
        async: false
    }).done(function (events) {
        json_events = events;
    });

    calendar = $('#calendar').fullCalendar({
        displayEventTime: false,
        contentHeight: 750,
        header: {center: '', right: '', left: ''},
        titleFormat: 'DD - MMMM YYYY',
        lang: 'pt-br',
        editable: true,
        droppable: true,
        events: json_events,
        eventClick: function (event, jsEvent, view) {
            createEventModal(event);
        },
        dayClick: function (date, jsEvent, view) {
            alert('Clicked on: ' + date.format());
            $('#events-colletion').load(route);
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
//    });

//    $(document).on('click', '.fc-day-grid-event', function (e) {
//        $(".collection-item").each(function () {
//            eventModal.find('form').attr('action', laroute.route('events.destroy', {id: $(this).data('id')}));
//            eventModal.find('.edit-button-event').attr('href', laroute.route('events.edit', {calendar: $(this).data('idcalendar'), id: $(this).data('id')}));
//        });
//    });

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

    function updateDateInHeader(calendar) {
        var view = calendar.fullCalendar('getView');
        $('#calendar_date').text(view.title);
    }

    function createEventModal(event) {
        var start = event.start.format('MMMM DD, YYYY');
        var end = event.end.format('MMMM DD, YYYY');
        var description = event.description == 'undefined' ? 'Sem descrição' : event.description;
        if (event.start.hasTime()) {
            start = event.start.format('MMMM DD YYYY, HH:SS');
            end = event.end.format('MMMM DD YYYY, HH:SS');
        }
        eventModal.find('.event-title-text').html(event.title);
        eventModal.children('.modal-header').css('background-color', event.backgroundColor);
        eventModal.children('.modal-header').css('color', event.textColor);
        eventModal.find('.event-date').html(start + ' - ' + end);
        eventModal.find('.description').html(description);
        eventModal.openModal();
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

});
