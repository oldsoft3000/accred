'use strict';

SiteControllers.config(['$routeProvider', '$httpProvider',
    function($routeProvider, $httpProvider) {
        $routeProvider.
            when('/', {
                templateUrl: 'views/site/index.html'
            }).
            when('/login', {
                templateUrl: 'views/site/login.html',
                controller: 'LoginController',
            }).               
            when('/error', {
                templateUrl: 'views/site/error.html',
                controller: 'ErrorController'
            }).
            otherwise({
                templateUrl: 'views/site/error.html'
            });
        $httpProvider.interceptors.push('authInterceptor');
    }
]);

SiteControllers.controller('MainController',    ['$scope',
                                                '$location',
                                                '$window',
                                                'SiteServices',
    function ($scope, $location, $window, SiteServices, ) {
        $scope.isLoggedIn = function() {
            return SiteServices.isLoggedIn();
        };

        $scope.isLoggedIn = function() {
            return SiteServices.isLoggedIn();
        };

        $scope.logout = function () {
            SiteServices.logout();
            $location.path('/login').replace();
        };


        $scope.modelUser = {
            telephone: '',
            digits_4: '',
            digits_6: ''
        };

        $scope.cleave_options = {
            telephone: {
                numericOnly: true,
                blocks: [2, 3, 3, 2, 2],
                delimiters: ['(',')','-','-'],
                prefix: '+',
                noImmediatePrefix: true,
            },  
            digits_4: {
                numericOnly: true,
                blocks: [4],
            },  
            digits_6: {
                numericOnly: true,
                blocks: [6],
            },   
        };
    }
]); 

SiteControllers.controller('LoginController', ['$scope', '$window', '$location', 'SiteServices', 
    function($scope, $window, $location, SiteServices) {
        $scope.login = function () {
            $scope.dataLoading = true;
            $scope.error = {};
            SiteServices.login($scope.modelUser)
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
    }
]);


SiteControllers.controller('ErrorController', ['$scope', '$location','authInterceptor', 
    function ($scope, $location, authInterceptor) {
        $scope.errorMessage = authInterceptor.data.lastError;  

        if (!$scope.errorMessage) {
            $location.path('/').replace();
        }
    }
]);

