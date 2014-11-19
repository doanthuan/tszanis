/**
 * Created by thuan on 11/19/2014.
 */

var myAppServices = angular.module('myApp.services', ['ngResource']);

myAppServices.factory('Country', ['$resource',
    function($resource) {
        return $resource('/api/country/:id', {id: '@id'});
}]);

myAppServices.factory('MultiCountryLoader', ['Country', '$q',
    function(Country, $q) {
        return function() {
            var delay = $q.defer();
            Country.query(function(countries) {
                delay.resolve(countries);
            }, function() {
                delay.reject('Unable to fetch countries');
            });
            return delay.promise;
        };
}]);

myAppServices.factory('Language', ['$resource',
    function($resource) {
        return $resource('/api/language/:id', {id: '@id'});
    }]);

myAppServices.factory('MultiLanguageLoader', ['Language', '$q',
    function(Language, $q) {
        return function() {
            var delay = $q.defer();
            Language.query(function(languages) {
                delay.resolve(languages);
            }, function() {
                delay.reject('Unable to fetch languages');
            });
            return delay.promise;
        };
    }]);

myAppServices.factory('TimeZone', ['$resource',
    function($resource) {
        return $resource('/api/timezone/:id', {id: '@id'});
    }]);

myAppServices.factory('MultiTimeZoneLoader', ['TimeZone', '$q',
    function(TimeZone, $q) {
        return function() {
            var delay = $q.defer();
            TimeZone.query(function(timezones) {
                delay.resolve(timezones);
            }, function() {
                delay.reject('Unable to fetch timezones');
            });
            return delay.promise;
        };
    }]);


myAppServices.factory('Role', ['$resource',
    function($resource) {
        return $resource('/api/role/:id', {id: '@id'});
    }]);

myAppServices.factory('MultiRoleLoader', ['Role', '$q',
    function(Role, $q) {
        return function() {
            var delay = $q.defer();
            Role.query(function(roles) {
                delay.resolve(roles);
            }, function() {
                delay.reject('Unable to fetch roles');
            });
            return delay.promise;
        };
    }]);