/* global Materialize */

$(document).ready(function () {
    var ids = [];
    var calendar;
    var eventModal = $('#event');
    var route = laroute.route('events.index');

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

//    $("#select_all").click(function () {
//        $('.checkbox-calendar').prop('checked', this.checked);
//        $("input[type='checkbox']").trigger('change');
//
//    });
//
//    $(".checkbox-calendar").click(function () {
//        if (!$(this).prop('checked')) {
//            $('#select_all').prop('checked', this.checked);
//        }
//    });
//
//
//    $('.delete-action').click(function () {
//        $('.form-delete').submit();
//    });
//
//
//    $("input[type='checkbox']").change(function () {
//        var count = $(".checkbox-calendar:checked").length;
//        if (count > 0) {
//            $('.main-navbar').addClass('hide');
//            $('.second-navbar').removeClass('hide');
//            if (count > 1) {
//                $('.count').html(count + ' itens selecionados.');
//            } else {
//                $('.count').html('1 item selecionado.');
//            }
//
//        } else {
//            $('.second-navbar').addClass('hide');
//            $('.main-navbar').removeClass('hide');
//        }
//    });
//
//    $("input[type='checkbox']").change(function () {
//        if ($(this).prop('checked')) {
//            $(this).parent('div').parent('td').parent('tr').addClass('selected-td');
//        } else {
//            $(this).parent('div').parent('td').parent('tr').removeClass('selected-td');
//        }
//    });
//
//
//    $("input[type='checkbox']").trigger('change');

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
});