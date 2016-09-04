/* global Materialize */

$(document).ready(function () {

    window.onbeforeunload = function () {
        $('.progress').removeClass('hide');
    }

    $(document).ajaxStart(function () {
        $('.progress').removeClass('hide');
    });

    $(document).ajaxStop(function () {
        $('.progress').addClass('hide');
    });

    $(".button-collapse").sideNav();
    $('select').material_select();

    if ($('#message').length) {
        Materialize.toast($('#message').data('message'), 4000);
    }

    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: 15,
        labelMonthNext: 'Próximo Mês',
        labelMonthPrev: 'Mês Anterior',
        labelMonthSelect: 'Selecione o Mês',
        labelYearSelect: 'Selecione o Ano',
        monthsFull: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        weekdaysFull: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
        weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
        weekdaysLetter: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],
        today: 'Hoje',
        clear: 'Limpar',
        close: 'Fechar',
        format: 'dd/mm/yyyy'
    });

    $('.close-sidenav').click(function () {
        $('.button-collapse').sideNav('hide');
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(window).scroll(function () {
        if ($(this).scrollTop() == 0) {
            $('.main-navbar').removeClass('nav-shadow');
        } else {
            if (!$('.main-navbar').hasClass('nav-shadow')) {
                $('.main-navbar').addClass('nav-shadow');
            }
        }
    });

});
