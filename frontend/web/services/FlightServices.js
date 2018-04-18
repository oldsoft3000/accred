'use strict';

FlightControllers.factory('FlightServices', ['$http', '$route', '$q',
    function($http, $route, $q) {
        var obj = {};

        obj.view = function(id) {
            var route = '';
            if (typeof id !== 'undefined') {
                var p_0 = $http.get("flights/" + id);
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

        obj.update = function(id_flight, id_particip, flightModel) {
            /*return $http.put('flight/update/?id_flight=' + id_flight + '&' +
                                            'id_particip=' + id_particip, flightModel).then(function(response) {
                return response;
            });*/

            return $http.put('flights/' + id_flight + '?id_particip=' + id_particip, flightModel ).then(function(response) {
                return response;
            });
        };

        obj.create = function(id_particip, flightModel) {
            flightModel.id_particip = id_particip;
            return $http.put('flights', flightModel).then(function(response) {
                return response;
            });
        };

        return obj;
    }
]);