$(document).ready(function () {

    $("input[name='color']").each(function () {
        switch ($(this).val()) {
            case '11':
                $(this).addClass('red-event');
                break;
            case '10':
                $(this).addClass('green-event');
                break;
            case '9':
                $(this).addClass('blue-event');
                break;
            case '8':
                $(this).addClass('grey-event');
                break;
            case '7':
                $(this).addClass('water-blue-event');
                break;
            case '6':
                $(this).addClass('light-orange-event');
                break;
            case '5':
                $(this).addClass('yellow-event');
                break;
            case '4':
                $(this).addClass('light-red-event');
                break;
            case '3':
                $(this).addClass('light-pink-event');
                break;
            case '2':
                $(this).addClass('light-green-event');
                break;
            case '1':
                $(this).addClass('light-blue-event');
                break;
        }
    });

    $('#description').characterCounter();


});

