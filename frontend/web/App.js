'use strict';

var serviceBase = 'http://accred.frontend.server/';

var App = angular.module('App', [
    'ngRoute',
    'mgcrea.ngStrap',
    'SiteApp',
    'ParticipApp'
]);

var SiteApp = angular.module('SiteApp', ['ngRoute']);
var ParticipApp = angular.module('ParticipApp', ['ngRoute']);

/// Token injector

App.factory('authInterceptor', function ($q, $window, $location) {
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


/// Error handler

App.config(function($controllerProvider, $httpProvider) {
    $controllerProvider.register('ErrorController', ['$scope', '$rootScope', 'ErrorService',
        function($scope, $rootScope, ErrorService) {
            $scope.errorMessage = ErrorService.lastError;
        }]);
    $httpProvider.interceptors.push('authInterceptor');
});

App.service('ErrorService', function($location) {
    this.printError = function (error) {
        this.lastError = error.data.message;
        //errorMessage[0] = "code: " + error.data.code;
        //errorMessage[1] = "file: " + error.data.file;
        //errorMessage[2] = "line: " + error.data.line;
        //errorMessage[3] = "message: " + error.data.message; 
        $location.path("/error" ).replace();
    };
});

App.run(["$rootScope", "ErrorService", function($rootScope, ErrorService) {
        return $rootScope.ErrorService = ErrorService;
    }
]);