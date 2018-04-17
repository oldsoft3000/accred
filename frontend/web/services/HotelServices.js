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

        obj.getHotel = function(id) {
            return $http.get("hotel/hotels/" + id).then(function(response) {
                return response;
            });
        };


        obj.getRooms = function(hotel) {
            return $http.get("hotel/rooms/?hotel=" + hotel).then(function(response) {
                return response;
            });
        };

        obj.getHotelRooms = function(hotel) {
            var p_0 = $http.get("hotel/hotels/" + hotel);
            var p_1 = $http.get("hotel/rooms/?hotel=" + hotel);

            return $q.all([p_0, p_1]).then(function(response) {
                return response;   
            });
        };

        return obj;
    }
]);