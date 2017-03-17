$(document).ready(function () {
    $('select').material_select();
    
    $(document).on('change', '#all_day', function () {
        if ($(this).prop('checked')) {
            $('.hide_time').addClass('hide');

            $('#begin-time').attr('disabled', true);
            $('#end-time').attr('disabled', true);

            $('.date_col').removeClass('m3 l3');
            $('.date_col').addClass('m6 l6');
        } else {
            $('.hide_time').removeClass('hide');

            $('#begin-time').attr('disabled', false);
            $('#end-time').attr('disabled', false);

            $('.date_col').removeClass('m6 l6');
            $('.date_col').addClass('m3 l3');
        }
    });

    $(document).on('change', '#include_address', function () {
        if ($(this).prop('checked')) {
            $('.hide_address').removeClass('hide');

            $('#street').attr('disabled', false);
            $('#number').attr('disabled', false);
            $('#district').attr('disabled', false);
            $('#city').attr('disabled', false);
            $('#state').attr('disabled', false);
            $('#country').attr('disabled', false);
        } else {
            $('.hide_address').addClass('hide');

            $('#street').attr('disabled', true);
            $('#number').attr('disabled', true);
            $('#district').attr('disabled', true);
            $('#city').attr('disabled', true);
            $('#state').attr('disabled', true);
            $('#country').attr('disabled', true);
        }
    });

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

    $('.time').mask('23:59', {'translation': {2: {pattern: /[0-2]/}, 3: {pattern: /[0-9]/}, 5: {pattern: /[0-5]/}, 9: {pattern: /[0-9]/}}});

    $('#all_day').trigger('change');
    $('#include_address').trigger('change');

    

});

