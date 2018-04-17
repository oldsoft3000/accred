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
        when('/hotel/reserve_tutorial/:id', {
            templateUrl: 'views/hotel/reserve_tutorial.html',
            controller: 'ReserveHotelTutorialController',
            resolve: {
                response: function(HotelServices) {
                    return HotelServices.getHotels();
                }
            }
        }).
        when('/hotel/reserve/:id', {
            templateUrl: 'views/hotel/reserve.html',
            controller: 'ReserveHotelController',
            resolve: {
                response: function(HotelServices, $route) {
                    return HotelServices.getHotelInfo($route.current.params.id);
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

HotelControllers.factory("reservationInfo",function() {
        return {
            idParticip: 0,
            idHotel: 0,
        };
});


HotelControllers.controller('ReserveHotelTutorialController', ['$location',
                                                               '$scope',
                                                               '$route',
                                                               '$cookies',
                                                               'response',
                                                               'HotelServices', 
                                                               'reservationInfo',
    function ($location, $scope, $route, $cookies, response,  HotelServices, reservationInfo) {
        reservationInfo.idParticip = $route.current.params.id;
        $scope.hotels = response.data;
        $cookies.putObject('reservation_info', reservationInfo);

    }
]);

HotelControllers.controller('ReserveHotelController', ['$location',
                                                       '$scope',
                                                       '$route',
                                                       '$cookies',
                                                       'response',
                                                       'HotelServices', 
                                                       'reservationInfo',
    function ($location, $scope, $route, $cookies, response,  HotelServices, reservationInfo) {
        $scope.reservModel = {};
        reservationInfo.idHotel = $route.current.params.id;
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


        if (reservationInfo.idParticip == 0) {
            var cookie = $cookies.getObject('reservation_info');
            if (cookie.idParticip != 0) {
                reservationInfo.idParticip = cookie.idParticip;
            } else {
                $location.path('/hotel/view').replace();
            }
        }
        $cookies.putObject('reservation_info', reservationInfo);


        $scope.reserveHotel = function() {
            $scope.dataLoading = true;
            $scope.error = {};
            HotelServices.reserve($scope.reservModel, reservationInfo.idParticip)
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
