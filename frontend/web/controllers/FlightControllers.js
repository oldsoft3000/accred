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
        when('/flight/view/:id', {
            templateUrl: 'views/flight/create.html',
            controller: 'CreateFlightController',
            resolve: {
                response: function(FlightServices, $route) {
                    return FlightServices.view($route.current.params.id);
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
                                                        'response',
                                                        'FlightServices',
    function ($location, $scope, response, FlightServices) {
        $scope.particips = response.data;
    }
]);

FlightControllers.controller('CreateFlightController', [  '$location',
                                                          '$scope',
                                                          'response',
                                                          'FlightServices',
    function ($location, $scope, response, FlightServices) {
        $scope.flightModel = response[0].data;
        $scope.cities = response[1].data;

        $scope.create = function() {
            $scope.dataLoading = true;
            $scope.error = {};
            HotelServices.create($scope.flightModel, 1)
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
