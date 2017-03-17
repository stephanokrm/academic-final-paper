angular
        .module('academic')
        .factory('userService', ['localStorageService', 'Restangular', function (localStorageService, Restangular) {

                function isLoggedIn() {
                    return localStorageService.get('user') ? true : false;
                }

                function authenticate(data, onSuccessActive, onSuccessInactive, onError) {
                    Restangular.all(laroute.route('users.authenticate')).post(data).then(function (user) {
                        if (Object.keys(user).length > 0) {
                            localStorageService.set('user', user);
                            user.active == true ? onSuccessActive(user) : onSuccessInactive(user);
                        }
                    }, function (response) {
                        onError(response);
                    });

                }

                function update(userId, data, onSuccess, onError) {

                    Restangular.one(laroute.route('users.update', {users: userId})).customPUT(data).then(function (user) {
                        localStorageService.set('user', user);
                        onSuccess(user);
                    }, function (response) {
                        onError(response);
                    });

                }

                function getByTeam(onSuccess, onError) {
                    Restangular.all(laroute.route('users.byTeam')).getList().then(function (users) {
                        onSuccess(users);
                    }, function (response) {
                        onError(response);
                    });
                }

                function logout() {
                    Restangular.one(laroute.route('users.logout')).get();
                    localStorageService.clearAll();
                }

                function getCurrentUser() {
                    return localStorageService.get('user');
                }

                function isActive() {
                    return getCurrentUser().active == true ? true : false;
                }

                function isTeacher() {
                    return getCurrentUser().teacher == null ? false : true;
                }

                return {
                    isLoggedIn: isLoggedIn,
                    authenticate: authenticate,
                    update: update,
                    logout: logout,
                    getCurrentUser: getCurrentUser,
                    isActive: isActive,
                    isTeacher: isTeacher,
                    getByTeam: getByTeam
                };

            }]);
