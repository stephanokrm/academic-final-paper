$(document).ready(function () {
    $("input[name='birth_date']").mask('39/19/0000', {'translation': {3: {pattern: /[0-3]/}, 1: {pattern: /[0-1]/}, 9: {pattern: /[0-9]/}}});
});

