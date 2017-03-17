(function () {
    'use strict';

    angular
            .module('academic')
            .controller('LoginController', LoginController);

    LoginController.$inject = ['$state', '$rootScope', '$mdToast', 'userService', 'GoogleService'];
    function LoginController($state, $rootScope, $mdToast, userService, GoogleService) {
        var vm = this;
        vm.user = {};
        vm.doLogin = doLogin;

        function doLogin() {
            GoogleService.createAuthUrl().then(function (url) { 
                $rootScope.googleUrl = url;
                return $rootScope.googleUrl;
            });

            userService.authenticate(
                    vm.user,
                    function () {
                        showToast('Login efetuado com sucesso!');
                        $state.go('home');
                    },
                    function () {
                        $state.go('register');
                    },
                    function (response) {
                        showToast(response.data.authentication);
                        vm.user.password = '';
                    }
            );
        }

        function showToast(message) {
            $mdToast.show($mdToast.simple()
                    .textContent(message)
                    .position('bottom right')
                    .hideDelay(4000));
        }
    }

})();