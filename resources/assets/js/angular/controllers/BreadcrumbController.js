angular.module('app.controller').controller('BreadcrumbController',function($scope, $location, $route, breadcrumbs) {
		$scope.location = $location;
		$scope.breadcrumbs = breadcrumbs; 
		$scope.isNumber = function (n) {
	    	return !isNaN(parseFloat(n)) && isFinite(n);
	    } 
    }
);