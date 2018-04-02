'use strict';

var app = angular.module('app', [
    'ngRoute',          //$routeProvider
    'mgcrea.ngStrap',   //bs-navbar, data-match-route directives
    'controllers'       //Our module frontend/web/js/controllers.js
]);

app.config(['$routeProvider', '$httpProvider', '$logProvider', '$rootScopeProvider',
    function($routeProvider, $httpProvider, $logProvider) {
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
                    pageData: function($http, $rootScope) {
                        return $http.get('api/dashboard').then(function (response) {
                            return response.data;
                        }).catch(function(response) {
                            $rootScope.errorService.printError(response.data);
                        });
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

app.factory('authInterceptor', function ($q, $window, $location) {
    return {
        request: function (config) {
            if ($window.sessionStorage.access_token) {
                //HttpBearerAuth
                config.headers.Authorization = 'Bearer ' + $window.sessionStorage.access_token;
            }
            return config;
        },
        responseError: function (rejection) {
            if (rejection.status === 401) {
                $location.path('/login').replace();
            }
            return $q.reject(rejection);
        }
    };
});



app.config(function($controllerProvider) {
        $controllerProvider.register('ErrorController', ['$scope', '$rootScope', 'errorService',
            function($scope, $rootScope, errorService) {
                $scope.errorMessage = errorService.lastError;
            }]);
    });

app.service('errorService', function($location) {
    this.printError = function (error) {
        this.lastError = error;
        //errorMessage[0] = "code: " + error.data.code;
        //errorMessage[1] = "file: " + error.data.file;
        //errorMessage[2] = "line: " + error.data.line;
        //errorMessage[3] = "message: " + error.data.message; 
        $location.path("/error" ).replace();
    };
});

app.run(["$rootScope", "errorService", function($rootScope, errorService) {
    return $rootScope.errorService = errorService;
  }
]);