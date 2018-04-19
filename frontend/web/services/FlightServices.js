'use strict';

FlightControllers.factory('FlightServices', ['$http', '$route', '$q',
    function($http, $route, $q) {
        var obj = {};

        obj.view = function(idParticip) {
            var route = '';
            if (typeof idParticip !== 'undefined') {
                var p_0 = $http.get("flights/" + idParticip);
                var p_1 = $http.get("site/cities");

                return $q.all([p_0, p_1]).then(function(response) {
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

        return obj;
    }
]);