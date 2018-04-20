'use strict';

TicketControllers.config(['$routeProvider', '$httpProvider',
    function($routeProvider, $httpProvider) {
        $routeProvider.
        when('/ticket/view', {
            templateUrl: 'views/ticket/view.html',
            controller: 'ViewTicketController',
            resolve: {
                response: function(TicketServices) {
                    return TicketServices.view();
                }
            }
        }).
        when('/ticket/view/:idParticip', {
            templateUrl: 'views/ticket/create.html',
            controller: 'CreateTicketController',
            resolve: {
                response: function(TicketServices, $route) {
                    return TicketServices.view($route.current.params.idParticip);
                }
            }
        }).
        otherwise({
            templateUrl: 'views/site/404.html'
        });
        $httpProvider.interceptors.push('authInterceptor');
    }
]);


TicketControllers.controller('ViewTicketController', [ '$location',
                                                        '$scope',
                                                        '$route',
                                                        'response',
                                                        'TicketServices',
    function ($location, $scope, $route, response, TicketServices) {
        $scope.idParticip = $route.current.params.idParticip;
        $scope.particips = response.data;
        $scope.delete = function(id) {
            if (confirm("Удалить бронирование") == true && id > 0) {
                TicketServices.delete(id);
                $route.reload();
            }
        };
    }
]);

TicketControllers.controller('CreateTicketController', [  '$location',
                                                          '$scope',
                                                          '$route',
                                                          'response',
                                                          'TicketServices',
    function ($location, $scope, $route, response, TicketServices) {
        var isUpdate = false;
        $scope.modelTicket = {};
        if (response.data === '') {
            $scope.modelTicket = {};
        } else {
            $scope.modelTicket = response.data;

            isUpdate = true;
        }

        $scope.create = function() {
            $scope.dataLoading = true;
            $scope.error = {};

            TicketServices.create($route.current.params.idParticip, $scope.modelTicket, isUpdate)
                .then(successHandler)
                .catch(errorHandler);

            function successHandler(response) {
                $scope.dataLoading = false;
                $location.path('/ticket/view').replace();
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
