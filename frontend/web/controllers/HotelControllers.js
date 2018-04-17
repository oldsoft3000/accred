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
        when('/hotel/reserve_tutor/:id', {
            templateUrl: 'views/hotel/reserve_tutor.html',
            controller: 'ReserveHotelController',
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


HotelControllers.controller('ReserveHotelController', ['$location',
                                                       '$scope',
                                                       '$route',
                                                       '$cookies',
                                                       'response',
                                                       'HotelServices', 
    function ($location, $scope, $route, $cookies, response,  HotelServices) {
        var reservation_info = {
            particip: 0,
            hotel: 0,
        };

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

        $scope.room_categories = room_categories;
        $scope.room_types = room_types;


        var cookie = $cookies.getObject('reservation_info');
        if (typeof cookie != 'undefined') {
            reservation_info = cookie;
        }

        if ($route.current.$$route.originalPath === "/hotel/reserve_tutor/:id") {
            reservation_info.particip = $route.current.params.id;
            $scope.hotels = response.data;
        } else if ($route.current.$$route.originalPath === "/hotel/reserve/:id") {
            reservation_info.hotel = $route.current.params.id;
            $scope.hotel_name = response[0].data.name;
            $scope.hotel_description = response[0].data.description;
            $scope.rooms = response[1].data;
        }

        $cookies.putObject('reservation_info', reservation_info);

    }
]);
