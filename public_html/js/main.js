/* global Materialize */

$(document).ready(function () {
    $(".button-collapse").sideNav();

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
});

function responsiveModal(id) {
    if ($(window).width() > 768) {
        $('#' + id).removeClass('bottom-sheet');
    } else {
        $('#' + id).addClass('bottom-sheet');
    }
}
