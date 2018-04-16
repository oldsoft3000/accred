'use strict';

var App = angular.module('App', [
    'ngRoute',
    'mgcrea.ngStrap',
    'SiteControllers',
    'ParticipControllers',
    'HotelControllers',
    'cleave.js',
]);

var SiteControllers = angular.module('SiteControllers', ['ngRoute', 'ngCookies']);
var ParticipControllers = angular.module('ParticipControllers', ['ngRoute', 'ngCookies']);
var HotelControllers = angular.module('HotelControllers', ['ngRoute', 'ngCookies']);
/// Token injector

App.factory('authInterceptor', function ($q, $window, $location) {
    var data = {
        lastError: ''
    };
    return {
        data,
        request: function (config) {
            if ($window.sessionStorage.access_token) {
                //HttpBearerAuth
                config.headers.Authorization = 'Bearer ' + $window.sessionStorage.access_token;
            }
            return config;
        },
        responseError: function (response) {
            if (response.status == 422) {
                return $q.reject(response);
            }
            else if (response.status === 401) {
                $location.path('/login').replace();
            } else if (response.status === 404) {
                $location.path("views/site/404.html" ).replace();
                return $q.reject(response);
            } else {
                data.lastError = response.data;  
                $location.path("/error" ).replace(); 
            }
            
            return $q.reject(response);
        }
      
    };
});


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
