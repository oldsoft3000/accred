'use strict';

SiteApp.config(['$routeProvider', '$httpProvider',
    function($routeProvider, $httpProvider) {
        $routeProvider.
            when('/', {
                templateUrl: 'views/site/index.html'
            }).
            when('/about', {
                templateUrl: 'views/site/about.html'
            }). 
            when('/contact', {
                templateUrl: 'views/site/contact.html',
                controller: 'ContactController',
            }).
            when('/login', {
                templateUrl: 'views/site/login.html',
                controller: 'LoginController',
            }).
            when('/signup', {
                templateUrl: 'views/site/signup.html',
                controller: 'SignupController',
            }).        
            when('/dashboard', {
                templateUrl: 'views/site/dashboard.html',
                controller: 'DashboardController', 
                resolve: {
                    response: function(SiteServices) {
                        return SiteServices.dashboard();
                    }
                }
            }).
            when('/error', {
                templateUrl: 'views/site/error.html',
                controller: 'ErrorController'
            }).
            otherwise({
                templateUrl: 'views/site/404.html'
            });
        $httpProvider.interceptors.push('authInterceptor');
    }
]);

SiteApp.controller('MainController', ['$scope', '$location', '$window',
    function ($scope, $location, $window) {
        $scope.loggedIn = function() {
            return Boolean($window.sessionStorage.access_token);
        };

        $scope.logout = function () {
            delete $window.sessionStorage.access_token;
            $location.path('/login').replace();
            $('#collapsible-sidebar').collapse('hide');
        };
    }
]); 

SiteApp.controller('LoginController', ['$scope', '$window', '$location', 'SiteServices',
    function($scope, $window, $location, SiteServices) {
        $scope.login = function () {
            $scope.dataLoading = true;
            $scope.error = {};
            SiteServices.login($scope.userModel)
                .then(successHandler) 
                .catch(errorHandler);
                function successHandler(response) {
                    $window.sessionStorage.access_token = response.data.access_token;
                    $location.path('/particips').replace();
                    $('#collapsible-sidebar').collapse("show");
                }
                function errorHandler(response) {
                    $scope.dataLoading = false;
                    angular.forEach(response.data, function (error) {
                        $scope.error[error.field] = error.message;
                    });
                }
        };
    }
]);

SiteApp.controller('SignupController', ['$scope', '$window', '$location', 'SiteServices',
    function($scope, $window, $location, SiteServices) {
        $scope.signup = function () {
            if ($scope.userModel && $scope.userModel.password != $scope.password_verify) {
                $scope.error["password_verify"] = "Пароли должны сопадать";
                return;
            }
            $scope.dataLoading = true;
            $scope.error = {};
            SiteServices.signup($scope.userModel)
                .then(successHandler)
                .catch(errorHandler);
                function successHandler(response) {
                    $location.path('/').replace();
                }
                function errorHandler(response) {
                    $scope.dataLoading = false;
                    angular.forEach(response.data, function (error) {
                        $scope.error[error.field] = error.message;
                    });
                }
        };
    }
]);

SiteApp.controller('DashboardController', ['$scope', 'response',
    function ($scope, response) {
        $scope.dashboard = response.data;
    }
]);

SiteApp.controller('ContactController', ['$scope', '$window', 'SiteServices',
    function($scope, $window, SiteServices) {
        $scope.captchaUrl = 'site/captcha';
        $scope.contact = function () {
            $scope.error = {}; 
            $scope.submitted = true;
            SiteServices.contact($scope.contactModel)
                .then(successHandler)
                .catch(errorHandler);
                function successHandler(response) {
                    $scope.contactModel = {};
                    $scope.flash = response.data.flash;
                    $window.scrollTo(0,0);
                    $scope.submitted = false;
                    $scope.captchaUrl = 'site/captcha' + '?' + new Date().getTime();
                }
                function errorHandler(response) {
                    angular.forEach(response.data, function (error) {
                        $scope.error[error.field] = error.message;
                    });
                }
        };
        
        $scope.refreshCaptcha = function() {
            SiteServices.refreshCaptcha()
                .then(successHandler);
                function successHandler(response) {
                   $scope.captchaUrl = response.data.url;
                }
        };
}]);