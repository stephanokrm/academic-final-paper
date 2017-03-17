(function () {
    'use strict'; 

    angular
            .module('academic')
            .directive('stateLoading', stateLoading);

    stateLoading.$inject = ['$rootScope', '$mdSidenav'];
    function stateLoading($rootScope, $mdSidenav) {
        var directive = {
            link: link,
            restrict: 'E',
            template: "<div class='state-loading' ng-show='isStateLoading' layout='row' layout-sm='column' layout-align='space-around'><md-progress-circular md-mode='indeterminate'></md-progress-circular></div>"
        };
        return directive;

        function link(scope, element, attrs) {
            scope.isStateLoading = false;

            $rootScope.$on('$stateChangeStart', function () {
                if ($mdSidenav('left').isOpen()) {
                    $mdSidenav('left').toggle();
                }
                scope.isStateLoading = true;
            });
            $rootScope.$on('$stateChangeSuccess', function () {
                scope.isStateLoading = false;
            });
        }
    }
})();
(function () {
    'use strict';

    angular
        .module('academic')
        .directive('actionLoading', actionLoading);

    function actionLoading() {
        var directive = {
            restrict: 'E',
            template: "<div class='action-loading' ng-show='isActionLoading' layout='row' layout-sm='column' layout-align='space-around'><md-progress-circular md-diameter='40' md-mode='indeterminate'></md-progress-circular></div>"
        };
        return directive;
    }
})();
(function () {
    'use strict';

    angular
            .module('academic')
            .directive('loader', loader);

    loader.$inject = ['$rootScope'];
    function loader($rootScope) {
        return function ($scope, element, attrs) {
            $scope.$on("loader_show", function () {
                return $rootScope.isActionLoading = true;
//                return element.show();
            });
            return $scope.$on("loader_hide", function () {
                return $rootScope.isActionLoading = false;
//                return element.hide();
            });
        };
    }
})();
//# sourceMappingURL=directives.js.map
