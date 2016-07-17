angular
    .module('app')
    .factory('ImageService', image);

image.$inject = ['$http', 'env'];
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
        },
        category : function(name, page) {
            return $http.get(env.url + 'categories/' + name, {
                params: { page: page }
            });
        }
    }
}
