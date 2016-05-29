angular
    .module('app')
    .factory('AuthService', auth);

function auth($http) {
    return {
        get : function(page) {
            return $http.get('http://localhost:8000/api/images', {
                params: { page: page }
            });
        },
        singular : function(id) {
            return $http.get('http://localhost:8000/api/images/' + id, {
                params: { id: id }
            });
        }
    }
}
