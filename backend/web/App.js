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
    'datatables'
]);


var SiteControllers = angular.module('SiteControllers', ['ngRoute', 'ngCookies']);
var ParticipControllers = angular.module('ParticipControllers', ['ngRoute', 'ngCookies']);

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


App.config(function($httpProvider){
  $httpProvider.defaults.headers.common['Cache-Control'] = 'no-cache';
  $httpProvider.defaults.cache = false;

  if (!$httpProvider.defaults.headers.get) {
      $httpProvider.defaults.headers.get = {};
  }
  $httpProvider.defaults.headers.get['If-Modified-Since'] = '0';
});

