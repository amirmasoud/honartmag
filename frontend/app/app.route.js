/**
 * General app route
 */
angular
	.module('app')
	.config(config);

config.$inject = ['$routeProvider'];
function config($routeProvider) {
	$routeProvider
		.when('/', {
			templateUrl: 'partials/index.html',
			controller: 'ImageController'
		});
}

