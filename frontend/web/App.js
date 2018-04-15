'use strict';

var App = angular.module('App', [
    'ngRoute',
    'mgcrea.ngStrap',
    'SiteApp',
    'ParticipApp',
    'cleave.js',
    'angular-img-cropper'
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
        if (response.status == 422) {
             return $q.reject(response);
        }

        this.lastError = response.data;
        $location.path("/error" ).replace(); 
        return $q.reject(response);
    };
});

App.run(["$rootScope", "ErrorService", function($rootScope, ErrorService) {
        return $rootScope.ErrorService = ErrorService;
    }
]);





App.directive('onlyLatin', function () {
    return {
      require: 'ngModel',
      link: function (scope, element, attr, ctrl) {
        function inputValue(val) {
            var transformedInput = val.replace(/[^/.,:0-9a-zA-Z\s]/g, '');
            //console.log(transformedInput);
            if (transformedInput !== val) {
              ctrl.$setViewValue(transformedInput);
              ctrl.$render();
            }
            return transformedInput;
        }            
        ctrl.$parsers.push(inputValue);
      }
    };
});
