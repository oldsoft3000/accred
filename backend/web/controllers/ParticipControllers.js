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
                                                  '$timeout',
                                                  '$window',
                                                  'ParticipServices',
                                                  'DTOptionsBuilder',
                                                  'DTColumnBuilder',
                                                  'Utils',
    function(   $scope,
                $http,
                $route,
                $q,
                $location,
                $timeout,
                $window,
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
                    $scope.particips = data.data;
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
            //.withOption('rowCallback', rowCallback)
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
            DTColumnBuilder.newColumn(null)
                .withTitle('Действия')
                .renderWith(function(data, type, full, meta) {
                    return '<a class="action-icon-block" href="#!/particip/view/' + data.id + '" data-toggle="tooltip" title="Редактировать"><img class="action-icon" border="0" src="images/edit.png"></a><a class="action-icon-block" onclick="angular.element(this).scope().delete(' + data.id + ')" data-toggle="tooltip" title="Удалить"><img class="action-icon" border="0" src="images/delete.png">';
                }).withClass("cell-actions").notSortable()     
    

        ];

        var xls_style = {
            headers: true,
            column: { width: 200 }
        };


        $scope.exportData = function () {
            alasql('SELECT * INTO XLSX("export.xls",?) FROM ?', [xls_style, $scope.particips]);
        };

        $scope.importData = function(event) {
            alasql('SELECT * FROM FILE(?,{headers:true})',[event], function(dataParticip){
                    var index = 0;

                    angular.forEach(dataParticip, function(dataRow) {
                        var modelParticip = {};
        
                        index = index + 1;
                        modelParticip.id = dataRow.id;
                        modelParticip.title = dataRow.title;
                        modelParticip.first_name = dataRow.first_name;
                        modelParticip.last_name = dataRow.last_name;
                        modelParticip.middle_name = dataRow.middle_name;
                        modelParticip.first_name_latin = dataRow.first_name_latin;
                        modelParticip.last_name_latin = dataRow.last_name_latin;
                        modelParticip.gender = dataRow.gender;
                        modelParticip.photo = dataRow.photo;
                        modelParticip.citizenship = dataRow.citizenship;
                        modelParticip.passport_series = dataRow.passport_series;
                        modelParticip.passport_number = dataRow.passport_number;
                        modelParticip.date_of_birth = dataRow.date_of_birth;
                        modelParticip.place_of_birth = dataRow.place_of_birth;
                        modelParticip.registration_address = dataRow.registration_address;
                        modelParticip.visa_required = dataRow.visa_required;
                        modelParticip.visa_passport_validity = dataRow.visa_passport_validity;
                        modelParticip.visa_country = dataRow.visa_country;
                        modelParticip.visa_city = dataRow.visa_city;
                        modelParticip.organization = dataRow.organization;
                        modelParticip.position = dataRow.position;
                        modelParticip.organization_latin = dataRow.organization_latin;
                        modelParticip.position_latin = dataRow.position_latin;
                        modelParticip.email = dataRow.email;
                        modelParticip.phone_number = dataRow.phone_number;

                        ParticipServices.importParticip(modelParticip).then(function(response) {
                            if (!isNaN(dataRow.hotel_id)) {
                                $scope.importHotel(dataRow, response.data.id);
                            }
                            if (!isNaN(dataRow.flight_id)) {
                                $scope.importFlight(dataRow, response.data.id);
                            }
                            if (!isNaN(dataRow.ticket_id)) {
                                $scope.importTicket(dataRow, response.data.id);
                            }
                            if (!isNaN(dataRow.car_id)) {
                                $scope.importCar(dataRow, response.data.id);
                            }
                            if (index == dataParticip.length) {
                                $window.location.reload();
                            }
                        });
                    });
                    
            });
        };

        $scope.importHotel = function(dataRow, idParticip) {
            var modelHotel = {};
            modelHotel.arrival_date = dataRow.hotel_arrival_date;
            modelHotel.departure_date = dataRow.hotel_departure_date;
            modelHotel.guests = dataRow.guests;
            modelHotel.type_name = dataRow.type_name;
            modelHotel.category_name = dataRow.category_name;
            modelHotel.hotel_index = dataRow.hotel_index;
            ParticipServices.importHotel(modelHotel, idParticip);
        }
        $scope.importFlight = function(dataRow, idParticip) {
            var modelFlight = {};
            modelFlight.arrival_place = dataRow.arrival_place;
            modelFlight.arrival_date = dataRow.flight_arrival_date;
            modelFlight.arrival_time = dataRow.flight_arrival_time;
            modelFlight.arrival_flight_number = dataRow.arrival_flight_number;
            modelFlight.arrival_terminal = dataRow.arrival_terminal;
            modelFlight.departure_place = dataRow.departure_place;
            modelFlight.departure_date = dataRow.flight_departure_date;
            modelFlight.departure_time = dataRow.flight_departure_time;
            modelFlight.departure_flight_number = dataRow.departure_flight_number;
            modelFlight.departure_terminal = dataRow.departure_terminal;
            ParticipServices.importFlight(modelFlight, idParticip);
        }
        $scope.importTicket = function(dataRow, idParticip) {
            var modelTicket = {};
            modelTicket.ticket_type = dataRow.ticket_type;
            modelTicket.departure_date = dataRow.ticket_departure_date;
            modelTicket.flight_number = dataRow.flight_number;
            modelTicket.from = dataRow.from;
            modelTicket.where = dataRow.where;
            modelTicket.class = dataRow.class;
            modelTicket.passport_number = dataRow.ticket_passport_number;
            modelTicket.passport_validity = dataRow.ticket_passport_validity;
            modelTicket.bonus_card = dataRow.bonus_card;
            modelTicket.company_name = dataRow.company_name;
            ParticipServices.importTicket(modelTicket, idParticip);
        }

        $scope.importCar = function(dataRow, idParticip) {
            var modelCar = {};
            modelCar.country = dataRow.car_country;
            modelCar.car_number = dataRow.car_number;
            modelCar.car_brand = dataRow.car_brand;
            modelCar.is_particip = dataRow.is_particip;
            modelCar.first_name = dataRow.car_first_name;
            modelCar.middle_name = dataRow.car_middle_name;
            modelCar.last_name = dataRow.car_last_name;
            modelCar.first_name_latin = dataRow.car_first_name_latin;
            modelCar.last_name_latin = dataRow.car_last_name_latin;
            modelCar.date_of_birth = dataRow.car_date_of_birth;
            modelCar.passport_series = dataRow.car_passport_series;
            modelCar.passport_number = dataRow.car_passport_number;
            modelCar.place_of_birth = dataRow.car_place_of_birth;
            ParticipServices.importCar(modelCar, idParticip);
        }

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

        
        $scope.lockCard = function(idParticip) {
            ParticipServices.lockCard(idParticip);
        }

        $scope.unlockCard = function(idParticip) {
            ParticipServices.unlockCard(idParticip);
        }
    }
]);
