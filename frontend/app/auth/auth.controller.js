angular
	.module('app')
	.controller('AuthController', AuthController);

AuthController.$inject = ['$auth', '$state', '$scope', '$rootScope'];
function AuthController($auth, $state, $scope, $rootScope) {   
  $rootScope.authFail = false;
  $scope.auth = function(isValid) {
    var user = {
      email: $scope.auth.email,
      password: $scope.auth.password
    };

    if (isValid){
      $auth.login(user)
        .then(function(response) {
          $state.go('home');
        })
        .catch(function(response) {
          $rootScope.authFail = true;
          $rootScope.authMessage = 'ایمیل یا پسورد اشتباه وارد شده است.';
        });
    }
  }

}
