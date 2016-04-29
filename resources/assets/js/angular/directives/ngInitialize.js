(function(){
	"use strict";
	/**
	 *	@added by nady 03/22/2016 17:01 -> this directive is used for <input> value not empty from server 
	 *	and assigned to be used by angular
	*/
	angular.module('app.directive').directive('ngInitialize',function($parse){
		return {
			restrict: "A",
			compile: function($element,$attrs){
				var initialValue = $attrs.value || $element.val();
				return {
					pre: function($scope,$element,$attrs){
						$parse($attrs.ngModel).assign($scope,initialValue);
					}
				};
			}
		};
	});
})();