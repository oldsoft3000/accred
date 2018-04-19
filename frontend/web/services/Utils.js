'use strict';

Utils.factory('Utils', [
    function() {
        var obj = {};

        obj.reformatDate = function(dt) {
            if (dt == null) {
                return '';
            }
            var mm = dt.getMonth() + 1; 
            var dd = dt.getDate();

            var result =    [dt.getFullYear(),
                            (mm>9 ? '' : '0') + mm,
                            (dd>9 ? '' : '0') + dd].join('-');

            return new Date(result);
        };

        obj.toUTC = function(dt) {
            if (dt == null) {
                return '';
            }
            var offset = new Date().getTimezoneOffset();

            dt.setHours(dt.getHours() - offset / 60);

            return dt;
        };


        return obj;
    }
]);