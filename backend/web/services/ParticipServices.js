'use strict';

ParticipControllers.factory('ParticipServices', ['$http', '$window', '$location', '$q', '$route', 
    function($http, $window, $location, $q, $route) {
        var obj = {};

        obj.view = function(id) {
            var route = '';
            if (typeof id !== 'undefined') {
                route = "particips/" + id;
            } else {
                route = "particips";
            }
            return $http.get(route).then(function(response) {
                return response;
            });
        };
        
        obj.update = function(modelParticip) {
            return $http.put('particips/' + modelParticip.id, modelParticip).then(function(response) {
                return response;
            });
        };


        obj.delete = function(id) {
            return $http.delete("particips/" + id).then(function(response) {
                $route.reload();
            });
        };

        obj.importParticip = function(modelParticip) {
              return $http.post('particips', modelParticip).then(function(response) {
                return response;
            });
        };

        obj.importHotel = function(modelHotel, idParticip) {
            return $http.post('hotel/reserve/' + idParticip, modelHotel).then(function(response) {
                return response;
            });
        };

        obj.importFlight = function(modelFlight, idParticip) {
            modelFlight.idParticip = idParticip;
            return $http.post('flights', modelFlight).then(function(response) {
                return response;
            });
        };

        obj.importTicket = function(modelTicket, idParticip) {
            modelTicket.idParticip = idParticip;
            return $http.post('tickets', modelTicket).then(function(response) {
                return response;
            });
        };

        obj.importCar = function(modelCar, idParticip) {
            modelCar.idParticip = idParticip;
            return $http.post('cars', modelCar).then(function(response) {
                return response;
            });
        };

        obj.lockCard = function(idParticip) {
            var data = {};
            var utc = new Date().toJSON().slice(0,10).replace(/-/g,'/');
            data.locked_date = new Date().toLocaleString();
            return $http.post('particip/lock/' + idParticip).then(function(response) {
                return response;
            });
        }

        obj.unlockCard = function(idParticip) {
            return $http.post('particip/unlock/' + idParticip).then(function(response) {
                return response;
            });
        }
        return obj; 
    }
]);
