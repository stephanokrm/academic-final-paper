$(document).ready(function () {
    $("#invite_all").click(function () {
        $('.invite').prop('checked', this.checked);
    });

    $(".invite").click(function () {
        if (!$(this).prop('checked')) {
            $('#invite_all').prop('checked', this.checked);
        }
    });

});

