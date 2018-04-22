'use strict';

HotelControllers.factory('HotelServices', ['$http', '$route', '$q', 'HotelData',
    function($http, $route, $q, HotelData) {
        var obj = {};

        obj.view = function() {
            return $http.get("hotels").then(function(response) {
                return response;
            });
        };

        obj.getReservationInfo = function(idParticip) {
            return $http.get("hotels/" + idParticip).then(function(response) {
                return response;
            });
        }

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