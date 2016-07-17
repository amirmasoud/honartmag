/**
 * General app route
 */
angular
	.module('app')
	.config(config);

config.$inject = ['$routeProvider', '$locationProvider'];
function config($routeProvider, $locationProvider) {
	$routeProvider
		.when('/', {
			templateUrl: 'partials/index.html',
			controller: 'ImageController'
		})
		.when('/category/:name', {
			templateUrl: 'partials/index.html',
			controller: 'CategoryController',
		})
		.when('/404', {
			templateUrl: 'partials/404.html'
		})
		.otherwise({ redirectTo: '/404' });

	$locationProvider.html5Mode({
		enabled: true,
		requireBase: false
	});
}

