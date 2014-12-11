'use strict';

// Declare app level module which depends on views, and components
var app = angular.module('myApp', [
    'ngRoute',
    'myApp.user',
    'myApp.request',
    'myApp.version',
    'myApp.services',
    'myApp.directives',
    'myApp.filters'
]).
config(['$routeProvider', function($routeProvider) {
  $routeProvider.otherwise({redirectTo: '/user/login'});
}]);

//app.config(['$httpProvider', function($httpProvider) {
//    $httpProvider.defaults.withCredentials = true;
//}])

app.factory('authInterceptor', function ($rootScope, $q, $location, $window) {
    return {
        request: function (config) {
            config.headers = config.headers || {};
            var userInfo = JSON.parse($window.sessionStorage["userInfo"]);
            if (userInfo && userInfo.token) {
                config.headers['X-Auth-Token'] = userInfo.token;
            }
            return config;
        },
        response: function (response) {
            if (response.code === 401) {
                // handle the case where the user is not authenticated
                $location.path('/user/login');
            }
            return response || $q.when(response);
        }
    };
});

app.config(function ($httpProvider) {
    $httpProvider.interceptors.push('authInterceptor');
});


app.controller('AppController', ['$scope','$http','$location', 'flash', 'authenticationSvc',
    function($scope, $http, $location, flash, authenticationSvc) {

        $scope.$on("locationChangeStart", function(event) {

        });

        $scope.$on("$routeChangeSuccess", function() {
            $scope.isLoggedIn = authenticationSvc.isLogin();
            $scope.userInfo = authenticationSvc.getUserInfo();
        });

        $scope.$on("$routeChangeError", function(event, current, previous, eventObj) {
            if (eventObj.authenticated === false) {
                authenticationSvc.logout().then(function(result) {
                    $location.path('/user/login');
                });
            }
        });

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

var APIURL = "http://api.laravel_angular.local";
