'use strict';

HotelControllers.factory('HotelServices', ['$http', '$route', '$q',
    function($http, $route, $q) {
        var obj = {};

        obj.view = function() {
            return $http.get("hotels").then(function(response) {
                return response;
            });
        };

        obj.getHotels = function() {
            return $http.get("hotel/hotels").then(function(response) {
                return response;
            });
        };



        return obj;
    }
]);