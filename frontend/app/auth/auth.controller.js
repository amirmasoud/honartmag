angular
	.module('app')
	.controller('AuthController', AuthController);

AuthController.$inject = ['$auth', '$state', '$scope'];
function AuthController($auth, $state, $scope) {
  var vm = this;
      
  $scope.login = function() {

    var credentials = {
      email: vm.email,
      password: vm.password
    }
    
    // Use Satellizer's $auth service to login
    $auth.login(credentials).then(function(data) {

      // If login is successful, redirect to the users state
      $state.go('users', {});
    });
  }

}
