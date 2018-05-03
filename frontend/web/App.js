'use strict';

var App = angular.module('App', [
    'ngRoute',
    'ngResource',
    'ngSanitize',
    'mgcrea.ngStrap',
    'cleave.js',
    'moment-picker',
    'SiteControllers',
    'ParticipControllers',
    'HotelControllers',
    'FlightControllers',
    'TicketControllers',
    'CarControllers',
]);

var Utils = angular.module('Utils', []);
var SiteControllers = angular.module('SiteControllers', ['ngRoute', 'ngCookies']);
var ParticipControllers = angular.module('ParticipControllers', ['ngRoute', 'ngCookies']);
var HotelControllers = angular.module('HotelControllers', ['ngRoute', 'ngCookies']);
var FlightControllers = angular.module('FlightControllers', ['ngRoute', 'ngCookies']);
var TicketControllers = angular.module('TicketControllers', ['ngRoute', 'ngCookies']);
var CarControllers = angular.module('CarControllers', ['ngRoute', 'ngCookies']);
/// Token injectors

App.factory('authInterceptor', function ($q, $window, $location) {
    var data = {
        lastError: ''
    };
    return {
        data: data,
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
            } else {
                data.lastError = response;  
                $location.path("/error" ).replace(); 
            }
            
            return $q.reject(response);
        }
      
    };
});

App.factory('ViewData', ['$resource', function($resource) {
    return $resource('views/view.json');
}]);


App.factory('HotelData', ['$resource', function($resource) {
    return $resource('views/hotel.json');
}]);

App.factory('Countries', ['$resource', function($resource) {
    return $resource('views/country.json');
}]);

App.factory('BadgeData', ['$resource', function($resource) {
    return $resource('views/badge.json');
}]);


App.config(function($httpProvider){
  $httpProvider.defaults.headers.common['Cache-Control'] = 'no-cache';
  $httpProvider.defaults.cache = false;

  if (!$httpProvider.defaults.headers.get) {
      $httpProvider.defaults.headers.get = {};
  }
  $httpProvider.defaults.headers.get['If-Modified-Since'] = '0';
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
