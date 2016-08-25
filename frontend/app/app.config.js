/**
 * Loading bar config
 */
angular
	.module('app')
  	.config(['cfpLoadingBarProvider', 
  		function(cfpLoadingBarProvider) {
    		cfpLoadingBarProvider.includeSpinner = false;
  		}
  	]);

angular
	.module('app')
	.filter('unsafe', unsafe);

unsafe.$inject = ['$sce'];
function unsafe($sce) {
	return $sce.trustAsHtml;
}

angular
	.module('infinite-scroll')
	.value('THROTTLE_MILLISECONDS', 250);
