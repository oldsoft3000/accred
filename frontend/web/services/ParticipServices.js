'use strict';

ParticipApp.factory('ParticipServices', ['$http', '$route', '$q', 'ErrorService',
    function($http, $route, $q, ErrorService) {
        var obj = {};
        
        obj.create = function (userModel) {
            return $http.post('particip/create', userModel)
                .then(successHandler)
                .catch(errorHandler);
                function successHandler(response) {
                    return response;
                }
                function errorHandler(response) {
                    return $q.reject(response);
                }  
        };

        obj.getparticips = function(){
            return $http.get("particip/view")
                .then(successHandler)
                .catch(errorHandler);
                function successHandler(response) {
                    return response;
                }
                function errorHandler(response) {
                    ErrorService.printError(response);
                    return $q.reject(response);
                }
        };
        
        obj.deleteparticip = function (participID) {
            return $http.delete("particip/particips/" + participID )
                .then(successHandler)
                .catch(errorHandler);
                function successHandler(response) {
                    $route.reload();
                }
                function errorHandler(response){
                    ErrorService.printError(response);
                    return $q.reject(response);
                }    
        };  

        return obj; 
    }
]);
