'use strict';

ParticipControllers.config(['$routeProvider', '$httpProvider',
    function($routeProvider, $httpProvider) {
        $routeProvider.
        when('/particip/view', {
            templateUrl: 'views/particip/view.html',
            controller: 'ViewController',
        }).
        when('/particip', {
            templateUrl: 'views/particip/view.html',
            controller: 'ViewController',
        }).
        when('/particip/view/:id', {
            templateUrl: 'views/particip/card.html',
            controller: 'CardController',
            resolve: {
                response: function(ParticipServices, $route) {
                    return ParticipServices.view($route.current.params.id);
                }
            }
        }).
        otherwise({
            templateUrl: 'views/site/404.html'
        });
        $httpProvider.interceptors.push('authInterceptor');
    }
]);

ParticipControllers.controller('ViewController', ['$scope',
                                                  '$http',
                                                  '$route',
                                                  '$q',
                                                  '$location',
                                                  'ParticipServices',
                                                  'DTOptionsBuilder',
                                                  'DTColumnBuilder',
                                                  'Utils',
    function(   $scope,
                $http,
                $route,
                $q,
                $location,
                ParticipServices,
                DTOptionsBuilder,
                DTColumnBuilder,
                Utils) {
        var  language = {
          "processing": "Подождите...",
          "search": "Поиск:",
          "lengthMenu": "Показать _MENU_ записей",
          "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
          "infoEmpty": "Записи с 0 до 0 из 0 записей",
          "infoFiltered": "(отфильтровано из _MAX_ записей)",
          "infoPostFix": "",
          "loadingRecords": "Загрузка записей...",
          "zeroRecords": "Записи отсутствуют.",
          "emptyTable": "В таблице отсутствуют данные",
          "paginate": {
            "first": "Первая",
            "previous": "Предыдущая",
            "next": "Следующая",
            "last": "Последняя"
          },
          "aria": {
            "sortAscending": ": активировать для сортировки столбца по возрастанию",
            "sortDescending": ": активировать для сортировки столбца по убыванию"
          }
        }

        function rowCallback(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            $('td', nRow).unbind('click');
            $('td', nRow).bind('click', function() {
                $scope.$apply(function() {
                    $scope.clickHandler(aData);
                });
            });
            return nRow;
        }

        $scope.clickHandler = function(row) {
            $location.path('/particip/view/' + row.id);
        }

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

        $scope.dtOptions = DTOptionsBuilder.fromFnPromise(function() {
                var defer = $q.defer();
                var response = ParticipServices.view();
                defer.resolve(response);
                response.then(function(data) {
        
                    $scope.dtOptions.withLightColumnFilter({
                        '0' : {
                            html: 'input',
                            type: 'text',
                            attr: {}
                        },
                        '1' : {
                            html: 'select',
                            type : 'text',
                            values:  Utils.createUniqueList(data.data, 'organization')
                        },
                        '2' : {
                            html: 'select',
                            type : 'text',
                            values:  Utils.createUniqueList(data.data, 'position')
                        }
                    });
                });

                return defer.promise;
            })
            .withDataProp('data')
            .withPaginationType('full_numbers')
            .withDisplayLength(-1)
            .withOption('rowCallback', rowCallback)
            .withLanguage(language);

        $scope.dtColumns = [

            DTColumnBuilder.newColumn(null)
                .withTitle('Фамилия Имя Отчество')
                .renderWith(function(data,type,full) {
                    var name =  data.last_name + ' ' + data.first_name + ' ' + data.middle_name;
                    return name;         
                }),
            DTColumnBuilder.newColumn('organization').withTitle('Организация'),
            DTColumnBuilder.newColumn('position').withTitle('Должность'),
    

        ];
    }
]);


ParticipControllers.controller('CardController', ['$timeout',
                                                    '$scope',
                                                    '$rootScope',
                                                    '$http',
                                                    '$route',
                                                    '$location',
                                                    '$window',
                                                    'response',
                                                    'ParticipServices',
    function($timeout, $scope, $rootScope, $http, $route, $location, $window, response, ParticipServices) {
        var el = document.querySelector(".crop-area");
        var w = angular.element($window);
        var boundary_width;
        var boundary_height;
        if (w.innerWidth() <= 800) {
            boundary_width = w.innerWidth() * 0.95;
            boundary_height = w.innerHeight() * 0.5;
        } else {
            boundary_width = 400;
            boundary_height = 400;
        }

        $scope.croppie = new Croppie(el, {
            boundary: { width: boundary_width, height: boundary_height },
            viewport: { width: 100, height: 100 },
            showZoomer: false
        });

        $scope.modelUser.visa_passport_validity = null;
        $scope.modelUser.visa_required = 1;
        $scope.modelUser = response.data;
        $scope.modelUser.title = response.data.title.toString();
        $scope.modelUser.gender = response.data.gender.toString();

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

        $scope.visaRequired = function(value) {
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

        $scope.$watch('modelUser.visa_required', function(newVal, oldVal) {
            $scope.visaRequired(newVal);
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
                $scope.$apply();
            });
        }

        $scope.printBadge = function(idSection) {
            var innerContents = document.getElementById(idSection).innerHTML;
            var popupWinindow = window.open('', '_blank', 'width=600,height=400,scrollbars=no,menubar=no,toolbar=no,location=no,status=no,titlebar=no');
            popupWinindow.document.open();
            popupWinindow.document.write('<html><head><link rel="stylesheet" type="text/css" href="css/badge.css" /></head><body onload="window.print()">' + innerContents + '</html>');
            popupWinindow.document.close();
        }
    }
]);
