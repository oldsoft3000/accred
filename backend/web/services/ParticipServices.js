'use strict';

ParticipControllers.factory('ParticipServices', ['$http', '$window', '$location', '$q', 
    function($http, $window, $location, $q) {
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
        
        obj.update = function(modelUser) {
            return $http.put('particips/' + modelUser.id, modelUser).then(function(response) {
                return response;
            });
        };
        
        return obj; 
    }
]);
