angular
	.module('app')
	.controller('ModalController', ModalController);

ModalController.$inject = ['$scope', 'ImageService', 'hotkeys', '$uibModalInstance', 'singular', '$stateParams', '$state'];
function ModalController($scope, ImageService, hotkeys, $uibModalInstance, singular, $stateParams, $state) {
	$scope.singular = singular;
	$scope.loadingImageNext = false;
	$scope.loadingImagePrev = false;
	$scope.category = $stateParams.name;

	$scope.openImage = function(id, direction) {
		if (id) {
			$state.go('images', {id: id}, {notify: false});
			if (typeof direction !== 'undefined')
				$scope['loadingImage' + direction] = true;
			if (typeof $scope.category !== 'undefined') {
				return ImageService.singularCat($scope.category, id)
					.then(function(result) {
						$scope.singular.standard_resolution = '#';
						$scope.singular = result['data'];
						$scope['loadingImage' + direction] = false;
					});
			} else {
				return ImageService.singular(id)
					.then(function(result) {
						$scope.singular.standard_resolution = '#';
						$scope.singular = result['data'];
						$scope['loadingImage' + direction] = false;
					});
			}
		}
	}

	$scope.close = function () {
		$uibModalInstance.dismiss();
		$state.go('images', {id: $scope.singular.next}, {notify: false});
	};

	hotkeys.add({
		combo: 'right',
		callback: function() {
			$scope.openImage($scope.singular.next, 'Prev');
		}
	});

	hotkeys.add({
		combo: 'left',
		callback: function() {
			$scope.openImage($scope.singular.prev, 'Next');
		}
	});
}
