$(document).ready(function () {


    $('.delete-action').click(function () {
        $('.form-delete').submit();
    });


    $("input[type='checkbox']").change(function () {
        var count = $("input[type='checkbox']:checked").length;
        if (count > 0) {
            $('.main-navbar').addClass('hide');
            $('.second-navbar').removeClass('hide');
            if (count > 1) {
                $('.count').html(count + ' itens selecionados.');
            } else {
                $('.count').html('1 item selecionado.');
            }

        } else {
            $('.second-navbar').addClass('hide');
            $('.main-navbar').removeClass('hide');
        }
    });
//
    $("input[type='checkbox']").change(function () {
        ;
        if ($(this).prop('checked')) {
            $(this).parent('div').parent('div').parent('li').addClass('selected-collapsible-header');
        } else {
            $(this).parent('div').parent('div').parent('li').removeClass('selected-collapsible-header');
        }
    });


    $("input[type='checkbox']").trigger('change');
});