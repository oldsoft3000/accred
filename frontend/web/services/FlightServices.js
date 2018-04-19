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
            var ad = modelFlight.arrival_date;
            var at = modelFlight.arrival_time;
            var dd = modelFlight.departure_date;
            var dt = modelFlight.departure_time;
            
            var offset = new Date().getTimezoneOffset();
            if (ad && at) {
                ad.setHours( at.getHours() - offset / 60 );
                ad.setMinutes( at.getMinutes() );
            }
            if (dd && dt) {
                dd.setHours( dt.getHours() - offset /60 );
                dd.setMinutes( dt.getMinutes());
            }

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