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
        when('/hotel/reserve/:id', {
            templateUrl: 'views/hotel/reserve.html',
            controller: 'ReserveHotelController',
            resolve: {
                response: function(HotelServices) {
                    return HotelServices.getHotels();
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


HotelControllers.controller('ReserveHotelController', ['$location', '$scope', 'response', 'HotelServices',
    function ($location, $scope, response, HotelServices) {
        //$route.current.params.id
    }
]);
