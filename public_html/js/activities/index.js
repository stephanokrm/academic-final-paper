$(document).ready(function () {

    $("#select_all").click(function () {
        $('.activity-item').prop('checked', this.checked);
        $("input[type='checkbox']").trigger('change');

    });

    $(".activity-item").click(function () {
        if (!$(this).prop('checked')) {
            $('#select_all').prop('checked', this.checked);
        }
    });

    $('.delete-action').click(function () {
        $('.form-delete').submit();
    });

    $("input[type='checkbox']").change(function () {
        var count = $(".activity-item:checked").length;
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

    $("input[type='checkbox']").change(function () {
        if ($(this).prop('checked')) {
            $(this).parent('div').parent('td').parent('tr').addClass('selected-td');
        } else {
            $(this).parent('div').parent('td').parent('tr').removeClass('selected-td');
        }
    });


    $("input[type='checkbox']").trigger('change');
});