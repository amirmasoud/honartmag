angular
	.module('app')
	.controller('ModalController', ModalController);

ModalController.$inject = ['$scope', 'ImageService', 'hotkeys', '$uibModalInstance', 'singular'];
function ModalController($scope, ImageService, hotkeys, $uibModalInstance, singular) {
	$scope.singular = singular;
	$scope.loadingImageNext = false;
	$scope.loadingImagePrev = false;

	$scope.openImage = function(id, direction) {
		if (id) {
			if (typeof direction !== 'undefined')
				$scope['loadingImage' + direction] = true;

			return ImageService.singular(id)
				.then(function(result) {
					$scope.singular.standard_resolution = '#';
					$scope.singular = result['data'];
					$scope['loadingImage' + direction] = false;
				});
		}
	}

	$scope.close = function () {
		$uibModalInstance.dismiss();
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
