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
                templateUrl: 'views/particip/create.html',
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

ParticipApp.controller('CreateController', ['$scope', '$rootScope', '$http', '$route', '$location', 'ParticipServices',
    function($scope, $rootScope, $http, $route, $location, ParticipServices) {
        $scope.button = "Добавить участника";
        $scope.action = function () {
            $scope.dataLoading = true;
            $scope.error = {};
            ParticipServices.create($scope.userModel)
                .then(successHandler) 
                .catch(errorHandler);
                function successHandler(response) {
                    $scope.dataLoading = false;
                    $location.path('/particip/view').replace();
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
        
        $scope.visaReuired = function(value) {
            var el =angular.element( document.querySelector( '#visa-fieldset' ) );
            if (value === 0) {
                el.attr('disabled', 'true');
            } else {
                el.removeAttr('disabled');
            }
        };
        
        $scope.$watch('userModel.visa_required', function(newVal, oldVal){
            $scope.$emit('visaReuired', newVal);
            if (typeof $scope.error !== 'undefined') {
                $scope.error['visa_passport_validity'] = '';
                $scope.error['visa_country'] = '';
                $scope.error['visa_city'] = '';
            }
        }, true);

        $rootScope.$on('visaReuired', function(event, value) {
            $scope.visaReuired(value);
        });
        
        $scope.userModel.visa_required = 1;
}]);

ParticipApp.controller('UpdateController', ['$scope', '$rootScope', '$http', '$route', '$location', 'response', 'ParticipServices',
    function($scope, $rootScope, $http, $route, $location, response, ParticipServices) {
        $scope.userModel = response.data;
        $scope.userModel.date_of_birth = new Date(response.data.date_of_birth);
        $scope.userModel.visa_passport_validity = new Date(response.data.visa_passport_validity);
        $scope.button = "Обновить данные";
        $scope.userModel.title = response.data.title.toString();
        $scope.userModel.gender = response.data.gender.toString();
  
        $scope.action = function () {
            $scope.dataLoading = true;
            $scope.error = {};
            ParticipServices.update($scope.userModel)
                .then(successHandler) 
                .catch(errorHandler);
                function successHandler(response) {
                    $scope.dataLoading = false;
                    $location.path('/particip/view').replace();
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
       
        $scope.$watch('userModel.visa_required', function(newVal, oldVal){
           $rootScope.$emit('visaReuired', newVal);
        }, true);
}]);
