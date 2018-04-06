'use strict';

SiteApp.factory('SiteServices', ['$http', '$window', '$location', '$q', '$cookies', 'ErrorService',
    function($http, $window, $location, $q, $cookies, ErrorService) {
        var obj = {};
        obj.login = function (userModel) {
            return $http.post('api/login', userModel)
                .then(successHandler)
                .catch(errorHandler);
                function successHandler(response) {
                    $window.sessionStorage.access_token = response.data.access_token;
                    return response;
                }
                function errorHandler(response) {
                    return $q.reject(response);
                }  
        };
        
        obj.logout = function () {
            delete $window.sessionStorage.access_token;
        };

        obj.signup = function (userModel) {
            return $http.post('api/signup', userModel)
                .then(successHandler)
                .catch(errorHandler);
                function successHandler(response) {
                    return response;
                }
                function errorHandler(response) {
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
        
        obj.isLoggedIn = function() {
            return Boolean($window.sessionStorage.access_token);
        };
        
        obj.isUserAgreed = function() {
            var user_agreed = $cookies.get('user_agreed');
            if (user_agreed === "1") {
                return true;
            } else {
                return false;
            }
        };
        
        obj.resetAgree = function() {
            $cookies.put('user_agreed', '0');
        };
        
        obj.agree = function() {
            var d = new Date();
            var v = new Date();
            v.setDate(d.getDate() + 1);
            $cookies.put('user_agreed', '1', {expires: v});
        };
        
        
        
        return obj; 
    }
]);
