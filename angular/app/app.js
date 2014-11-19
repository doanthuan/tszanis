'use strict';

// Declare app level module which depends on views, and components
var app = angular.module('myApp', [
    'ngRoute',
    'myApp.user',
    'myApp.view2',
    'myApp.version',
    'myApp.services',
    'myApp.directives',
]).
config(['$routeProvider', function($routeProvider) {
  $routeProvider.otherwise({redirectTo: '/user/login'});
}]);

app.factory("flash", function(){
    var errorMessage = '';
    var successMessage = '';

    return {
        getSuccessMessage: function () {
            var tmp = successMessage;
            successMessage = '';
            return tmp;
        },
        setSuccessMessage: function(value) {
            successMessage = value;
        },
        getErrorMessage: function () {
            var tmp = errorMessage;
            errorMessage = '';
            return tmp;
        },
        setErrorMessage: function(value) {
            errorMessage = value;
        }
    };
});

app.factory('UserService', ['$http', '$q', '$window',  function($http, $q, $window) {

    var baseUrl = 'http://laravel_angular.local/api';

    var userInfo = null;

    function init() {
        if ($window.sessionStorage["userInfo"]) {
            userInfo = JSON.parse($window.sessionStorage["userInfo"]);
        }
    }

    init();

    return {
        getUser: function(){
            return userInfo;
        },
        setUser: function(value){
            $window.sessionStorage["userInfo"] = JSON.stringify(value);

            userInfo = value;
        }
    };
}]
);

app.factory("authenService", function($http, $q, $window) {
    var userInfo;

    function login(userName, password) {
        var deferred = $q.defer();

        $http.post("/api/login", {
            userName: userName,
            password: password
        }).then(function(result) {
            userInfo = {
                accessToken: result.data.access_token,
                userName: result.data.userName
            };
            $window.sessionStorage["userInfo"] = JSON.stringify(userInfo);
            deferred.resolve(userInfo);
        }, function(error) {
            deferred.reject(error);
        });

        return deferred.promise;
    }

    return {
        login: login
    };
});

