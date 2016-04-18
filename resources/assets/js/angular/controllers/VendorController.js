angular.module('app.controller')
.controller('VendorController', function($scope, Restangular,$routeParams,Upload,ToastyService,$location) {

    $scope.ActDelete = function(id){
        alertify.confirm("Are you sure you wish to delete this recipe?", function(e) {
            if (e) {
                $scope.form ={'_method':'delete'};
                Restangular.all('vendors/'+id).post($scope.form).then(function(response){
                    if(response.status!==200) 
                        ToastyService.error(response.message);
                    else{
                        ToastyService.success(response.message);
                        $scope.getVendor();
                    }
                        
                }, function (error){                
                    ToastyService.error(error.data.message);
                });
            } else {
                // nothing happend
            }
        });
    };

    $scope.getVendor = function() {
        // This will query /accounts and return a promise.
        Restangular.all('vendors').doGET().then(function(response) {
            $scope.vendors = response;            
        });
    };    
    $scope.form = {};    
    $scope.getEdit = function(){
        $scope.currentId = $routeParams.action;  //check :action in when provider        
        Restangular.all('vendors').doGET($scope.currentId+'/edit').then(function(response) {
            $scope.category = response.categories;
            $scope.form = response.vendors;            
        }); 
    };
  
    $scope.ActEdit = function(isValid) {
        $scope.submitted = true;        
        if(isValid){
            $scope.form._method = 'put';            
            Restangular.all('vendors/'+$scope.form.id).post($scope.form).then(function(response){
                if(response.status!==200)
                    ToastyService.error(response.message);
                else{
                    ToastyService.success(response.message);
                    $location.path('/vendors');
                }
                    
            }, function (error){                
                ToastyService.error(error.data.message);
            });
        }
    };

    $scope.getAdd = function(){
        Restangular.all('vendors').withHttpConfig({cache:true}).doGET('create').then(function(response) {
            $scope.category = response.categories;
        }); 
    };

    $scope.ActAdd = function(isValid) {        
        $scope.submitted = true;
        if(isValid){                        
            Restangular.all('vendors').post($scope.form).then(function(response){
                if(response.status!==200)
                    ToastyService.error(response.message);
                else{
                    ToastyService.success(response.message);
                    $location.path('/vendors');
                }
            }).catch(function (error){                
                ToastyService.error(error.data.message);
            }); 
        }
    };    

    $scope.getShow = function(){
        $scope.currentId = $routeParams.action; 
        Restangular.all('vendors').doGET($scope.currentId).then(function(response) {            
            $scope.vendor = response;
        });                
    };
     
})
.controller('VendorCategoryController', function($scope, Restangular,$routeParams,Upload,ToastyService,$location) {
 
    $scope.ActDelete = function(id,reload){
        alertify.confirm("Are you sure you wish to delete this recipe?", function(e) {
            if (e) {
                $scope.form ={'_method':'delete'};
                Restangular.all('vendor-categories/'+id).post($scope.form).then(function(response){
                    if(response.status!==200) 
                        ToastyService.error(response.message);
                    else{
                        ToastyService.success(response.message);
                        if(reload){ 
                            $scope.getVendorCategory(); 
                        }else{
                            $location.path('/vendor-categories');                            
                        }
                    }                        
                }, function (error){                
                    ToastyService.error(error.data.message);
                });
            } else {
                // nothing happend
            }
        });
    };

    $scope.getVendorCategory = function() {
        // This will query /accounts and return a promise.
        Restangular.all('vendor-categories').doGET().then(function(response) {
            $scope.vendor_category = response;
        });
    };

    $scope.getShow = function(){
        $scope.currentId = $routeParams.action; 
        Restangular.all('vendor-categories').doGET($scope.currentId).then(function(response) {
            $scope.category = response.category;
            $scope.vendors = response.vendors;
        });                
    };
    
    $scope.form = {};

    
    $scope.getEdit = function(){
        $scope.currentId = $routeParams.action;  //check :action in when provider        
        Restangular.all('vendor-categories').doGET($scope.currentId+'/edit').then(function(response) {
            $scope.form = response;            
        });
    };
  
    $scope.ActEdit = function(isValid) {        
        $scope.submitted = true;
        if(isValid){
            $scope.form._method = 'put';            
            Restangular.all('vendor-categories/'+$scope.form.id).post($scope.form).then(function(response){
                if(response.status!==200)
                    ToastyService.error(response.message);
                else{
                    ToastyService.success(response.message);
                    $location.path('/vendor-categories');
                }
                    
            }, function (error){                
                ToastyService.error(error.data.message);
            });
        }
    };

    $scope.ActAdd = function(isValid) {
        $scope.submitted = true;
        if(isValid){
            Restangular.all('vendor-categories').post($scope.form).then(function(response){
                if(response.status!==200)
                    ToastyService.error(response.message);
                else{
                    ToastyService.success(response.message);
                    $location.path('/vendor-categories');
                }
            }).catch(function (error){
                ToastyService.error(error.data.message);
            }); 
        }
    };
     
});
