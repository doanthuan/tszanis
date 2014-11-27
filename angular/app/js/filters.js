/**
 * Created by thuan on 11/24/2014.
 */
angular.module('myApp.filters', []).filter('requestStatus', function() {
    return function(input) {
        switch(input){
            case 1:
                return 'Created';
            case 2:
                return 'Canceled';
            case 3:
                return 'Assigned';
            case 4:
                return 'Completed';
        }
    };
});
