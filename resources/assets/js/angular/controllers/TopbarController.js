angular.module('app.controller').controller('TopbarController', function($scope) {
    $scope.menu2 = function() {
        return new sidetogglemenu({ // initialize second menu example
            id: 'right_chat_menu',
            position: 'right',
            pushcontent: false,
            //source: 'togglemenu.txt',
            revealamt: -5
        });
    };

    

    
});
