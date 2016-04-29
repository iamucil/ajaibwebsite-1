angular.module('app.controller').controller('TopbarController', function($scope,Restangular,ToastyService,$location,$window) {
    $scope.menu2 = function() {
        return new sidetogglemenu({ // initialize second menu example
            id: 'right_chat_menu',
            position: 'right',
            pushcontent: false,
            //source: 'togglemenu.txt',
            revealamt: -5
        });
    };

    $scope.logout = function(){
    	Restangular.all('logout').doGET().then(function(response){                
            if(response.status!==200)
                ToastyService.error(response.message);
            else{
                ToastyService.success(response.message);
                $window.location.href = 'login';
            }
                
        }, function (error){                
            ToastyService.error(error.data.message);
        });
    };

    
});
