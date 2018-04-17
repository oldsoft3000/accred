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


        obj.getHotelInfo = function(hotel) {
            var p_0 = $http.get("hotel/hotels/" + hotel);
            var p_1 = $http.get("hotel/rooms/?hotel=" + hotel);
            var p_2 = $http.get("hotel/room-categories/?hotel=" + hotel);
            var p_3 = $http.get("hotel/room-types/?hotel=" + hotel);

            return $q.all([p_0, p_1, p_2, p_3]).then(function(response) {
                return response;   
            });
        };

        obj.reserve = function(reservModel, idParticip) {
            return $http.post('hotel/reserve/' + idParticip, reservModel).then(function(response) {
                return response;
            });
        };

        return obj;
    }
]);