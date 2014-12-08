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

app.controller('AppController', ['$scope','$http','$location', 'flash', 'authenticationSvc',
    function($scope, $http, $location, flash, authenticationSvc) {

        $scope.$on("locationChangeStart", function(event) {

        });

        $scope.$on("$routeChangeSuccess", function(userInfo) {
            $scope.isLoggedIn = authenticationSvc.checkLogin();
            $scope.userInfo = authenticationSvc.getUserInfo();
        });

        $scope.$on("$routeChangeError", function(event, current, previous, eventObj) {
            if (eventObj.authenticated === false) {
                $location.path("/login");
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
