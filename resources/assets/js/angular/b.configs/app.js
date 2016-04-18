function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}

angular.module('app', [
    'ngRoute',
    'ngResource',
    'ngAnimate',
    'ngTouch',
    'restangular',
    'app.config',
    'app.filter',
    'app.controller',
    'app.service',
    'app.directive',
    'ngStorage',
    'ui.bootstrap',
    'appRoutes',
    'datatables',
    'internationalPhoneNumber'    
], function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

angular.module('app.config', ['angular-loading-bar']);
angular.module('app.controller', ['ngFileUpload','angular-loading-bar']);
angular.module('app.service', ['angular-toasty']);
angular.module('app.directive', []);
angular.module('app.filter', []);

angular.module('app.config').config(function(RestangularProvider,cfpLoadingBarProvider) {
        cfpLoadingBarProvider.includeSpinner = false;

        RestangularProvider
            .setBaseUrl('/ajaib/')
            .setDefaultHeaders({                
                'X-Requested-With': 'XMLHttpRequest',
                'Authorization' : 'Bearer ' + getCookie('XSRF-TOKEN'),
                'X-CSRF-TOKEN' : getCookie('XSRF-TOKEN')
            })
            .setErrorInterceptor(
                function(response) {
                    if (response.status == 401) {
                        if (response.config.url == "authenticate") {
                            //  allow processing to continue so my login controller can show an error message
                            return true;
                        } else {
                            // alert('Caught 401 auth. Redirecting to login');
                            // ISSUE: hack since ui.router $state not available here. 
                            // CAN we setup interceptor where services are available?
                            window.location = document.location.protocol + '//' + document.location.host + '/login/?redirect='+encodeURIComponent(document.location+document.location.search);
                            return false;
                        }
                    }
                    // alert('REST ERROR HANDLER CODE:' + response.status);
                    return false; // stop the promise chain
                    // see http://www.develop.com/httpstatuscodesrest
                });
    });