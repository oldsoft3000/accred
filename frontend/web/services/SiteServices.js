'use strict';

SiteApp.factory('SiteServices', ['$http', '$window', '$location', '$q', 'ErrorService',
    function($http, $window, $location, $q, ErrorService) {
        var obj = {};
        obj.login = function (userModel) {
            return $http.post('api/login', userModel)
                .then(successHandler)
                .catch(errorHandler);
                function successHandler(response) {
                    return response;
                }
                function errorHandler(response) {
                    ErrorService.printError(response);
                    return $q.reject(response);
                }
        };
        
        obj.dashboard = function () {
            return $http.get('api/dashboard')
                .then(successHandler)
                .catch(errorHandler);
                function successHandler(response) {
                    return response;
                }
                function errorHandler(response) {
                    ErrorService.printError(response);
                    return $q.reject(response);
                }
        };
        
        obj.contact = function ( contactModel ) {
            return $http.post('api/contact', contactModel)  
                .then(successHandler)
                .catch(errorHandler);
                function successHandler(response) {
                    return response;
                }
                function errorHandler(response) {
                    //return response;
                    //ErrorService.printError(response);
                    return $q.reject(response);
                }
        };
        
        
        obj.refreshCaptcha = function() {
            return $http.get('site/captcha?refresh=1')
                .then(successHandler)
                .catch(errorHandler);
                function successHandler(response) {
                    return response;
                }
                function errorHandler(response) {
                    ErrorService.printError(response);
                    return $q.reject(response);
                }
        };
        
        
        return obj; 
    }
]);
