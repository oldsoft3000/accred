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
        when('/hotel/reserve_tutorial/:idParticip/:idReserved', {
            templateUrl: 'views/hotel/reserve_tutorial.html',
            controller: 'HotelTutorialController',
        }).
        when('/hotel/reserve/:idParticip/:idHotel', {
            templateUrl: 'views/hotel/reserve.html',
            controller: 'HotelController',
            resolve: {
                response: function(HotelServices, $route) {
                    if ($route.current.params.isReserved == 'true') {
                        return HotelServices.getReservationInfo($route.current.params.idParticip);
                    } else {
                        return null;
                    }
                }
            }
        }).

        
        otherwise({
            templateUrl: 'views/site/404.html'
        });
        $httpProvider.interceptors.push('authInterceptor');
    }
]);


HotelControllers.controller('ViewHotelController', ['$location', '$scope', '$route', 'response', 'HotelServices',
    function ($location, $scope, $route, response, HotelServices) {
        $scope.particips = response.data;
        $scope.delete = function(id) {
            if (confirm("Удалить бронирование") == true && id > 0) {
                HotelServices.delete(id);
                $route.reload();
            }
        };
    }
]);

HotelControllers.controller('HotelTutorialController', ['$location',
                                                       '$scope',
                                                       '$route',
                                                       'HotelServices', 
    function ($location, $scope, $route, HotelServices) {
        $scope.idParticip = $route.current.params.idParticip;
        $scope.idReserved = $route.current.params.idReserved;
    }
]);

HotelControllers.controller('HotelController', ['$location',
                                                   '$scope',
                                                   '$route',
                                                   'response',
                                                   'HotelServices',
    function ($location, $scope, $route, response, HotelServices) {
        $scope.modelReserv = {};
        $scope.idHotel = $route.current.params.idHotel;
        $scope.categories = [];
        $scope.types = [];


        $scope.hotels[$scope.idHotel].rooms.forEach(function(room) {
            var i = $scope.categories.indexOf[room.category];
            if ($scope.categories.indexOf(room.category) == -1) {
                $scope.categories.push(room.category);
            }
            if ($scope.types.indexOf(room.type) == -1) {
                $scope.types.push(room.type);
            }
        });

        $scope.getName = function(arr, id) {
            for ( var i = 0; i < arr.length; i++ )
                if (arr[i]["id"] === id)                    
                    return arr[i]["name"];
            return false
        };

        if ( $route.current.params.isReserved == "true" ) {
            $scope.modelReserv = response.data;
        }

        $scope.reserveHotel = function() {
            $scope.dataLoading = true;
            $scope.error = {};
            $scope.modelReserv.hotel_index = $scope.idHotel;

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
