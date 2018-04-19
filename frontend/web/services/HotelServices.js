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


        obj.getHotelInfo = function(idHotel, idParticip, isReserved) {
            var p_0 = $http.get("hotel/hotels/" + idHotel);
            var p_1 = $http.get("hotel/rooms/?hotel=" + idHotel);
            var p_2 = $http.get("hotel/room-categories/?hotel=" + idHotel);
            var p_3 = $http.get("hotel/room-types/?hotel=" + idHotel);
            var p_4 = null;
            if (isReserved == "true") {
                p_4 = $http.get("hotels/" + idParticip);
            } 

            return $q.all([p_0, p_1, p_2, p_3, p_4]).then(function(response) {
                return response;   
            });
        };

        obj.reserve = function(modelReserv, idParticip) {
            return $http.post('hotel/reserve/' + idParticip, modelReserv).then(function(response) {
                return response;
            });
        };

        obj.delete = function(id) {
            return $http.delete("hotels/" + id).then(function(response) {
                $route.reload();
            });
        };

        return obj;
    }
]);