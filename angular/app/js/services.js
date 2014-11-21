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


myAppServices.factory("authenticationSvc", function($http, $q, $window) {
    var userInfo;

    function init() {
        if ($window.sessionStorage["userInfo"]) {
            userInfo = JSON.parse($window.sessionStorage["userInfo"]);
        }
    }

    init();

    function login(email, password) {
        var deferred = $q.defer();

        var postData = {
            email: email,
            password: password
        };

        $http.post('/api/user/login', postData).success(function(result) {
            if(result.status == 'success'){
                userInfo = result.data;
                $window.sessionStorage["userInfo"] = JSON.stringify(userInfo);
                deferred.resolve(result.message);
            }
            else{
                deferred.reject(result.message);
            }

        }).error(function(result) {
            deferred.reject(result.message);
        });

        return deferred.promise;
    }

    function logout() {
        var deferred = $q.defer();

        $http.get('/api/user/logout').success(function(result) {
            if(result.status == 'success'){
                $window.sessionStorage["userInfo"] = null;
                userInfo = null;
                deferred.resolve(result.message);
            }
            else{
                deferred.reject(result.message);
            }

        }).error(function(result) {
            deferred.reject(result.message);
        });

        return deferred.promise;
    }


    function getUserInfo() {
        return userInfo;
    }

    function setUserInfo(value){
        userInfo = value;
        $window.sessionStorage["userInfo"] = JSON.stringify(userInfo);
    }

    function checkLogin(){
        if(userInfo){
            return true;
        }
        return false;
    }

    return {
        login: login,
        logout: logout,
        checkLogin: checkLogin,
        getUserInfo: getUserInfo,
        setUserInfo: setUserInfo
    };
});