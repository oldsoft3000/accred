'use strict';

SiteControllers.factory('SiteServices', ['$http', '$window', '$location', '$q', '$cookies', 
    function($http, $window, $location, $q, $cookies) {
        var obj = {};
        obj.login = function (modelUser) {
            return $http.post('site/login', modelUser).then(function(response) {
                $window.sessionStorage.access_token = response.data.access_token;
                return response;
            });
        };
        
        obj.logout = function () {
            delete $window.sessionStorage.access_token;
        };

        obj.signup = function (modelUser) {
            return $http.post('site/signup', modelUser).then(function(response) {
                return response;
            });
        }; 
        
        obj.dashboard = function () {
            return $http.get('site/dashboard').then(function(response) {
                return response;
            });
        };
        
        obj.contact = function ( contactModel ) {
            return $http.post('site/contact', contactModel).then(function(response) {
                return response;
            });
        };
        
        
        obj.refreshCaptcha = function() {
            return $http.get('site/captcha?refresh=1').then(function(response) {
                return response;
            });
        };  
        
        obj.isLoggedIn = function() {
            return Boolean($window.sessionStorage.access_token);
        };
        
        /*obj.isUserAgreed = function() {
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
            v.setDate(d.getDate() + 365);
            $cookies.put('user_agreed', '1', {expires: v});
        };*/

        obj.isUserAgreed = function() {
            if ($window.sessionStorage.is_agreed == 1) {
                return true;
            } else {
                return false;
            }
        }

        obj.resetUserAgreed = function() {
             $window.sessionStorage.is_agreed = '';
        };

        obj.getUserAgreed = function() {
            if ($window.sessionStorage.is_agreed !== '') {
                return $q.resolve( isUserAgreed() );
            } else {
                return $http.post('site/get-agreed').then(function(response) {
                    $window.sessionStorage.is_agreed = response.data.is_agreed;
                    return response.data.is_agreed;
                });
            }
        };

        obj.setUserAgreed = function() {
            return $http.post('site/set-agreed').then(function(response) {
                $window.sessionStorage.is_agreed = 1;
                return response;
            });
        };

        return obj; 
    }
]);
