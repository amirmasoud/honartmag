/**
 * General app route
 */
angular
  .module('app')
  .config(config);

config.$inject = ['$stateProvider', '$urlRouterProvider', '$locationProvider'];
function config($stateProvider, $urlRouterProvider, $locationProvider) {
  $urlRouterProvider.otherwise("/404");

  $stateProvider
    .state('home', {
      url: "/",
      templateUrl: "partials/index.html",
      controller: 'ImageController'
    })
    .state('category', {
      url: "/category/:name",
      templateUrl: "partials/index.html",
      controller: "CategoryController"
    })
    .state('404', {
      url: "/404",
      templateUrl: "partials/404.html"
    });

  $locationProvider.html5Mode({
    enabled: true,
    requireBase: false
  });
}

