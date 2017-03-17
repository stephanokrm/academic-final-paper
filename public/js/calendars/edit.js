$(document).ready(function () {
    $("#invite_all").click(function () {
        $('.invite').prop('checked', this.checked);
    });

    $(".invite").click(function () {
        if (!$(this).prop('checked')) {
            $('#invite_all').prop('checked', this.checked);
        }
    });
    
    $("#remove_all").click(function () {
        $('.remove').prop('checked', this.checked);
    });

    $(".remove").click(function () {
        if (!$(this).prop('checked')) {
            $('#remove_all').prop('checked', this.checked);
        }
    });

});

