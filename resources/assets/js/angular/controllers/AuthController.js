angular.module('app.controller')
.controller('AuthController', function($scope,Restangular,ToastyService,$location,$window,$uibModal) {
    $scope.form = {};
    $scope.data_country = [];
    $scope.getCountry = function(callback){
        Restangular.all('country').withHttpConfig({ cache: true }).doGET().then(function(response){
            $scope.data_country = response;            
        });
    };

    $scope.actRegister = function(isValid){
        $scope.submitted = true;        
        if(isValid){
            $scope.form.country_code = angular.element('li.country.active').attr('data-country-code');
            Restangular.all('register').post($scope.form).then(function(response){                
                if(response.status!==200)
                    ToastyService.error(response.message);
                else{
                    ToastyService.success(response.message);
                    $window.location.href = 'register-success';
                }                    
            }, function (error){                
                ToastyService.error(error.data.message);
            });
        }
    };

    $scope.actLogin = function(isValid){
        $scope.submitted = true;        
        if(isValid){
            Restangular.all('login').post($scope.form).then(function(response){                
                if(response.status!==200)
                    ToastyService.error(response.message);
                else{
                    ToastyService.success(response.message);
                    $window.location.href = 'dashboard';
                }                
            }, function (error){                
                ToastyService.error(error.data.message);
            });
        }
    };

    $scope.openModal = function() {
        var modalInstance = $uibModal.open({
            animation: true,
            templateUrl: 'modalRegister.html',
            controller: 'ModalController',
            size: 'sm',
            backdropClass: 'modal-backdrop-full-heigth'            
        });        
    };
}).controller('ModalController', function($scope,$uibModalInstance,Restangular,$window,ToastyService) {
    $scope.selected = {};

    $scope.actRegister = function(isValid){
        $scope.submitted = true;        
        if(isValid){
            $scope.form.country_code = angular.element('li.country.active').attr('data-country-code');
            Restangular.all('register').post($scope.form).then(function(response){                
                if(response.status!==200)
                    ToastyService.error(response.message);
                else{
                    ToastyService.success(response.message);
                    $window.location.href = 'register-success';
                }
            }, function (error){                
                ToastyService.error(error.data.message);
            });
        }
    };

    $scope.ok = function () {
        $uibModalInstance.close($scope.selected);
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };    

});
