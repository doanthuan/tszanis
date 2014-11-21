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
      controller: 'UserLoginController'
  })
  .when('/user/logout', {
      controller: 'UserLogoutController',
      template: ''
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
          },
          user: function(authenticationSvc){
              return authenticationSvc.getUserInfo();
          },
          auth: ["$q", "authenticationSvc", function($q, authenticationSvc) {
              var userInfo = authenticationSvc.getUserInfo();

              if (userInfo) {
                  return $q.when(userInfo);
              } else {
                  return $q.reject({ authenticated: false });
              }
          }]
      }
  })

  ;
}])

.controller('UserLoginController', ['$scope','$http','$location', 'flash', 'authenticationSvc',
        function($scope, $http, $location, flash, authenticationSvc) {

        $scope.errorMsg = flash.getErrorMessage();
        $scope.successMsg = flash.getSuccessMessage();


        $scope.login = function(){
            authenticationSvc.login($scope.email, $scope.password).then(function(result) {
                flash.setSuccessMessage(result);
                $location.path('/user/profile');
            }, function(error) {
                $scope.successMsg = '';
                $scope.errorMsg = error;
            });
        };

}])

.controller('UserLogoutController', ['$scope','$http','$location', 'flash', 'authenticationSvc',
    function($scope, $http, $location, flash, authenticationSvc) {

        authenticationSvc.logout().then(function(result) {
            $location.path('/user/login');
        }, function(error) {
            flash.setErrorMessage(error);
            $location.path('/user/login');
        });

    }])

.controller('UserRegistController', ['$scope','$http','$location', 'flash',
    function($scope, $http, $location, flash) {

        $scope.errorMsg = flash.getErrorMessage();
        $scope.successMsg = flash.getSuccessMessage();


        $http.get('/api/country/list').success(function(data, status, headers, config) {
            $scope.countries = data.data;
        });

        $http.get('/api/language/list').success(function(data, status, headers, config) {
            $scope.languages = data.data;
        });

        $http.get('/api/timezone/list').success(function(data, status, headers, config) {
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

            $http.post('/api/user/register', postData).success(function(data, status, headers, config) {

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

        $scope.errorMsg = flash.getErrorMessage();
        $scope.successMsg = flash.getSuccessMessage();

        $scope.remindPassword = function(){
            var postData = {
                email: $scope.email
            };

            $http.post('/api/password/remind', postData).success(function(data, status, headers, config) {

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

            $http.post( '/api/password/reset', postData).success(function(data, status, headers, config) {
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

        $scope.errorMsg = flash.getErrorMessage();
        $scope.successMsg = flash.getSuccessMessage();

        $scope.activateToken = $routeParams.token;

        $http.get('/api/user/activate/'+$scope.activateToken).success(function(data, status, headers, config) {
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

.controller('UserProfileController', ['$scope','$http','$location', 'flash', 'authenticationSvc',
        'countries', 'languages',  'timezones', 'roles', 'user',
    function($scope, $http, $location, flash, authenticationSvc, countries, languages, timezones, roles, user) {

        $scope.errorMsg = flash.getErrorMessage();
        $scope.successMsg = flash.getSuccessMessage();

        $scope.countries = countries;
        $scope.languages = languages;
        $scope.timezones = timezones;
        $scope.roles = roles;

        $scope.user = user;

        $scope.saveProfile = function(){
            var userData = $scope.user;

            $http.post('/api/user/update-profile', userData).success(function(result) {

                if(result.status == 'success'){
                    authenticationSvc.setUserInfo(result.data);
                    $scope.successMsg = result.message;
                }
                else{
                    $scope.successMsg = '';
                    $scope.errorMsg = result.message;
                }

            }).error(function(data, status, headers, config) {
                console.log(data.message);
            });
        };
    }
    ]
)