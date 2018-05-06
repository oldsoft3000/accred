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

        obj.createUniqueList = function(table, field_name) {
            var result = [];

            result.push({'value': null, 'label': null});

            var m = new Map(); ;

            table.forEach(function(row) {
                if (row[field_name] != null) {
                    m.set( row[field_name], row[field_name] );
                }
            });

            m.forEach(function(value, key, mapObj) {
                result.push({'value': value, 'label': value});
            });

            return result;
        }

        return obj;
    }
]);