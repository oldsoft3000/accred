'use strict';

ParticipApp.config(['$routeProvider', '$httpProvider',
    function($routeProvider, $httpProvider) {
        $routeProvider.
            when('/particip/view', {
                templateUrl: 'views/particip/view.html',
                controller: 'ViewController',
                resolve: {
                    response: function(ParticipServices) {
                        return ParticipServices.view();
                    }
                }
            }).
            when('/particip/view/:id', {
                templateUrl: 'views/particip/update.html',
                controller: 'UpdateController',
                resolve: {
                    response: function(ParticipServices, $route) {
                        return ParticipServices.view($route.current.params.id);
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
        $scope.delete = function(id) {
            if(confirm("Удалить участника: " + id)==true && id>0){
                ParticipServices.delete(id);    
                $route.reload();
            }
        };
}]);

ParticipApp.controller('CreateController', ['$scope', '$http', '$route', 'ParticipServices',
    function($scope, $http, $route, ParticipServices) {
        $scope.create = function () {
            $scope.dataLoading = true;
            $scope.error = {};
            ParticipServices.create($scope.userModel)
                .then(successHandler) 
                .catch(errorHandler);
                function successHandler(response) {
                    $scope.dataLoading = false;
                    return response;
                }
                function errorHandler(response) {
                    $scope.dataLoading = false;
                    angular.forEach(response.data, function (error) {
                        $scope.error[error.field] = error.message;
                    });
                    return response;
                }
        };
}]);

ParticipApp.controller('UpdateController', ['$scope', '$http', '$route', 'response', 'ParticipServices',
    function($scope, $http, $route, response, ParticipServices) {
        $scope.userModel = response.data;
        $scope.userModel.date_of_birth = new Date(response.data.date_of_birth);
        $scope.userModel.visa_passport_validity = new Date(response.data.visa_passport_validity);
        $scope.update = function () {
            $scope.dataLoading = true;
            $scope.error = {};
            ParticipServices.update($scope.userModel)
                .then(successHandler) 
                .catch(errorHandler);
                function successHandler(response) {
                    $scope.dataLoading = false;
                    return response;
                }
                function errorHandler(response) {
                    $scope.dataLoading = false;
                    angular.forEach(response.data, function (error) {
                        $scope.error[error.field] = error.message;
                    });
                    return response;
                }
        };
}]);
