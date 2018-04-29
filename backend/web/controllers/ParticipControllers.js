'use strict';

ParticipControllers.config(['$routeProvider', '$httpProvider',
    function($routeProvider, $httpProvider) {
        $routeProvider.
        when('/particip/view', {
            templateUrl: 'views/particip/view.html',
            controller: 'ViewController',
            resolve: {
                response: function(ParticipServices) {
                    return ParticipServices.view();
                }
            }
        }).
        otherwise({
            templateUrl: 'views/site/404.html'
        });
        $httpProvider.interceptors.push('authInterceptor');
    }
]);

ParticipControllers.controller('ViewController', ['$scope', '$http', '$route', 'response', 'ParticipServices',
    function($scope, $http, $route, response, ParticipServices) {
        $scope.particips = response.data;
        $scope.delete = function(id) {
            if (confirm("Удалить участника: " + id) == true && id > 0) {
                ParticipServices.delete(id);
                $route.reload();
            }
        };

        $scope.showPhoto = function(modelUser) {
            $scope.modelUser = modelUser;
            $('#myModal').modal('toggle')
        };
    }
]);
