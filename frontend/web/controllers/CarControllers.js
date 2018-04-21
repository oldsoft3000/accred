'use strict';

CarControllers.config(['$routeProvider', '$httpProvider',
    function($routeProvider, $httpProvider) {
        $routeProvider.
        when('/car/view', {
            templateUrl: 'views/car/view.html',
            controller: 'ViewCarController',
            resolve: {
                response: function(CarServices) {
                    return CarServices.view();
                }
            }
        }).
        when('/car/view/:idParticip', {
            templateUrl: 'views/car/create.html',
            controller: 'CreateCarController',
            resolve: {
                response: function(CarServices, $route) {
                    return CarServices.view($route.current.params.idParticip);
                }
            }
        }).
        otherwise({
            templateUrl: 'views/site/404.html'
        });
        $httpProvider.interceptors.push('authInterceptor');
    }
]);


CarControllers.controller('ViewCarController', [    '$location',
                                                    '$scope',
                                                    '$route',
                                                    'response',
                                                    'CarServices',
    function ($location, $scope, $route, response, CarServices) {
        $scope.idParticip = $route.current.params.idParticip;
        $scope.particips = response.data;
        $scope.delete = function(id) {
            if (confirm("Удалить бронирование") == true && id > 0) {
                CarServices.delete(id);
                $route.reload();
            }
        };
    }
]);

CarControllers.controller('CreateCarController', [  '$location',
                                                    '$scope',
                                                    '$route',
                                                    'response',
                                                    'CarServices',
    function ($location, $scope, $route, response, CarServices) {
        var isUpdate = false;
        $scope.modelCar = {};
        if (response.data === '') {
            $scope.modelCar = {};
            $scope.modelCar.is_particip = 1;
        } else {
            $scope.modelCar = response.data;

            isUpdate = true;
        }

        $scope.create = function() {
            $scope.dataLoading = true;
            $scope.error = {};

            CarServices.create($route.current.params.idParticip, $scope.modelCar, isUpdate)
                .then(successHandler)
                .catch(errorHandler);

            function successHandler(response) {
                $scope.dataLoading = false;
                $location.path('/car/view').replace();
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

        $scope.persoonInfoRequired = function(value) {
            var el = angular.element(document.querySelector('#person-fieldset'));
            if (value === 1) {
                el.attr('disabled', 'disabled');
            } else {
                el.removeAttr('disabled');
            }
            if (typeof $scope.error !== 'undefined') {
                $scope.error['last_name'] = '';
                $scope.error['first_name'] = '';
                $scope.error['middle_name'] = '';
                $scope.error['last_name_latin'] = '';
                $scope.error['first_name_latin'] = '';
                $scope.error['passport_series'] = '';
                $scope.error['passport_number'] = '';
                $scope.error['date_of_birth'] = '';
                $scope.error['place_of_birth'] = '';
            }
        };

        $scope.$watch('modelCar.is_particip', function(newVal, oldVal) {
            $scope.persoonInfoRequired(newVal);
        }, true);

    }
]);
