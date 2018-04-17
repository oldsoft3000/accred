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
                    return HotelServices.getHotelRooms($route.current.params.id);
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
            particip: 0,
            hotel: 0,
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
        reservationInfo.particip = $route.current.params.id;
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

        var room_categories = [
            'Стандартный',
            'Полулюкс',
            'Люкс',
            'Супериор'
        ];

        var room_types = [
            'Одноместный',
            'Двухместный',
            'Трехместный'
        ];

        reservationInfo.hotel = $route.current.params.id;

        $scope.room_categories = room_categories;
        $scope.room_types = room_types;
        $scope.hotel_name = response[0].data.name;
        $scope.hotel_description = response[0].data.description;
        $scope.rooms = response[1].data;

        if (reservationInfo.particip == 0) {
            var cookie = $cookies.getObject('reservation_info');
            if (cookie.particip != 0) {
                reservationInfo.particip = cookie.particip;
            } else {
                $location.path('/hotel/view').replace();
            }
        }
   
        $cookies.putObject('reservation_info', reservationInfo);

    }
]);
