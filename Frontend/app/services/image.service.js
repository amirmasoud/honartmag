angular
    .module('app')
    .factory('ImageService', image);

function image($http, env) {
    return {
        get : function(page) {
            return $http.get(env.url + 'images', {
                params: { page: page }
            });
        },
        singular : function(id) {
            return $http.get(env.url + 'images/' + id, {
                params: { id: id }
            });
        }
    }
}
