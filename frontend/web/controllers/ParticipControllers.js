'use strict';

ParticipControllers.config(['$routeProvider', '$httpProvider',
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
        when('/particip/create', {
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

ParticipControllers.controller('ViewController', ['$scope', '$http', '$route', 'response', 'ParticipServices',
    function($scope, $http, $route, response, ParticipServices) {
        $scope.particips = response.data;
        $scope.delete = function(id) {
            if (confirm("Удалить участника: " + id) == true && id > 0) {
                ParticipServices.delete(id);
                $route.reload();
            }
        };

        $scope.showPhoto = function(modelUser) {
            $scope.modelUser = modelUser;
            $('#myModal').modal('toggle')
        };
    }
]);

ParticipControllers.controller('CreateController', ['$timeout',
                                                    '$scope',
                                                    '$rootScope',
                                                    '$http',
                                                    '$route',
                                                    '$location',
                                                    'response',
                                                    'ParticipServices',
    function($timeout, $scope, $rootScope, $http, $route, $location, response, ParticipServices) {
        $scope.fileName = "Выберите файл";
        $scope.modelUser = {};
        $scope.modelUser.visa_passport_validity = null;
        $scope.modelUser.visa_required = 1;

        var el = document.querySelector(".crop-area");

        $scope.croppie = new Croppie(el, {
            viewport: { width: 100, height: 100 },
            showZoomer: false
        });


        if ($route.current.$$route.originalPath === "/particip/view/:id") {
            console.log("update");
            $scope.button = "Обновить данные";
            $scope.modelUser = response.data;
            $scope.modelUser.title = response.data.title.toString();
            $scope.modelUser.gender = response.data.gender.toString();
            $scope.isCreation = false;

        } else if ($route.current.$$route.originalPath === "/particip/create") {
            console.log("create");
            $scope.modelUser.date_of_birth = null;
            $scope.modelUser.visa_passport_validity = null
            $scope.button = "Добавить участника";
            $scope.isCreation = true;
        }

        $scope.create = function() {
            $scope.dataLoading = true;
            $scope.error = {};

            ParticipServices.create($scope.modelUser)
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

            ParticipServices.update($scope.modelUser)
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
                var file = document.querySelector('#photoFile').files[0];
                if (typeof file !== 'undefined') {
                    $scope.fileName = file.name;
                    var reader = new FileReader();
                    reader.onloadend = function() {
                        $timeout( function() {
                            $scope.modelUser.photo = reader.result; 
                            $scope.editPhoto();
                        });
                    }
                    reader.readAsDataURL(file);
                }
            });
        };


        $scope.debugRequest = function() {
            $scope.modelUser.title = 1;
            $scope.modelUser.first_name = "1asdaf";
            $scope.modelUser.last_name = "2as2daf";
            $scope.modelUser.middle_name = "3asdaf";
            $scope.modelUser.gender = "1";
            $scope.modelUser.email = "zcz@mail.ru";
            $scope.modelUser.date_of_birth = new Date("2005-08-09");
            $scope.modelUser.citizenship = "TG";
            $scope.modelUser.passport_series = "1231";
            $scope.modelUser.passport_number = "123456";
            $scope.modelUser.registration_address = "sdg";
            $scope.modelUser.phone_number = "2523523525";
            $scope.modelUser.visa_required = "0";
            $scope.modelUser.place_of_birth = "cxvxcbxb";
            $scope.modelUser.first_name_latin = "sdfsfsfsdf";
            $scope.modelUser.last_name_latin = "dfnfjgjfgj";
            $scope.modelUser.position = "assadasd";
            $scope.modelUser.position_latin = "ytjtjgj";

            $scope.create();

        }

        $scope.$watch('modelUser.visa_required', function(newVal, oldVal) {
            $scope.visaReuired(newVal);
        }, true);

        $scope.editPhoto = function() {
            document.querySelector('#photoFile').value = "";
            $scope.croppie.bind({
                url: $scope.modelUser.photo,
            });
            $('#photoEditor').modal('toggle');
            $scope.croppie.setZoom(1.0);
        };

        $scope.saveCropResult = function() {
            $scope.croppie.result('base64').then(function(base64) {
                $scope.modelUser.photo = base64;
                $scope.croppie.bind({
                    url: base64
                });
            });
        }
    }
]);
