/**
 * General app route
 */
angular
  .module('app')
  .config(config);

config.$inject = ['$stateProvider', '$urlRouterProvider', '$locationProvider', '$authProvider', 'env'];
function config($stateProvider, $urlRouterProvider, $locationProvider, $authProvider, env) {
  $urlRouterProvider.otherwise("/404");
  $authProvider.loginUrl = env.url + 'authenticate';

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
    .state('auth', {
        url: '/auth',
        templateUrl: 'partials/auth/login.html',
        controller: 'AuthController'
    })
    .state('images', {
        url: '/images/:id',
        templateUrl: 'partials/auth/login.html',
        controller: 'ImageController'
    })
    .state('admin', {
        url: '/admin/instagramProfiles',
        templateUrl: 'partials/instagramProfiles/index.html',
        controller: 'instagramProfilesController'
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

