'use strict';

ParticipApp.config(['$routeProvider', '$httpProvider',
    function($routeProvider, $httpProvider) {
        $routeProvider.
            when('/particips', {
                templateUrl: 'views/particip/index.html',
                controller: 'IndexController',
            }).
            otherwise({
                templateUrl: 'views/site/404.html'
            });
        $httpProvider.interceptors.push('authInterceptor');
    }
]);

ParticipApp.controller('IndexController', ['$scope', '$http', '$route', 'ParticipServices',
    function($scope, $http, $route, ParticipServices) {
        $scope.message = 'Everyone come and see how good I look!';
        ParticipServices.getparticips().then(function(response){
            $scope.particips = response.data;
        });    
        $scope.deleteparticip = function(filmID) {
            if(confirm("Are you sure to delete film number: " + filmID)==true && filmID>0){
                ParticipServices.deleteparticip(filmID);    
                $route.reload();
            }
        };
}]);
