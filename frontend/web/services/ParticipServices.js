'use strict';

ParticipControllers.factory('ParticipServices', ['$http', '$route', '$q',
    function($http, $route, $q) {
        var obj = {};

        obj.create = function(modelUser) {
            return $http.post('particips', modelUser).then(function(response) {
                return response;
            });
        };

        obj.update = function(modelUser) {
            return $http.put('particips/' + modelUser.id, modelUser).then(function(response) {
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