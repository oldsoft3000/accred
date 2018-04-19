'use strict';

HotelControllers.config(['$routeProvider', '$httpProvider',
    function($routeProvider, $httpProvider) {
        $routeProvider.
        when('/hotel/view', {
            templateUrl: 'views/hotel/view.html',
            controller: 'ViewHotelController',
            resolve: {
                response: function(HotelServices) {
                    return HotelServices.view();
                }
            }
        }).
        when('/hotel/reserve_tutorial/:idParticip', {
            templateUrl: 'views/hotel/reserve_tutorial.html',
            controller: 'ReserveHotelTutorialController',
            resolve: {
                response: function(HotelServices) {
                    return HotelServices.getHotels();
                }
            }
        }).
        when('/hotel/reserve/:idParticip/:idHotel', {
            templateUrl: 'views/hotel/reserve.html',
            controller: 'ReserveHotelController',
            resolve: {
                response: function(HotelServices, $route) {
                    return HotelServices.getHotelInfo($route.current.params.idHotel);
                }
            }
        }).
        otherwise({
            templateUrl: 'views/site/404.html'
        });
        $httpProvider.interceptors.push('authInterceptor');
    }
]);


HotelControllers.controller('ViewHotelController', ['$location', '$scope', 'response', 'HotelServices',
    function ($location, $scope, response, HotelServices) {
        $scope.particips = response.data;
    }
]);

HotelControllers.controller('ReserveHotelTutorialController', ['$location',
                                                               '$scope',
                                                               '$route',
                                                               'response',
                                                               'HotelServices', 
    function ($location, $scope, $route, response,  HotelServices) {
        $scope.idParticip = $route.current.params.idParticip;
        $scope.hotels = response.data;

    }
]);

HotelControllers.controller('ReserveHotelController', ['$location',
                                                       '$scope',
                                                       '$route',
                                                       'response',
                                                       'HotelServices', 
    function ($location, $scope, $route, response,  HotelServices) {
        $scope.modelReserv = {};
        $scope.hotel = response[0].data;
        $scope.rooms = response[1].data;
        $scope.categories = response[2].data;
        $scope.types = response[3].data;

        $scope.getName = function(arr, id) {
            for ( var i = 0; i < arr.length; i++ )
                if (arr[i]["id"] === id)                    
                    return arr[i]["name"];
            return false
        };

        $scope.reserveHotel = function() {
            $scope.dataLoading = true;
            $scope.error = {};
            HotelServices.reserve($scope.modelReserv, $route.current.params.idParticip)
                .then(successHandler)
                .catch(errorHandler);

            function successHandler(response) {
                $scope.dataLoading = false;
                $location.path('/hotel/view').replace();
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
