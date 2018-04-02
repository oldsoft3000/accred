'use strict';

var controllers = angular.module('controllers', []);

controllers.controller('MainController', ['$scope', '$location', '$window',
    function ($scope, $location, $window) {
        $scope.loggedIn = function() {
            return Boolean($window.sessionStorage.access_token);
        };

        $scope.logout = function () {
            delete $window.sessionStorage.access_token;
            $location.path('/login').replace();
        };
    }
]);

controllers.controller('ContactController', ['$scope', '$http', '$window',
    function($scope, $http, $window) {
        $scope.captchaUrl = 'site/captcha';
        $scope.contact = function () { 
            $scope.submitted = true;
            $scope.errors = {};   
            $http.post('api/contact', $scope.contactModel).then(
                function (data) {
                    $scope.contactModel = {};
                    $scope.flash = data.flash;
                    $window.scrollTo(0,0);
                    $scope.submitted = false;
                    $scope.captchaUrl = 'site/captcha' + '?' + new Date().getTime();
            }).catch(
                function (data) {
                    angular.forEach(data, function (error) {
                        $scope.errors[error.field] = error.message;
                    });
                }
            );
        };

        $scope.refreshCaptcha = function() {
            $scope.error = {};
            $http.get('site/captcha?refresh=1').then(function(data) {
                $scope.captchaUrl = data.url;
            }).catch(function(data) {
                alert(data.message);
            });
        };
    }]);

controllers.controller('DashboardController', ['$scope', 'pageData',
    function ($scope, pageData) {
        $scope.dashboard = pageData;
    }
]);

controllers.controller('LoginController', ['$scope', '$http', '$window', '$location',
    function($scope, $http, $window, $location) {
        $scope.login = function () {
            $http.post('api/login', $scope.userModel)
                .then( successHandler )
                .catch( errorHandler );
                function successHandler( responce ) {
                    $window.sessionStorage.access_token = responce.data.access_token;
                    $location.path('/dashboard').replace();
                }
                function errorHandler( responce ){
                    $scope.errorService.printError(responce);
                }
        };
    }
]);