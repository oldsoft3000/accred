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
            if (confirm("Удалить участника: " + id) == true && id > 0) {
                ParticipServices.delete(id);
                $route.reload();
            }
        };

        $scope.showPhoto = function(userModel) {
            $scope.userModel = userModel;
            $('#myModal').modal('toggle')
        };
    }
]);

ParticipApp.controller('CreateController', ['$timeout', '$scope', '$rootScope', '$http', '$route', '$location', 'response', 'ParticipServices',
    function($timeout, $scope, $rootScope, $http, $route, $location, response, ParticipServices) {
        $scope.fileName = "Выберите файл";
        $scope.userModel = {};
        $scope.userModel.visa_required = 1;

        $scope.cropped = {};
        $scope.cropped.source = '';
        $scope.cropped.image = '';

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

        $scope.create = function() {
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
                angular.forEach(response.data, function(error) {
                    $scope.error[error.field] = error.message;
                });
                return response;
            }
        };

        $scope.update = function() {
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
                angular.forEach(response.data, function(error) {
                    $scope.error[error.field] = error.message;
                });
                return response;
            }
        };


        $scope.visaReuired = function(value) {
            var el = angular.element(document.querySelector('#visa-fieldset'));
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
                var file = document.querySelector('#photoFile').files[0];
                if (typeof file !== 'undefined') {
                    $scope.fileName = file.name;
                    var reader = new FileReader();
                    reader.onloadend = function() {
                        $scope.$apply(function($scope) {
                            $scope.userModel.photo = reader.result; 
                            $scope.cropped.source = reader.result; 
                            $scope.editPhoto();
                        });
                    }
                    reader.readAsDataURL(file);
                }
            });
        };


        $scope.debugRequest = function() {
            $scope.userModel.title = 1;
            $scope.userModel.first_name = "1asdaf";
            $scope.userModel.last_name = "2as2daf";
            $scope.userModel.middle_name = "3asdaf";
            $scope.userModel.gender = "1";
            $scope.userModel.email = "zcz@mail.ru";
            $scope.userModel.date_of_birth = new Date("2005-08-09");
            $scope.userModel.citizenship = "TG";
            $scope.userModel.passport_series = "1231";
            $scope.userModel.passport_number = "123456";
            $scope.userModel.registration_address = "sdg";
            $scope.userModel.phone_number = "2523523525";
            $scope.userModel.visa_required = "0";
            $scope.userModel.place_of_birth = "cxvxcbxb";
            $scope.userModel.first_name_latin = "sdfsfsfsdf";
            $scope.userModel.last_name_latin = "dfnfjgjfgj";
            $scope.userModel.position = "assadasd";
            $scope.userModel.position_latin = "ytjtjgj";

            $scope.create();

        }

        $scope.$watch('userModel.visa_required', function(newVal, oldVal) {
            $scope.visaReuired(newVal);
        }, true);

        $scope.editPhoto = function() {
            $('#photoEditor').modal('toggle');
        };

        /*$rootScope.$on('visaReuired', function(event, value) {
            $scope.visaReuired(value);
        });*/



    }
]);