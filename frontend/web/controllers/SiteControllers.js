'use strict';

SiteControllers.config(['$routeProvider', '$httpProvider',
    function($routeProvider, $httpProvider) {
        $routeProvider.
            when('/', {
                templateUrl: 'views/site/index.html'
            }).
            when('/about', {
                templateUrl: 'views/site/about.html'
            }). 
            when('/contact', {
                templateUrl: 'views/site/contact.html',
                controller: 'ContactController',
            }).
            when('/login', {
                templateUrl: 'views/site/login.html',
                controller: 'LoginController',
            }).
            when('/signup', {
                templateUrl: 'views/site/signup.html',
                controller: 'SignupController',
            }).    
            when('/agreement', {
                templateUrl: 'views/site/agreement.html',
                controller: 'AgreementController',
            }).               
            when('/dashboard', {
                templateUrl: 'views/site/dashboard.html',
                controller: 'DashboardController', 
                resolve: {
                    response: function(SiteServices) {
                        return SiteServices.dashboard();
                    }
                }
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

SiteControllers.controller('MainController', ['$scope', '$location', '$window', 'SiteServices',
    function ($scope, $location, $window, SiteServices) {
        $scope.isLoggedIn = function() {
            return SiteServices.isLoggedIn();
        };

        $scope.isLoggedIn = function() {
            return SiteServices.isLoggedIn();
        };

        $scope.isUserAgreed = function() {
            return SiteServices.isUserAgreed();
        }

        $scope.logout = function () {
            SiteServices.logout();
            $location.path('/login').replace();
        };
        
        $scope.isActivePath = function (route) {
            return route === $location.path();
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
                    if (SiteServices.isUserAgreed()) {
                        $location.path('/particip/view').replace();
                    } else {
                        $location.path('/agreement').replace();
                    }
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

SiteControllers.controller('SignupController', ['$scope', '$window', '$location', 'SiteServices',
    function($scope, $window, $location, SiteServices) {
        $scope.signup = function () {
            $scope.error = {};
            if ($scope.modelUser && $scope.modelUser.password != $scope.password_verify) {
                $scope.error["password_verify"] = "Пароли должны сопадать";
                return;
            }
            $scope.dataLoading = true;
            SiteServices.signup($scope.modelUser)
                .then(successHandler) 
                .catch(errorHandler);
                function successHandler(response) {
                    $scope.dataLoading = false;
                    var modelUser = {};
                    modelUser.username = $scope.modelUser.username;
                    modelUser.password = $scope.modelUser.password;
                    SiteServices.login(modelUser)
                        .then(successHandler) 
                        .catch(errorHandler);
                        function successHandler(response) {
                            SiteServices.resetAgree();
                            $location.path('/agreement').replace();
                        }
                    //$location.path('/login').replace();
                }
                function errorHandler(response) {
                    $scope.dataLoading = false;
                    angular.forEach(response.data, function (error) {
                        $scope.error[error.field] = error.message;
                    });
                }
        };
    }
]);

SiteControllers.controller('AgreementController', ['$cookies', '$location', '$scope', 'SiteServices',
    function ($cookies, $location, $scope, SiteServices) {
        $scope.isUserAgreed = function () {
            return SiteServices.isUserAgreed();
        }
        $scope.agree = function () {
            SiteServices.agree();
            $location.path('/particip/view').replace();
        }

    }
]);

SiteControllers.controller('DashboardController', ['$scope', 'response',
    function ($scope, response) {
        $scope.dashboard = response.data;
    }
]);

SiteControllers.controller('ContactController', ['$scope', '$window', 'SiteServices',
    function($scope, $window, SiteServices) {
        $scope.captchaUrl = 'site/captcha';
        $scope.contact = function () {
            $scope.error = {}; 
            $scope.submitted = true;
            SiteServices.contact($scope.contactModel)
                .then(successHandler)
                .catch(errorHandler);
                function successHandler(response) {
                    $scope.contactModel = {};
                    $scope.flash = response.data.flash;
                    $window.scrollTo(0,0);
                    $scope.submitted = false;
                    $scope.captchaUrl = 'site/captcha' + '?' + new Date().getTime();
                }
                function errorHandler(response) {
                    angular.forEach(response.data, function (error) {
                        $scope.error[error.field] = error.message;
                    });
                }
        };
        
        $scope.refreshCaptcha = function() {
            SiteServices.refreshCaptcha()
                .then(successHandler);
                function successHandler(response) {
                   $scope.captchaUrl = response.data.url;
                }
        };
}]);


SiteControllers.controller('ErrorController', ['$scope', '$location','authInterceptor', 
    function ($scope, $location, authInterceptor) {
        $scope.errorMessage = authInterceptor.data.lastError;  

        if (!$scope.errorMessage) {
            $location.path('/').replace();
        }
    }
]);

