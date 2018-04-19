'use strict';

FlightControllers.factory('FlightServices', ['$http', '$route', '$q',
    function($http, $route, $q) {
        var obj = {};

        obj.view = function(idParticip) {
            var route = '';
            if (typeof idParticip !== 'undefined') {
                return $http.get("flights/" + idParticip).then(function(response) {
                    return response;   
                });    
            } else {
                return $http.get("flights").then(function(response) {
                    return response;
                });
            }
        };

        obj.create = function(idParticip, modelFlight, isUpdate) {
             if (isUpdate) {
                return $http.put('flights/' + idParticip, modelFlight).then(function(response) {
                    return response;
                });
            } else {
                modelFlight.idParticip = idParticip;

                return $http.post('flights', modelFlight).then(function(response) {
                    return response;
                });
            }
        };

        obj.delete = function(id) {
            return $http.delete("flights/" + id).then(function(response) {
                $route.reload();
            });
        };

        return obj;
    }
]);