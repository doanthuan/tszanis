'use strict';

var requestModule = angular.module('myApp.request', ['ngRoute','smart-table'] )

.config(['$routeProvider', function($routeProvider) {
  $routeProvider
  .when('/request/create', {
    templateUrl: 'request/create.html',
    controller: 'CreateRequestCtrl',
      resolve: {
          countries: function(MultiCountryLoader) {
              return MultiCountryLoader();
          },
          languages: function(MultiLanguageLoader) {
              return MultiLanguageLoader();
          },
          specs: function(MultiSpecialtyLoader) {
              return MultiSpecialtyLoader();
          },
          auth: ["authenticationSvc", function(authenticationSvc) {
              return authenticationSvc.checkLogin();
          }]
      }
  })

  .when('/request/list', {
      templateUrl: 'request/list.html',
      controller: 'ListRequestCtrl',
      resolve: {
          requests: function(MultiRequestLoader) {
              return MultiRequestLoader();
          },
          auth: ["authenticationSvc", function(authenticationSvc) {
              return authenticationSvc.checkLogin();
          }]
      }
  })

  .when('/request/view/:requestId', {
      controller: 'ViewRequestCtrl',
      resolve: {
          transRequest: function(RequestLoader) {
              return RequestLoader();
          },
          auth: ["authenticationSvc", function(authenticationSvc) {
              return authenticationSvc.checkLogin();
          }]
      },
      templateUrl:'request/view.html'
  })

  .when('/request/mylist', {
      templateUrl: 'request/mylist.html',
      controller: 'MyListRequestCtrl',
      resolve: {
          auth: ["authenticationSvc", function(authenticationSvc) {
              return authenticationSvc.checkLogin();
          }]
      }
  })

  .when('/request/workinglist', {
      templateUrl: 'request/workinglist.html',
      controller: 'WorkingListRequestCtrl',
      resolve: {
          auth: ["authenticationSvc", function(authenticationSvc) {
              return authenticationSvc.checkLogin();
          }]
      }
  })

  ;
}])


.controller('CreateRequestCtrl', ['$scope','$http','$location', 'flash', 'authenticationSvc',
        'countries', 'languages','specs', 'TransRequest',
        function($scope, $http, $location, flash, authenticationSvc, countries, languages, specs, TransRequest ) {

            $scope.errorMsg = flash.getErrorMessage();
            $scope.successMsg = flash.getSuccessMessage();

            $scope.countries = countries;
            $scope.languages = languages;
            $scope.specs = specs;

            var userInfo = authenticationSvc.getUserInfo();
            $scope.request = new TransRequest({
                user_id: userInfo.user_id
            });


            $scope.createRequest = function(){
                $scope.request.$save(function(request) {
                    $location.path('/request/list');
                }, function(error) {
                    $scope.successMsg = '';
                    $scope.errorMsg = error;
                });
            };
        }
    ]
)

.controller('ListRequestCtrl', ['$scope','$http','$route', '$location', 'flash', 'authenticationSvc', 'requests', 'TransRequest',
    function($scope, $http, $route, $location, flash, authenticationSvc, requests, TransRequest ) {

        $scope.errorMsg = flash.getErrorMessage();
        $scope.successMsg = flash.getSuccessMessage();

        $scope.requests = requests;

        $scope.acceptRequest = function(requestId){
            var requestData = {
                id: requestId,
                status: 3,
                translator_id: $scope.$parent.userInfo.user_id
            };


            TransRequest.update(requestData, function(result) {
                flash.setSuccessMessage(result.message);
                $route.reload();
            }, function(error) {
                $scope.successMsg = '';
                $scope.errorMsg = error;
            });
        };

        $scope.cancelRequest = function(requestId){
            var requestData = {
                id: requestId,
                status: 2
            };


            TransRequest.update(requestData, function(result) {
                flash.setSuccessMessage(result.message);
                $route.reload();
            }, function(error) {
                $scope.successMsg = '';
                $scope.errorMsg = error;
            });
        };

    }
]
)

.controller('MyListRequestCtrl', ['$scope','$http', '$route','$location', 'flash', 'authenticationSvc', 'TransRequest',
    function($scope, $http, $route, $location, flash, authenticationSvc, TransRequest ) {

        $scope.errorMsg = flash.getErrorMessage();
        $scope.successMsg = flash.getSuccessMessage();

        var params = {
            user_id: $scope.$parent.userInfo.user_id,
            role_id: 4//get requestes created by requester
        };

        TransRequest.query( params ,function(requests) {
            $scope.requests = requests;
        }, function(error) {
            //$scope.errorMsg = error;
            $location.path('/user/logout');
        });


        $scope.completeRequest = function(requestId){
            var requestData = {
                id: requestId,
                status: 4
            };


            TransRequest.update(requestData, function(result) {
                flash.setSuccessMessage(result.message);
                $route.reload();
            }, function(error) {
                $scope.successMsg = '';
                $scope.errorMsg = error;
            });
        };

    }
]
)

.controller('WorkingListRequestCtrl', ['$scope','$http', '$route','$location', 'flash', 'authenticationSvc', 'TransRequest',
    function($scope, $http, $route, $location, flash, authenticationSvc, TransRequest ) {

        $scope.errorMsg = flash.getErrorMessage();
        $scope.successMsg = flash.getSuccessMessage();

        var params = {
            user_id: $scope.$parent.userInfo.user_id,
            role_id: 3//get requestes accepted by translator
        };

        TransRequest.query( params ,function(requests) {
            $scope.requests = requests;
        }, function(error) {
            //$scope.errorMsg = error;
            $location.path('/user/logout');
        });


        $scope.completeRequest = function(requestId){
            var requestData = {
                id: requestId,
                status: 4
            };


            TransRequest.update(requestData, function(result) {
                flash.setSuccessMessage(result.message);
                $route.reload();
            }, function(error) {
                $scope.successMsg = '';
                $scope.errorMsg = error;
            });
        };

    }
]
)

.controller('ViewRequestCtrl', ['$scope', '$location', 'flash','transRequest',
    function($scope, $location, flash, transRequest) {

        $scope.errorMsg = flash.getErrorMessage();
        $scope.successMsg = flash.getSuccessMessage();

        $scope.transRequest = transRequest;

        console.log($scope.transRequest);

        $scope.edit = function() {
            $location.path('/edit/' + recipe.id);
        };
    }])

;




requestModule.factory('TransRequest', ['$resource',
    function($resource) {
        return $resource(APIURL+'/request/:id', {id: '@id'},{
                update: {
                    method: 'PUT'
                }
            }
        );
    }]
);

requestModule.factory('MultiRequestLoader', ['TransRequest', '$q', 'authenticationSvc',
    function(TransRequest, $q, authenticationSvc) {
        return function() {
            var delay = $q.defer();

            var userInfo = authenticationSvc.getUserInfo();
            if(userInfo.roles.indexOf(3) >= 0){
                var params = {
                    "languages[]": userInfo.languages
                };
            }

            TransRequest.query(params, function(requests) {
                delay.resolve(requests);
            }, function() {
                delay.reject('Unable to fetch requests');
            });
            return delay.promise;
        };
    }]);

requestModule.factory('RequestLoader', ['TransRequest', '$route', '$q',
    function(TransRequest, $route, $q) {
        return function() {
            var delay = $q.defer();
            TransRequest.get({id: $route.current.params.requestId}, function(transRequest) {
                delay.resolve(transRequest);
            }, function() {
                delay.reject('Unable to fetch request '  + $route.current.params.requestId);
            });
            return delay.promise;
        };
    }
]);