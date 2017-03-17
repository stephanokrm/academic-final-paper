angular
        .module('academic')
        .controller('RegisterController', ['$scope', '$location', '$mdToast', 'userService', 'teamService', '$rootScope', function ($scope, $location, $mdToast, userService, teamService, $rootScope) {

                function showToast(message) {
                    $mdToast.show($mdToast.simple()
                            .textContent(message)
                            .position('bottom right')
                            .hideDelay(4000));
                }

                $scope.userName = userService.getCurrentUser().name;

                teamService.getAll(function (response) {
                    $scope.teams = response;
                }, function () {
                    showToast('Ocorreram alguns erros durante a comunicação com o serviço. Tente mais tarde.');
                });

                $scope.doRegister = function () {
                    userService.update(
                            userService.getCurrentUser().id,
                            $scope.user,
                            function (response) {
                                showToast('Registro efetuado com sucesso!');
                                $location.path('/');
                            },
                            function (response) {
                                showToast('Login efetuado com sucesso!');
                                alert('Algo deu errado com o processo de registro. Tente mais tarde.');
                            });

                };
            }]);