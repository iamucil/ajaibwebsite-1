angular.module('app.controller')
.controller('TransactionController', function($scope, Restangular,$routeParams,Upload,ToastyService,$location,$compile) {
    $scope.dateOptions = {
        formatYear: 'yy',
        minDate: new Date(),
        startingDay: 2
    };

    $scope.popup_datepicker = {opened:false};
    $scope.popup_datepicker_open = function(){
        $scope.popup_datepicker.opened = true;
    };

    $scope.ActDelete = function(id){
        alertify.confirm("Are you sure you wish to delete this recipe?", function(e) {
            if (e) {
                $scope.form ={'_method':'delete'};
                Restangular.all('transactions/'+id).post($scope.form).then(function(response){
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

    $scope.getTransaction = function() {
        // This will query /accounts and return a promise.
        Restangular.all('transactions').doGET().then(function(response) {
            $scope.transaction = response;            
        });
    };    
    $scope.form = {};        
    $scope.getUser = function(callback){
        Restangular.all('user').withHttpConfig({cache:true}).doGET().then(function(response) {
            $scope.data_users = response;
            callback();
        });
    };
    
    $scope.getAdd = function(){
        $scope.getUser($scope.getAddData);
    };
    $scope.getAddData = function(){
        Restangular.all('transactions').doGET('create').then(function(response) {
            $scope.auth = response.auth;
            $scope.form = response.form;
            $scope.form.tanggal = new Date();
            $scope.satuan = response.satuan;
            $scope.category = response.category;
        }); 
    };

    $scope.ActAdd = function(isValid) {        
        $scope.submitted = true;
        if(isValid){
            $scope.form.transactions = $scope.transactions;
            Restangular.all('transactions').post($scope.form).then(function(response){
                if(response.status!==200)
                    ToastyService.error(response.message);
                else{
                    ToastyService.success(response.message);
                    $location.path('/transactions');
                }
            }).catch(function (error){                
                ToastyService.error(error.data.message);
            }); 
        }
    };

    $scope.editTypeahead = function ($item, $model, $label) {        
        $scope.form.user_id = $item.id;
        $scope.form.user_name = $item.name;        
    };    

    $scope.getShow = function(){
        $scope.currentId = $routeParams.action; 
        Restangular.all('transactions').doGET($scope.currentId).then(function(response) {            
            $scope.transaction = response.transaction;
            $scope.detail_transaction = response.detail_transaction;
        });                
    };



    /** 
     * this for calculations in create and edit
     */
    $scope.AddDetail = function(){
        $scope.addRow();
    };

    /*
    $scope.changeAmount = function(){
        var qty     = parseFloat($quantity.value.replace(',', ''));
        var amnt    = parseFloat($amount.value.replace(',',''));
        qty         = isNaN(qty) ? 1 : qty;
        amnt        = isNaN(amnt) ? 0 : amnt;
        $total.value    = qty*amnt;
    };
    */
    $scope.transactions = {
        nomor: [],
        quantity: [],
        amount: [],
        total: [],
        satuan: [],
        keterangan: []
    };
    $scope.transactions_empty = true;
    $scope.addRow = function(renew = false){
        $scope.transactions_empty = false;
        if(renew){ 
            angular.element('#transaction_PlaceHolder').children('tr.input').remove();
            angular.element('#transaction_PlaceHolder').children('tr.row-descriptions').remove();
        }
        var $PlaceHolder    = angular.element('#transaction_PlaceHolder');         
        var index = $PlaceHolder.children('tr.input').length;
        var has_class_error_quantity = 'ng-class="{\'has-error\' : form_create.transactions_'+index+'_quantity.$invalid && submitted }"';
        var has_class_error_amount = 'ng-class="{\'has-error\' : form_create.transactions_'+index+'_amount.$invalid && submitted }"';
        var has_class_error_satuan = 'ng-class="{\'has-error\' : form_create.transactions_'+index+'_satuan.$invalid && submitted }"';
        var has_class_error_keterangan = 'ng-class="{\'has-error\' : form_create.transactions_'+index+'_keterangan.$invalid && submitted }"';
        var html = '';
        $scope.transactions.nomor[index] = (index+1);
        html += '<tr id="row_'+index+'" class="input">'+
            '<td align="center" style="vertical-align:middle">'+$scope.transactions.nomor[index]+'</td>'+
            '<td '+has_class_error_quantity+'><input ng-required="true" type="decimal" class="form-control" name="transactions_'+index+'_quantity" ng-model="transactions.quantity['+index+']" size="4" ng-keyup="changeSubAmount('+index+');"></td>'+
            '<td '+has_class_error_satuan+'><select ng-required="true" class="form-control" name="transactions_'+index+'_satuan" ng-model="transactions.satuan['+index+']">';
            for(i = 0;i < $scope.satuan.length; i++ )
                html += '<option value="'+$scope.satuan[i]['id']+'">'+$scope.satuan[i]['name']+'</option>';
        html += '</select></td>';
        html += '<td '+has_class_error_amount+'><input ng-required="true" type="decimal" class="form-control" name="transactions_'+index+'_amount" ng-model="transactions.amount['+index+']" id="0" size="18" ng-keyup="changeSubAmount('+index+')"></td>'; 
        html += '<td><input ng-required="true" type="text" class="form-control" readonly="" size="20" name="transactions['+index+'][\'total\']" ng-model="transactions.total['+index+']"></td>';
        html += '<td rowspan="2"><button type="button" class="btn btn-danger" ng-click="deleteItem('+index+')" style="border-radius: 4px;"><i class="glyphicon glyphicon-trash"></i></button></td>';
        html += '</tr>';
        html += '<tr class="row-descriptions" id="descriptions_'+index+'">';
        html += '<td colspan="3" style="font-weight: bold; text-align: right;">Keterangan</td>';
        html += '<td colspan="2" '+has_class_error_keterangan+'><textarea ng-required="true" name="transactions_'+index+'_keterangan" ng-model="transactions.keterangan['+index+']" placeholder="Keterangan" class="form-control" rows="3" style="width: 100%; resize: none; height: 100%;"></textarea></td>';
        html += '</tr>';
        var result = $(html).appendTo($PlaceHolder);
        $compile(result)($scope);
        // $PlaceHolder.append();
    };
    
    $scope.changeSubAmount = function(i) {
        var obj         = angular.element('#transaction_PlaceHolder');
        var nominal     = 0;
        var total       = 0;
        var qty = (typeof $scope.transactions.quantity[i] === 'undefined') ? 0 : $scope.transactions.quantity[i];
        var amount = (typeof $scope.transactions.amount[i] === 'undefined') ? 0 : $scope.transactions.amount[i];
        if(!isNaN(parseFloat(qty)*parseFloat(amount))){
            total   = parseFloat(qty)*parseFloat(amount);
            $scope.transactions.total[i] = total;
        }
        $scope.submitAmount();
    };

    $scope.submitAmount = function() {        
        $scope.form.total = parseFloat($scope.transactions.total.reduce((a, b) => a + b, 0));
    };

    $scope.deleteItem = function(i) {        
        $scope.transactions.nomor.splice(i,1);
        $scope.transactions.quantity.splice(i,1);
        $scope.transactions.amount.splice(i,1);
        $scope.transactions.total.splice(i,1);
        $scope.transactions.satuan.splice(i,1);
        $scope.transactions.keterangan.splice(i,1);
        if($scope.transactions.nomor.length > 0){            
            for(ii=0; ii < $scope.transactions.nomor.length; ii++){
                if(ii==0)
                    $scope.addRow(true); 
                else
                    $scope.addRow();
            }
        }else{
            // array empty
            angular.element('#transaction_PlaceHolder').children('tr.input').remove();
            angular.element('#transaction_PlaceHolder').children('tr.row-descriptions').remove();
            $scope.transactions_empty = true;
        }
        $scope.form.total = parseFloat($scope.transactions.total.reduce((a, b) => a + b, 0));
    };
     
})



.controller('TransactionCategoryController', function($scope, Restangular,$routeParams,Upload,ToastyService,$location) {
 
    $scope.ActDelete = function(id,reload){
        alertify.confirm("Are you sure you wish to delete this recipe?", function(e) {
            if (e) {
                $scope.form ={'_method':'delete'};
                Restangular.all('transaction-categories/'+id).post($scope.form).then(function(response){
                    if(response.status!==200) 
                        ToastyService.error(response.message);
                    else{
                        ToastyService.success(response.message);
                        if(reload){ 
                            $scope.getTransactionCategory(); 
                        }else{
                            $location.path('/transaction-categories');                            
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

    $scope.getTransactionCategory = function() {
        // This will query /accounts and return a promise.
        Restangular.all('transaction-categories').doGET().then(function(response) {
            $scope.category = response;
        });
    };
    
    $scope.form = {};

    $scope.getShow = function(){
        $scope.currentId = $routeParams.action; 
        Restangular.all('transaction-categories').doGET($scope.currentId).then(function(response) {
            $scope.category = response.category;
            $scope.vendors = response.vendors;
        });                
    };

    $scope.getEdit = function(){
        $scope.currentId = $routeParams.action;  //check :action in when provider        
        Restangular.all('transaction-categories').doGET($scope.currentId+'/edit').then(function(response) {
            $scope.form = response;
        });
    };
  
    $scope.ActEdit = function(isValid) {        
        $scope.submitted = true;
        if(isValid){
            $scope.form._method = 'put';            
            Restangular.all('transaction-categories/'+$scope.form.id).post($scope.form).then(function(response){
                if(response.status!==200)
                    ToastyService.error(response.message);
                else{
                    ToastyService.success(response.message);
                    $location.path('/transaction-categories');
                }
            }, function (error){                
                ToastyService.error(error.data.message);
            });
        }
    };

    $scope.ActAdd = function(isValid) {
        $scope.submitted = true;
        if(isValid){
            Restangular.all('transaction-categories').post($scope.form).then(function(response){
                if(response.status!==200)
                    ToastyService.error(response.message);
                else{
                    ToastyService.success(response.message);
                    $location.path('/transaction-categories');
                }
            }).catch(function (error){
                ToastyService.error(error.data.message);
            }); 
        }
    };
     
});
