'use strict';

ParticipControllers.factory('ParticipServices', ['$http', '$route', '$q',
    function($http, $route, $q) {
        var obj = {};

        obj.create = function(userModel) {
            return $http.post('particips', userModel).then(function(response) {
                return response;
            });
        };

        obj.update = function(userModel) {
            return $http.put('particips/' + userModel.id, userModel).then(function(response) {
                return response;
            });
        };

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

        obj.delete = function(id) {
            return $http.delete("particips/" + id).then(function(response) {
                $route.reload();
            });
        };

        return obj;
    }
]);