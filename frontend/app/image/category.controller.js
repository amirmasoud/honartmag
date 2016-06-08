angular
	.module('app')
	.controller('CategoryController', CategoryController);

CategoryController.$inject = ['$scope', '$http', 'ImageService', '$uibModal'];
function CategoryController($scope, $http, ImageService, $uibModal) {
	var vm = this;
    $scope.images = [];
    $scope.loadMoreBtn = 'بیشتر';
    $scope.finished = false;
    $scope.loadingModal = false;

    var busy = false,
    	page = 1;

    function getImages() {
		if (busy) return;
			busy = true;
    	$scope.loadMoreBtn = "<span class='load-more-spin fa fa-circle-o-notch fa-spin'></span> در حال آوردن موارد بیشتر...";

    	return ImageService.get(page)
	        .then(function(result) {
	        	if (!result['data']['next_page_url']) {
	        		$scope.finished = true;
					$scope.loadMoreBtn = 'تمام شد.';
	            	$scope.images = $scope.images.concat(result['data']['data']);
	        	} else {
					page = page + 1;
					$scope.images = $scope.images.concat(result['data']['data']);
					busy = false;
					$scope.loadMoreBtn = 'بیشتر';
	        	}
	        });
    }

	$scope.loadMore = function() {
		if (!$scope.finished)
			return getImages();
	}

	$scope.manualLoadMore = function() {
		return getImages();
	}

	$scope.openModal = function (id) {
		var self = this;
		self.loadingModal = true;
		var modalInstance = $uibModal.open({
			animation: true,
			templateUrl: '../../partials/modal.html',
			controller: 'ModalController',
			size: 'custom',
			resolve: {
				singular: function () {
					return ImageService.singular(id)
						.then(function(result) {
							self.loadingModal = false;
							return result['data'];
						});
				}
			}
		});
	};

	$scope.$on('$viewContentLoaded', function() {
	    getImages();
	});
}
