'use strict';

FlightControllers.config(['$routeProvider', '$httpProvider',
    function($routeProvider, $httpProvider) {
        $routeProvider.
        when('/flight/view', {
            templateUrl: 'views/flight/view.html',
            controller: 'ViewFlightController',
            resolve: {
                response: function(FlightServices) {
                    return FlightServices.view();
                }
            }
        }).
        when('/flight/view/:idParticip', {
            templateUrl: 'views/flight/create.html',
            controller: 'CreateFlightController',
            resolve: {
                response: function(FlightServices, $route) {
                    return FlightServices.view($route.current.params.idParticip);
                }
            }
        }).
        otherwise({
            templateUrl: 'views/site/404.html'
        });
        $httpProvider.interceptors.push('authInterceptor');
    }
]);


FlightControllers.controller('ViewFlightController', [  '$location',
                                                        '$scope',
                                                        '$route',
                                                        'response',
                                                        'FlightServices',
    function ($location, $scope, $route, response, FlightServices) {
        $scope.idParticip = $route.current.params.idParticip;
        $scope.particips = response.data;
        $scope.delete = function(id) {
            if (confirm("Удалить полетные данные") == true && id > 0) {
                FlightServices.delete(id);
                $route.reload();
            }
        };
    }
]);

FlightControllers.controller('CreateFlightController', [  '$location',
                                                          '$scope',
                                                          '$route',
                                                          'response',
                                                          'FlightServices',

    function ($location, $scope, $route, response, FlightServices) {
        var isUpdate = false;
        if (response.data === '') {
            $scope.modelFlight = {};
        } else {
            $scope.modelFlight = response.data;
            isUpdate = true;
        }

        $scope.create = function() {
            $scope.dataLoading = true;
            $scope.error = {};

            FlightServices.create($route.current.params.idParticip, $scope.modelFlight, isUpdate)
                .then(successHandler)
                .catch(errorHandler);

            function successHandler(response) {
                $scope.dataLoading = false;
                $location.path('/flight/view').replace();
                return response;
            }

            function errorHandler(response) {
                $scope.dataLoading = false;
                angular.forEach(response.data, function(error) {
                    $scope.error[error.field] = error.message;
                });
                return response;
            }
        };

    }
]);
