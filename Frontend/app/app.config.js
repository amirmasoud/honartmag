/**
 * Config HTML5 mode
 * @param  {Provider} $locationProvider
 * @return {null}
 */
angular
	.module('app')
	.config(config);

function config($locationProvider) {
	if(window.history && window.history.pushState){
		$locationProvider.html5Mode({
			enabled: true,
			requireBase: false
		});
	}
}

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

function unsafe($sce) {
	return $sce.trustAsHtml;
}

angular
	.module('infinite-scroll')
	.value('THROTTLE_MILLISECONDS', 250);

