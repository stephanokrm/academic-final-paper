(function () {
    'use strict';

    angular
        .module('academic')
        .controller('RegisterController', RegisterController);

    RegisterController.$inject = ['$location', '$mdToast', 'UserService', 'TeamService'];
    function RegisterController($location, $mdToast, UserService, TeamService) {
        let vm = this;

        function showToast(message) {
            $mdToast.show($mdToast.simple()
                .textContent(message)
                .position('bottom right')
                .hideDelay(4000));
        }

        vm.userName = UserService.getCurrentUser().name;

        TeamService.getAll(function (response) {
            vm.teams = response;
        }, function () {
            showToast('Ocorreram alguns erros durante a comunicação com o serviço. Tente mais tarde.');
        });

        vm.doRegister = function () {
            UserService.update(
                UserService.getCurrentUser().id,
                vm.user,
                () => {
                    showToast('Registro efetuado com sucesso!');
                    $location.path('/');
                },
                () => {
                    showToast('Login efetuado com sucesso!');
                    alert('Algo deu errado com o processo de registro. Tente mais tarde.');
                });

        };
    }

})();