/**
 * Created by thuan on 11/19/2014.
 */
var directives = angular.module('myApp.directives', []);

directives.directive('loading',   ['$http', function ($http)
    {
        return {
            restrict: 'A',
            link: function (scope, elm, attrs)
            {
                scope.isLoading = function () {
                    return $http.pendingRequests.length > 0;
                };

                scope.$watch(scope.isLoading, function (v)
                {
                    if(v){
                        elm.modal('show');
                    }else{
                        elm.modal('hide');
                    }
                });
            }
        };

    }]);

directives.directive("passwordVerify", function() {
    return {
        require: "ngModel",
        scope: {
            passwordVerify: '='
        },
        link: function(scope, element, attrs, ctrl) {
            scope.$watch(function() {
                var combined;

                if (scope.passwordVerify || ctrl.$viewValue) {
                    combined = scope.passwordVerify + '_' + ctrl.$viewValue;
                }
                return combined;
            }, function(value) {
                if (value) {
                    ctrl.$parsers.unshift(function(viewValue) {
                        var origin = scope.passwordVerify;
                        if (origin !== viewValue) {
                            ctrl.$setValidity("passwordVerify", false);
                            return undefined;
                        } else {
                            ctrl.$setValidity("passwordVerify", true);
                            return viewValue;
                        }
                    });
                }
            });
        }
    };
});

directives.directive('butterbar', ['$rootScope',
    function($rootScope) {
        return {
            link: function(scope, element, attrs) {
                element.modal('hide');
                $rootScope.$on('$routeChangeStart', function() {
                    //element.removeClass('hide');
                    element.modal('show');
                });
                $rootScope.$on('$routeChangeSuccess', function() {
                    //element.addClass('hide');
                    element.modal('hide');
                });
            }
        };
    }]);

