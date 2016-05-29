/**
 * General app route
 */
angular
	.module('app')
	.config(config);

function config($routeProvider, $authProvider) {
	$routeProvider
		.when('/', {
			templateUrl: 'partials/index.html',
			controller: 'ImageController'
		});
}

