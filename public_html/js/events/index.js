$(document).ready(function () {

    var events = [];

    $(".collection-item").each(function () {
        var event = {};
        event['title'] = $(this).data('summary');
        event['start'] = $(this).data('start');
        event['end'] = $(this).data('end');
        event['allDay'] = true;

        switch ($(this).data('color')) {
            case 11:
                $(this).addClass('red-event white-text');
                $(this).next('div').addClass('red lighten-1 white-text');
                event['backgroundColor'] = '#dc2127';
                event['borderColor'] = '#dc2127';
                event['textColor'] = '#FFF';
                break;
            case 10:
                $(this).addClass('green-event white-text');
                $(this).next('div').addClass('green lighten-1 white-text');
                event['backgroundColor'] = '#51b749';
                event['borderColor'] = '#51b749';
                event['textColor'] = '#FFF';
                break;
            case 9:
                $(this).addClass('blue-event white-text');
                $(this).next('div').addClass('blue accent-3 white-text');
                event['backgroundColor'] = '#5484ed';
                event['borderColor'] = '#5484ed';
                event['textColor'] = '#FFF';
                break;
            case 8:
                $(this).addClass('grey-event');
                $(this).next('div').addClass('grey lighten-3');
                event['backgroundColor'] = '#e1e1e1';
                event['borderColor'] = '#e1e1e1';
                event['textColor'] = '#000';
                break;
            case 7:
                $(this).addClass('water-blue-event');
                $(this).next('div').addClass('cyan accent-1');
                event['backgroundColor'] = '#46d6db';
                event['borderColor'] = '#46d6db';
                event['textColor'] = '#000';
                break;
            case 6:
                $(this).addClass('light-orange-event');
                $(this).next('div').addClass('red lighten-5');
                event['backgroundColor'] = '#ffb878';
                event['borderColor'] = '#ffb878';
                event['textColor'] = '#000';
                break;
            case 5:
                $(this).addClass('yellow-event');
                $(this).next('div').addClass('yellow lighten-1');
                event['backgroundColor'] = '#fbd75b';
                event['borderColor'] = '#fbd75b';
                event['textColor'] = '#000';
                break;
            case 4:
                $(this).addClass('light-red-event');
                $(this).next('div').addClass('pink lighten-1 white-text');
                event['backgroundColor'] = '#ff887c';
                event['borderColor'] = '#ff887c';
                event['textColor'] = '#000';
                break;
            case 3:
                $(this).addClass('light-pink-event');
                $(this).next('div').addClass('purple lighten-1 white-text');
                event['backgroundColor'] = '#dbadff';
                event['borderColor'] = '#dbadff';
                event['textColor'] = '#000';
                break;
            case 2:
                $(this).addClass('light-green-event');
                $(this).next('div').addClass('teal accent-2');
                event['backgroundColor'] = '#7ae7bf';
                event['borderColor'] = '#7ae7bf';
                event['textColor'] = '#000';
                break;
            case 1:
                $(this).addClass('light-blue-event');
                $(this).next('div').addClass('blue accent-1 white-text');
                event['backgroundColor'] = '#a4bdfc';
                event['borderColor'] = '#a4bdfc';
                event['textColor'] = '#000';
                break;
            default:
                $(this).addClass('default-event');
                $(this).next('div').addClass('default-event');
                event['backgroundColor'] = '#9fe1e7';
                event['borderColor'] = '#9fe1e7';
                event['textColor'] = '#000';
                break;
        }
        events.push(event);
    });

    $('#calendar').fullCalendar({
        eventOrder: "start",
        allDaySlot: true,
        height: "auto",
        header: {center: 'title', right: 'month, agendaWeek, agendaDay', left: 'today prev,next'},
        titleFormat: 'DD MMMM, YYYY',
        lang: 'pt-br',
        events: events,
    });

    var summary = '';

    $(document).on('click', ".collection-item", function () {
        $('#calendar').fullCalendar('gotoDate', $(this).data('start'));
        summary = $(this).data('summary');
        $('.fc-day-grid-event').click();
    });

    var modalHeaderClass;

    $(document).on('click', '.fc-day-grid-event', function (e) {

        e.preventDefault();

        if (summary == '') {
            summary = $(this).children('div').children('span').text();
        }

        $(".collection-item").each(function () {

            if ($(this).data('summary') == summary) {
                modalHeaderClass = $(this).attr('class');

                $('#event').children('.modal-header').addClass(modalHeaderClass);
                $('#event').children('.modal-header').removeClass('collection-item');
                $('#event').children('.modal-header').children('h4').html($(this).data('summary'));

                if ($(this).children('.data-description').length) {
                    $('#event').find('.description').children('p').html($(this).children('.data-description').data('description'));
                } else {
                    $('#event').find('.description').children('p').html('Sem descrição');
                }

                $('#event').find('.event-date').children('p').html($(this).children('.data-dateformated').data('dateformated'));
                $('#event').find('form').attr('action', laroute.route('events.destroy', {id: $(this).data('id')}));
                $('#event').find('.edit-button-event').attr('href', laroute.route('events.edit', {calendar: $(this).data('idcalendar'), id: $(this).data('id')}));
                responsiveModal('event');
                $('#event').openModal();
            }

        });

        return false;
    });

    $(document).on('click', '.close-event-btn', function () {
        $('#event').children('.modal-header').removeClass(modalHeaderClass);
        summary = '';
    });

    $(document).on('click', '.lean-overlay', function () {
        $('#event').children('.modal-header').removeClass(modalHeaderClass);
        summary = '';
    });

});
