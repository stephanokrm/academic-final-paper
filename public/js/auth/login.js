$(document).ready(function () {
    $("#login_form").validate({
        rules: {
            username: {
                required: true,
                maxlength: 255
            },
            password: {
                required: true,
                maxlength: 255
            }
        },
        messages: {
            username: {
                required: 'Este campo é necessário.',
                maxlength: 'Este campo deve conter no máximo 255 caracteres.'
            },
            password: {
                required: 'Este campo é necessário.',
                maxlength: 'Este campo deve conter no máximo 255 caracteres.'
            }
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            var placement = $(element).data('error');
            placement ? $(placement).append(error) : error.insertAfter(element);
        },
        submitHandler: function (form) {
            $(".submit").attr("disabled", true);
            form.submit();
        }
    });

    $('#login_form').bind('change keyup', function () {
        $(this).validate().checkForm() ? $('#submit_login').attr('disabled', false) : $('#submit_login').attr('disabled', true);
    });
});