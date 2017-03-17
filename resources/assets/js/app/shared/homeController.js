angular
        .module('academic')
        .controller('HomeController', [
            '$location',
            '$rootScope',
            'GoogleService',
            'localStorageService',
            function ($location, $rootScope, GoogleService, localStorageService) {
                $rootScope.pageTitle = 'Início';
                
                if (!GoogleService.checkIfIsLogged() && getURLParameter('code')) {
                    GoogleService.authenticate().then(function () {
                        $rootScope.google_authenticated = true;
                        $location.path(localStorageService.get('requestedUrl'));
                    });
                }

                function getURLParameter(name) {
                    return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [null, ''])[1].replace(/\+/g, '%20')) || null;
                }

            }]);

