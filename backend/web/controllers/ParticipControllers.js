'use strict';

ParticipControllers.config(['$routeProvider', '$httpProvider',
    function($routeProvider, $httpProvider) {
        $routeProvider.
        when('/particip/view', {
            templateUrl: 'views/particip/view.html',
            controller: 'ViewController',
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
                                                  'ParticipServices',
                                                  'DTOptionsBuilder',
                                                  'DTColumnBuilder',
                                                  'Utils',
    function(   $scope,
                $http,
                $route,
                $q,
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
            //console.log(aData);
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
            .withDisplayLength(25)
            .withLanguage(language);
            //.withOption('fnRowCallback', rowCallback)
            /*.withLightColumnFilter({
            '0' : {
                html: 'input',
                type: 'text',
                attr: {}
            },
            '1' : {
                html: 'select',
                type : 'text',
                values: [{
                    value: 'Yoda', label: 'Yoda foobar'
                }, {
                    value: 'Titi', label: 'Titi foobar'
                }, {
                    value: 'Kyle', label: 'Kyle foobar'
                }, {
                    value: 'Bar', label: 'Bar foobar'
                }, {
                    value: 'Whateveryournameis', label: 'Whateveryournameis foobar'
                }]
            }
        });*/
          /*.withLightColumnFilter({
            '0' : {
                type : 'text'
            },
            '1' : {
                type : 'text'
            },
            '2' : {
                type : 'select',
                values: [{
                    value: 'Yoda', label: 'Yoda foobar'
                }, {
                    value: 'Titi', label: 'Titi foobar'
                }, {
                    value: 'Kyle', label: 'Kyle foobar'
                }, {
                    value: 'Bar', label: 'Bar foobar'
                }, {
                    value: 'Whateveryournameis', label: 'Whateveryournameis foobar'
                }]
            }
        });*/




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
