'use strict';

TicketControllers.factory('TicketServices', ['$http', '$route', '$q',
    function($http, $route, $q) {
        var obj = {};

        obj.view = function(idParticip) {
            var route = '';
            if (typeof idParticip !== 'undefined') {
                return $http.get("tickets/" + idParticip).then(function(response) {
                    return response;   
                });    
            } else {
                return $http.get("tickets").then(function(response) {
                    return response;
                });
            }
        };

        obj.create = function(idParticip, modelTicket, isUpdate) {
             if (isUpdate) {
                return $http.put('tickets/' + idParticip, modelTicket).then(function(response) {
                    return response;
                });
            } else {
                modelTicket.idParticip = idParticip;

                return $http.post('tickets', modelTicket).then(function(response) {
                    return response;
                });
            }
        };

        obj.delete = function(id) {
            return $http.delete("tickets/" + id).then(function(response) {
                $route.reload();
            });
        };

        return obj;
    }
]);