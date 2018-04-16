'use strict';

ParticipControllers.factory('ParticipServices', ['$http', '$route', '$q',
    function($http, $route, $q) {
        var obj = {};

        obj.create = function(userModel) {
            return $http.post('particips', userModel).then(function(response) {
                return response;
            });

            ParticipApp.controller('ViewController', ['$scope', '$http', '$route', 'response', 'ParticipServices',
                function($scope, $http, $route, response, ParticipServices) {
                    $scope.particips = response.data;
                    $scope.delete = function(id) {
                        if (confirm("Удалить участника: " + id) == true && id > 0) {
                            ParticipServices.delete(id);
                            $route.reload();
                        }
                    };

                    $scope.showPhoto = function(userModel) {
                        $scope.userModel = userModel;
                        $('#myModal').modal('toggle')
                    };
                }
            ]);
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