(function () {
    'use strict';

    angular
            .module('academic')
            .factory('GoogleService', GoogleService);

    GoogleService.$inject = ['$http', '$mdToast', 'localStorageService'];
    function GoogleService($http, $mdToast, localStorageService) {
        var service = {
            createAuthUrl: createAuthUrl,
            getAuthUrl: getAuthUrl,
            authenticate: authenticate,
            checkIfIsLogged: checkIfIsLogged,
            logout: logout,
            showMessage: showMessage
        };

        return service;

        function createAuthUrl() {
            return $http.get(laroute.route('googles.createAuthUrl'))
                    .then(createAuthUrlComplete)
                    .catch(createAuthUrlFailed);

            function createAuthUrlComplete(response) {
                localStorageService.set('url', response.data);
                return response.data;
            }

            function createAuthUrlFailed() {
                showMessage('Ocorreu um erro ao conectar com o Google.');
            }
        }

        function authenticate() {
            return $http.get(laroute.route('googles.authenticate'))
                    .then(authenticateComplete)
                    .catch(authenticateFailed);

            function authenticateComplete(response) {
                localStorageService.set('access_token', response.data);
                showMessage('Autenticação Google realizada com sucesso!');
                return response.data;
            }

            function authenticateFailed() {
                showMessage('Ocorreu um erro ao conectar com o Google.');
            }
        }

        function logout() {
            return $http.get(laroute.route('googles.logout'))
                    .then(logoutComplete)
                    .catch(logoutFailed);

            function logoutComplete(response) {
                localStorageService.remove('access_token');
                showMessage('Você saiu do Google!');
                return response.data;
            }

            function logoutFailed() {
                showMessage('Ocorreu um erro ao sair do Google.');
            }
        }

        function getAuthUrl() {
            return localStorageService.get('url');
        }

        function checkIfIsLogged() {
            return localStorageService.get('access_token') ? true : false;
        }

        function showMessage(message) {
            $mdToast.show($mdToast.simple()
                    .textContent(message)
                    .position('bottom right')
                    .hideDelay(4000));
        }
    }
})();
