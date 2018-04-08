'use strict';

var serviceBase = 'http://accred.frontend.server/';

var App = angular.module('App', [
    'ngRoute',
    'mgcrea.ngStrap',
    'SiteApp',
    'ParticipApp',
    'cleave.js'
]);

var SiteApp = angular.module('SiteApp', ['ngRoute', 'ngCookies']);
var ParticipApp = angular.module('ParticipApp', ['ngRoute', 'ngCookies']);

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

App.service('ErrorService', function($location, $q) {
    this.handleError = function (response) {
        if (response.status === 500) {
            this.lastError = response.data.message;
            $location.path("/error" ).replace(); 
        } else {
            return $q.reject(response);
        }
        
    };
});

App.run(["$rootScope", "ErrorService", function($rootScope, ErrorService) {
        return $rootScope.ErrorService = ErrorService;
    }
]);