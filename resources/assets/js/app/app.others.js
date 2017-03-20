/* global NaN, moment */

angular
    .module('academic')
    .constant('DEFAULT_ERROR_MESSAGE', 'Algo deu errado. Verifique novamente mais tarde.');

angular
    .module('academic')
    .config(function ($mdThemingProvider) {
        $mdThemingProvider.theme('default')
            .primaryPalette('light-blue', {
                'default': '600'
            })
            .accentPalette('light-blue', {
                'default': '700'
            });
    });

angular
    .module('academic')
    .config(function ($mdDateLocaleProvider) {
        $mdDateLocaleProvider.months = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', ' Dezembro'];
        $mdDateLocaleProvider.shortMonths = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', ' Dez'];
        $mdDateLocaleProvider.days = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
        $mdDateLocaleProvider.shortDays = ['Do', 'Se', 'Te', 'Qu', 'Qu', 'Se', 'Sá'];
        $mdDateLocaleProvider.firstDayOfWeek = 1;

        $mdDateLocaleProvider.formatDate = function (date) {
            return date ? moment(date).format('DD/MM/YYYY') : '';
        };

        $mdDateLocaleProvider.parseDate = function (dateString) {
            var m = moment(dateString, 'DD/MM/YYYY', true);
            return m.isValid() ? m.toDate() : new Date(NaN);
        };
    });

angular.module('academic')
    .config(['cfpLoadingBarProvider', function (cfpLoadingBarProvider) {
        cfpLoadingBarProvider.includeSpinner = false;
    }]);


