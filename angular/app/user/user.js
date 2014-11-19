'use strict';

angular.module('myApp.user', ['ngRoute', 'remoteValidation'])

.config(['$routeProvider', function($routeProvider) {
  $routeProvider
    .when('/user/register', {
    templateUrl: 'user/register.html',
    controller: 'UserRegistController'
  })
  .when('/user/login', {
      templateUrl: 'user/login.html',
      controller: 'UserController'
  })
  .when('/user/remind', {
      templateUrl: 'user/remind.html',
      controller: 'UserRemindController'
  })
  .when('/user/reset/:token', {
      templateUrl: 'user/reset.html',
      controller: 'UserResetController'
  })
  .when('/user/activate/:token', {
      template: '',
      controller: 'UserActivateController'
  })
  .when('/user/profile', {
      templateUrl: 'user/profile.html',
      controller: 'UserProfileController',
      resolve: {
          countries: function(MultiCountryLoader) {
              return MultiCountryLoader();
          },
          languages: function(MultiLanguageLoader) {
              return MultiLanguageLoader();
          },
          timezones: function(MultiTimeZoneLoader) {
              return MultiTimeZoneLoader();
          },
          roles: function(MultiRoleLoader) {
              return MultiRoleLoader();
          }
      }
  })
  ;
}])

.controller('UserController', ['$scope','$http','$location', 'flash', 'UserService',
        function($scope, $http, $location, flash, UserService) {

        var baseUrl = 'http://laravel_angular.local/api';
        $scope.errorMsg = flash.getErrorMessage();
        $scope.successMsg = flash.getSuccessMessage();


        $scope.login = function(){
            var postData = {
                email: $scope.email,
                password: $scope.password
            };

            $http.post(baseUrl + '/user/login', postData).success(function(data, status, headers, config) {

                if(data.status == 'success'){

                    UserService.setUser(data.data);

                    flash.setSuccessMessage(data.message);
                    $location.path('/user/profile');
                }
                else{
                    $scope.successMsg = '';
                    $scope.errorMsg = data.message;
                }

            }).error(function(data, status, headers, config) {
                console.log(data.message);
            });
        };

}])

.controller('UserRegistController', ['$scope','$http','$location', 'flash',
    function($scope, $http, $location, flash) {

        var baseUrl = 'http://laravel_angular.local/api';
        $scope.errorMsg = flash.getErrorMessage();
        $scope.successMsg = flash.getSuccessMessage();


        $http.get(baseUrl + '/country/list').success(function(data, status, headers, config) {
            $scope.countries = data.data;
        });

        $http.get(baseUrl + '/language/list').success(function(data, status, headers, config) {
            $scope.languages = data.data;
        });

        $http.get(baseUrl + '/timezone/list').success(function(data, status, headers, config) {
            $scope.timezones = data.data;

        });


        $scope.saveUser = function(){
            var postData = {
                email: $scope.email,
                password: $scope.password,
                first_name: $scope.first_name,
                last_name: $scope.last_name,
                phone: $scope.phone,
                timezone_id: $scope.timezone,
                lang_id: $scope.language,
                country_id: $scope.country
            };

            $http.post(baseUrl + '/user/register', postData).success(function(data, status, headers, config) {

                if(data.status == 'success'){
                    flash.setSuccessMessage(data.message);
                    $location.path('/user/login');
                }
                else{
                    $scope.successMsg = '';
                    $scope.errorMsg = data.message;
                }

            }).error(function(data, status, headers, config) {
                console.log(data.message);
            });
        };
}])

.controller('UserRemindController', ['$scope','$http','$location', 'flash',
    function($scope, $http, $location, flash) {

        var baseUrl = 'http://laravel_angular.local/api';
        $scope.errorMsg = flash.getErrorMessage();
        $scope.successMsg = flash.getSuccessMessage();

        $scope.remindPassword = function(){
            var postData = {
                email: $scope.email
            };

            $http.post(baseUrl + '/password/remind', postData).success(function(data, status, headers, config) {

                if(data.status == 'success'){
                    flash.setSuccessMessage(data.message);
                    $location.path('/user/login');
                }
                else{
                    $scope.successMsg = '';
                    $scope.errorMsg = data.message;
                }

            }).error(function(data, status, headers, config) {
                console.log(data.message);
            });
        };
    }
]
)

.controller('UserResetController', ['$scope','$http','$location', 'flash', '$routeParams',
    function($scope, $http, $location, flash, $routeParams) {

        var baseUrl = 'http://laravel_angular.local/api';
        $scope.errorMsg = flash.getErrorMessage();
        $scope.successMsg = flash.getSuccessMessage();

        $scope.resetToken = $routeParams.token;

        $scope.resetPassword = function(){
            var postData = {
                email: $scope.email,
                password: $scope.password,
                password_confirmation: $scope.password_confirm,
                token: $scope.resetToken
            };

            $http.post(baseUrl + '/password/reset', postData).success(function(data, status, headers, config) {
                if(data.status == 'success'){
                    flash.setSuccessMessage(data.message);
                    $location.path('/user/login');
                }
                else{
                    $scope.successMsg = '';
                    $scope.errorMsg = data.message;
                }

            }).error(function(data, status, headers, config) {
                console.log(data.message);
            });
        };


    }
    ]
)

.controller('UserActivateController', ['$scope','$http','$location', 'flash', '$routeParams',
    function($scope, $http, $location, flash, $routeParams) {

        var baseUrl = 'http://laravel_angular.local/api';
        $scope.errorMsg = flash.getErrorMessage();
        $scope.successMsg = flash.getSuccessMessage();

        $scope.activateToken = $routeParams.token;

        $http.get(baseUrl + '/user/activate/'+$scope.activateToken).success(function(data, status, headers, config) {
            if(data.status == 'success'){
                flash.setSuccessMessage(data.message);
                $location.path('/user/login');
            }
            else{
                flash.setErrorMessage(data.message);
                $location.path('/user/login');
            }

        }).error(function(data, status, headers, config) {
            console.log(data.message);
        });

    }]
)

.controller('UserProfileController', ['$scope','$http','$location', 'flash', 'UserService',
        'countries', 'languages',  'timezones', 'roles',
    function($scope, $http, $location, flash, UserService, countries, languages, timezones, roles) {

        var baseUrl = 'http://laravel_angular.local/api';
        $scope.errorMsg = flash.getErrorMessage();
        $scope.successMsg = flash.getSuccessMessage();

        $scope.countries = countries;
        $scope.languages = languages;
        $scope.timezones = timezones;
        $scope.roles = roles;

        $scope.user = UserService.getUser();
        console.log($scope.user);

        $scope.saveProfile = function(){
            var userData = $scope.user;

            console.log(userData);

            $http.post(baseUrl + '/user/update-profile', userData).success(function(data, status, headers, config) {

                if(data.status == 'success'){
                    $scope.successMsg = data.message;
                }
                else{
                    $scope.successMsg = '';
                    $scope.errorMsg = data.message;
                }

            }).error(function(data, status, headers, config) {
                console.log(data.message);
            });
        };
    }
    ]
)