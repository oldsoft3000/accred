'use strict';

SiteApp.config(['$routeProvider', '$httpProvider',
    function($routeProvider, $httpProvider) {
        $routeProvider.
            when('/', {
                templateUrl: 'partials/index.html'
            }).
            when('/about', {
                templateUrl: 'partials/about.html'
            }). 
            when('/contact', {
                templateUrl: 'partials/contact.html',
                controller: 'ContactController',
            }).
            when('/login', {
                templateUrl: 'partials/login.html',
                controller: 'LoginController',
            }).
            when('/dashboard', {
                templateUrl: 'partials/dashboard.html',
                controller: 'DashboardController', 
                resolve: {
                    response: function(SiteServices) {
                        return SiteServices.dashboard();
                    }
                }
            }).
            when('/error', {
                templateUrl: 'partials/error.html',
                controller: 'ErrorController'
            }).
            otherwise({
                templateUrl: 'partials/404.html'
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
        };
    }
]); 

SiteApp.controller('LoginController', ['$scope', '$window', '$location', 'SiteServices',
    function($scope, $window, $location, SiteServices) {
        $scope.login = function () {
            SiteServices.login($scope.userModel)
                .then(successHandler);
                function successHandler(response) {
                    $window.sessionStorage.access_token = response.data.access_token;
                    $location.path('/dashboard').replace();
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
        $scope.submitted = true;
        $scope.error = {}; 
        $scope.contact = function () {
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