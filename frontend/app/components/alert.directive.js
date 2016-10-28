angular
    .module('app')
    .directive('alert', alert);

function alert() {
    var directive = {
        scope: {
            type: '@',
            title: '@',
            message: '@',
            show: '='
        },
        templateUrl: 'components/alert.directive.html',
        replace: 'true',
        restrict: 'E',
    };

    return directive;
};
