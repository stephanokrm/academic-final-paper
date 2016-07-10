$(document).ready(function () {
    $('.submit-calendars-delete').click(function(e) {
        e.preventDefault();
        $(this).next('form').submit();
    });
});