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
    }
]);

FlightControllers.controller('CreateFlightController', [  '$location',
                                                          '$scope',
                                                          '$route',
                                                          'response',
                                                          'FlightServices',
                                                          'Utils',
    function ($location, $scope, $route, response, FlightServices, Utils) {
        $scope.cities = response[1].data;
        var isUpdate = false;
        if (response[0].data === '') {
            $scope.modelFlight = {};
        } else {
            var offset = new Date().getTimezoneOffset();
            var ad = new Date(response[0].data.arrival_date);
            var dd = new Date(response[0].data.departure_date);

            $scope.modelFlight = response[0].data;
            $scope.modelFlight.arrival_date = ad;
            $scope.modelFlight.arrival_time = ad;
            //$scope.modelFlight.arrival_time.setHours(ad.getHours());
            //$scope.modelFlight.arrival_time.setMinutes(ad.getMinutes());
            $scope.modelFlight.departure_date = dd;
            $scope.modelFlight.departure_time = dd;
            //$scope.modelFlight.departure_time.setHours(dd.getHours());
            //$scope.modelFlight.departure_time.setMinutes(dd.getMinutes());
            isUpdate = true;
        }

        $scope.create = function() {
            $scope.dataLoading = true;
            $scope.error = {};

            if ($scope.modelFlight.arrival_time == null) {
                $scope.error['arrival_time'] = 'Неободимо заполнить «Время прибытия»';
            }
            if ($scope.modelFlight.departure_time == null) {
                $scope.error['departure_time'] = 'Неободимо заполнить «Время отправления';
            }

            var ad = $scope.modelFlight.arrival_date;
            var at = $scope.modelFlight.arrival_time;
            var dd = $scope.modelFlight.departure_date;
            var dt = $scope.modelFlight.departure_time;
            
            if (ad && at) {
                ad.setHours( at.getHours() );
                ad.setMinutes( at.getMinutes() );
            }
            if (dd && dt) {
                dd.setHours( dt.getHours() );
                dd.setMinutes( dt.getMinutes());
            }

            Utils.toUTC($scope.modelFlight.arrival_date);
            Utils.toUTC($scope.modelFlight.departure_date);

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
