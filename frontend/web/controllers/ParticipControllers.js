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
                controller: 'CreateController',
                resolve: {
                    response: function(ParticipServices, $route) {
                        return ParticipServices.view($route.current.params.id);
                    }
                }
            }).
            when('/create', {
                templateUrl: 'views/particip/create.html',
                controller: 'CreateController',
                resolve: {
                    response: function() {
                        return undefined;
                    }
                }
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

        $scope.showPhoto = function() {
            
        };
}]);

ParticipApp.controller('CreateController', ['$timeout','$scope', '$rootScope', '$http', '$route', '$location', 'response', 'ParticipServices',
    function($timeout, $scope, $rootScope, $http, $route, $location, response, ParticipServices) {
        $scope.fileName = "Выберите файл";
        $scope.userModel.visa_required = 1;

        if ($route.current.$$route.originalPath === "/particip/view/:id") {
            console.log("update");
            $scope.button = "Обновить данные";
            $scope.userModel = response.data;
            $scope.userModel.date_of_birth = new Date(response.data.date_of_birth);
            $scope.userModel.visa_passport_validity = new Date(response.data.visa_passport_validity);
            $scope.userModel.title = response.data.title.toString();
            $scope.userModel.gender = response.data.gender.toString();
            $scope.isCreation = false;
        
        } else if ($route.current.$$route.originalPath === "/create") {
            console.log("create");
            $scope.button = "Добавить участника";
            $scope.isCreation = true;
        }

        
        $scope.create = function () {
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

        $scope.update = function () {
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
       
        
        $scope.visaReuired = function(value) {
            var el =angular.element( document.querySelector( '#visa-fieldset' ) );
            if (value === 0) {
                el.attr('disabled', 'true');
            } else {
                el.removeAttr('disabled');
            }
            if (typeof $scope.error !== 'undefined') {
                $scope.error['visa_passport_validity'] = '';
                $scope.error['visa_country'] = '';
                $scope.error['visa_city'] = '';
            }
        };

        $scope.photoSelected = function() {
            $timeout(function() {
                /*var fileName = "";
                fileName = filePath.substring(filePath.lastIndexOf('\\')+1);
                fileName = fileName.substring(fileName.lastIndexOf('/')+1);
                $scope.fileName = fileName;*/
                var file = document.querySelector( '#photoFile' ).files[0];
                if (typeof file !== 'undefined') {
                    $scope.fileName = file.name;
                    var reader = new FileReader();
                    reader.onloadend = function () {
                         $scope.userModel.photo = reader.result;
                    }
                    reader.readAsBinaryString(file);
                } 
            });
        };
        
        $scope.$watch('userModel.visa_required', function(newVal, oldVal){
            $scope.visaReuired( newVal );
        }, true);

        /*$rootScope.$on('visaReuired', function(event, value) {
            $scope.visaReuired(value);
        });*/

        
        
}]);
