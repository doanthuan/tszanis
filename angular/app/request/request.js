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

  .when('/request/list', {
      templateUrl: 'request/list.html',
      controller: 'ListRequestCtrl',
      resolve: {
          requests: function(MultiRequestLoader) {
              return MultiRequestLoader();
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

  .when('/request/view/:requestId', {
      controller: 'ViewRequestCtrl',
      resolve: {
          transRequest: function(RequestLoader) {
              return RequestLoader();
          }
      },
      templateUrl:'request/view.html'
  })

  ;
}])


.controller('CreateRequestCtrl', ['$scope','$http','$location', 'flash', 'authenticationSvc',
        'countries', 'languages', 'TransRequest',
        function($scope, $http, $location, flash, authenticationSvc, countries, languages, TransRequest ) {

            $scope.errorMsg = flash.getErrorMessage();
            $scope.successMsg = flash.getSuccessMessage();

            $scope.countries = countries;
            $scope.languages = languages;

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

.controller('ListRequestCtrl', ['$scope','$http','$location', 'flash', 'authenticationSvc',  'requests',
    function($scope, $http, $location, flash, authenticationSvc, requests ) {

        $scope.errorMsg = flash.getErrorMessage();
        $scope.successMsg = flash.getSuccessMessage();

        $scope.requests = requests;

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
        return $resource('/api/request/:id', {id: '@id'});
    }]
);

requestModule.factory('MultiRequestLoader', ['TransRequest', '$q',
    function(TransRequest, $q) {
        return function() {
            var delay = $q.defer();
            TransRequest.query(function(countries) {
                delay.resolve(countries);
            }, function() {
                delay.reject('Unable to fetch requestes');
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