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
                    return ErrorService.handleError(response); 
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
                    return ErrorService.handleError(response); 
                }
        };
        
        obj.deleteparticip = function (participID) {
            return $http.delete("particips/" + participID )
                .then(successHandler)
                .catch(errorHandler);
                function successHandler(response) {
                    $route.reload();
                }
                function errorHandler(response){
                    return ErrorService.handleError(response); 
                }    
        };  

        return obj; 
    }
]);
