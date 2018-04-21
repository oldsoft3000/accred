'use strict';

CarControllers.factory('CarServices', ['$http', '$route', '$q',
    function($http, $route, $q) {
        var obj = {};

        obj.view = function(idParticip) {
            var route = '';
            if (typeof idParticip !== 'undefined') {
                return $http.get("cars/" + idParticip).then(function(response) {
                    return response;   
                });    
            } else {
                return $http.get("cars").then(function(response) {
                    return response;
                });
            }
        };

        obj.create = function(idParticip, modelCar, isUpdate) {
             if (isUpdate) {
                return $http.put('cars/' + idParticip, modelCar).then(function(response) {
                    return response;
                });
            } else {
                modelCar.idParticip = idParticip;

                return $http.post('cars', modelCar).then(function(response) {
                    return response;
                });
            }
        };

        obj.delete = function(id) {
            return $http.delete("cars/" + id).then(function(response) {
                $route.reload();
            });
        };

        return obj;
    }
]);