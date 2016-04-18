angular.module('app.controller').controller('UserController', function($scope, Restangular,$routeParams,Upload,ToastyService,$location) {

    $scope.setActive = function(id){
        $scope.form = {'_method':'put'}; 
        Restangular.all('users/'+id+'/setactive').post($scope.form).then(function(response){
            if(response.status!==200) 
                ToastyService.error(response.message);
            else{
                ToastyService.success(response.message);
                $scope.getUser();
            }
                
        }, function (error){                
            ToastyService.error(error.data.message);
        });
    };
 
    $scope.deleteUser = function(id){
        alertify.confirm("Are you sure you wish to delete this recipe?", function(e) {
            if (e) {
                $scope.form ={'_method':'delete'};
                Restangular.all('users/'+id).post($scope.form).then(function(response){
                    if(response.status!==200) 
                        ToastyService.error(response.message);
                    else{
                        ToastyService.success(response.message);
                        $scope.getUser();
                    }
                        
                }, function (error){                
                    ToastyService.error(error.data.message);
                });
            } else {
                // nothing happend
            }
        });
    };

    $scope.getUser = function() {
        // This will query /accounts and return a promise.
        Restangular.all('users').doGET().then(function(response) {
            $scope.user_list = response.users;
            $scope.has_role = response.has_role;
        });
    };

    $scope.getProfile = function(){
        $scope.currentId = $routeParams.id;
        Restangular.all('profile').doGET($scope.currentId).then(function(response) {            
            response.created_at = new Date(response.created_at.replace(/-/g,"/"));
            $scope.profile = response;            
        });                
    };

    $scope.data_country = [];    
    $scope.form = {};

    $scope.getCountry = function(callback){
        Restangular.all('country').withHttpConfig({ cache: true }).doGET().then(function(response){
            $scope.data_country = response;
            // asynchronous
            callback(true);
        });
    }
    $scope.getEdit = function(){
        $scope.getCountry($scope.getDataEdit);
    };

    $scope.getDataEdit = function(status){
        $scope.currentId = $routeParams.action;  //check :action in when provider
        $scope.gender = '';

        Restangular.all('users').doGET($scope.currentId+'/edit').then(function(response) {
            $scope.form = response;
            $scope.form.gender_male = 'false';
            $scope.form.gender_female = 'false';
            $scope.gender = $scope.form.gender;
            if($scope.form.gender === 'female'){
                $scope.female = 'true';
            }else if($scope.form.gender === 'male'){
                $scope.male = 'true';
            }
            angular.forEach($scope.data_country, function(data, key) {
                if(data.id == response.country_id){
                    $scope.form.country_id = data.id;
                    $scope.form.country_name = data.name;                    
                }
            });
        });
    }
  
    $scope.ActEdit = function(isValid) {        
        $scope.submitted = true;
        if(isValid){
            $scope.form._method = 'put';
            $scope.form.gender = $scope.gender;
            Restangular.all('users/'+$scope.form.id).post($scope.form).then(function(response){                
                if(response.status!==200)
                    ToastyService.error(response.message);
                else{
                    ToastyService.success(response.message);
                    $location.path('/users/profile/'+$scope.form.id);
                }
                    
            }, function (error){                
                ToastyService.error(error.data.message);
            });
        }
    };

    $scope.getAdd = function(){
        $scope.getCountry($scope.getDataAdd);
    };

    $scope.getDataAdd = function(status){
        $scope.gender = '';
        Restangular.all('users').withHttpConfig({cache:true}).doGET('create').then(function(response) {
            $scope.roles = response.roles;
        }); 
    };

    $scope.ActAdd = function(isValid) {        
        $scope.submitted = true;
        if(isValid){            
            $scope.form.gender = $scope.gender;
            $scope.form.ext_phone = angular.element('li.country.active').attr('data-country-code');
            Restangular.all('users/store').post($scope.form).then(function(response){                
                console.log(response);
                if(response.status!==200)
                    ToastyService.error(response.message);
                else{
                    ToastyService.success(response.message);
                    $location.path('/users');
                }
                    
            }).catch(function (error){                
                ToastyService.error(error.data.message);
            }); 
        }
    };

    $scope.editTypeahead = function ($item, $model, $label) {        
        $scope.form.country_id = $item.id;
        $scope.form.country_name = $item.name;        
    };

    // upload later on form submit or something similar
    $scope.profileSubmit = function() {
        $('#user_id').trigger('input'); //trigger this           
        if ($scope.profileForm.file.$valid && $scope.profileForm) {
            $scope.uploadProfile($scope.picFile);
        }
    }; 

    $scope.uploadProfile = function(file) {
        Upload.upload({
            url: '/ajaib/profile/upload/photo',
            data: { image_file: file, 'user_id': $routeParams.id }
        }).then(
            function(resp) { /*success*/

                $('.close').trigger('click');
                ToastyService.success('Your photo has been updated.');
                /*update photo*/
                $('#image_preview').attr('src', resp.data.path + '?' + Math.random())
                $('#photo-profile').attr('src', resp.data.path + '?' + Math.random())
                $scope.picFile = null;
            },
            function(resp) { /*error*/
                ToastyService.error('Your photo cannot updated.' + resp.status);
            },
            function(evt) {
                file.progress = parseInt(100.0 * evt.loaded / evt.total);
            }
        );
    };
     
});
