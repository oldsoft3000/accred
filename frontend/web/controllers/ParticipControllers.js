'use strict';

ParticipApp.config(['$routeProvider', '$httpProvider',
    function($routeProvider, $httpProvider) {
        $routeProvider.
            when('/particips', {
                templateUrl: 'views/particip/view.html',
                controller: 'ViewController',
                resolve: {
                    response: function(ParticipServices) {
                        return ParticipServices.getparticips();
                    }
                }
            }).
            when('/create', {
                templateUrl: 'views/particip/create.html',
                controller: 'CreateController',
            }).
            otherwise({
                templateUrl: 'views/site/404.html'
            });
        $httpProvider.interceptors.push('authInterceptor');
    }
]);

ParticipApp.controller('ViewController', ['$scope', '$http', '$route', 'response', 'ParticipServices',
    function($scope, $http, $route, response, ParticipServices) {
        $scope.particips = response.data;   
        $scope.deleteparticip = function(filmID) {
            if(confirm("Are you sure to delete film number: " + filmID)==true && filmID>0){
                ParticipServices.deleteparticip(filmID);    
                $route.reload();
            }
        };
}]);

ParticipApp.controller('CreateController', ['$scope', '$http', '$route', 'ParticipServices',
    function($scope, $http, $route, ParticipServices) {

}]);
