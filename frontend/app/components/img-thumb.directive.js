angular
    .module('app')
    .directive('imgThumb', imgThumb);

function imgThumb() {
    var directive = {
        scope: {
            image: '=',
            loading: '='
        },
        templateUrl: 'components/img-thumb.directive.html',
        restrict: 'E',
    };
    return directive;
};
