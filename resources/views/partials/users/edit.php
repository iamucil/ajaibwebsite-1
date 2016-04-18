<!-- <script type="text/javascript" src="/js/vendor/bootstrap3-typeahead.min.js"></script> -->
<div class="box" ng-controller="UserController" ng-init="getEdit()">
    <div class="box-header bg-transparent">
        <h3 class="box-title">
                <i class="icon-menu"></i>
                <span>Update Profile User</span>
            </h3>
    </div>
    <div class="box-body">
        <form class="form-horizontal" ng-submit="ActEdit(form_create_user.$valid)" name="form_create_user" id="form_create_user" novalidate>
            <input type="text" class="hide" name="id" ng-model="form.id" ng-value="form.id">
            <input type="text" class="hide" name="_method" value="PUT" ng-model="form._method">            
            <div class="form-group" ng-class="{'has-error' : form_create_user.firstname.$invalid && submitted }">
                <label for="firstname" class="col-sm-2 control-label">Real Name</label>
                <div class="col-sm-2">
                    <input type="text" ng-model="form.firstname" class="form-control" id="firstname" name="firstname" ng-required="true">
                </div>
                <div class="col-sm-2">
                    <input type="text" ng-model="form.lastname" class="form-control" id="lastname" name="lastname">
                </div>
                <p ng-show="form_create_user.firstname.$invalid && submitted" class="help-block">Firstname is required.</p>

            </div>
            <div class="form-group" ng-class="{'has-error' : form_create_user.email.$invalid && submitted }">
                <label for="input-email" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-4">
                    <input type="email" ng-model="form.email" class="form-control" id="input-email" placeholder="Email" name="email" readonly>
                    <p ng-show="form_create_user.email.$invalid && submitted" class="help-block">Email is required.</p>
                </div>

            </div>
            <div class="form-group">
                <label for="country" class="col-sm-2 control-label">Kota</label>                
                <div class="col-sm-4">
                    <input type="text" class="ng-hide" name="country_id" ng-model="form.country_id">
                    <input type="text" class="ng-hide" name="country_name" ng-model="form.country_name">
                    <input                          
                        type="text"  
                        class="typehead" 
                        id="country"                         
                        ng-model="form.country_name"
                        uib-typeahead="country as country.name for country in data_country | filter:$viewValue | limitTo:5"
                        typeahead-editable="false"
                        typeahead-on-select="editTypeahead($item, $model, $label)"
                        autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <label for="input-address" class="col-sm-2 control-label">Alamat</label>
                <div class="col-sm-4">
                    <textarea class="form-control" ng-model="form.address" id="input-address" name="address" rows="4">
                        [[user.address | trim]]
                    </textarea>
                </div>
            </div>
            <div class="form-group" ng-class="{'has-error' : form_create_user.phone_number.$invalid && submitted }">
                <label for="input_phone_number" class="col-sm-2 control-label">Nomor Telepon</label>
                <div class="col-sm-4">
                    <input 
                        type="text" 
                        ng-model="form.phone_number" 
                        class="form-control" 
                        id="input_phone_number" 
                        name="phone_number"                         
                        international-phone-number 
                        default-country="id"
                        preferred-countries="id,us,gb"
                        readonly>
                    <span id="helpBlock" class="help-block">ex: 85600000000.</span>
                    <p ng-show="form_create_user.phone_number.$invalid && submitted " class="help-block">Phone Number is required.</p>
                </div>
            </div>
            <div class="form-group">
                <label for="input-gender" class="col-sm-2 control-label">Jenis Kelamin</label>
                <div class="col-sm-4">
                    <div class="radio">
                        <label>
                            <input type="radio" name="gender" ng-model="gender" value="male" ng-checked="male"> Laki-laki
                        </label>
                        <label>
                            <input type="radio" name="gender" ng-model="gender" value="female" ng-checked="female"> Perempuan
                        </label>
                    </div>
                </div>
            </div>            
            <div class="form-group">
                <button class="btn btn-primary" type="submit" >Simpan</button>
                <a class="btn btn-default" type="button" ng-href="/users/profile/[[currentId]]">Batal</a>
            </div>            
        </form>
    </div>
</div>
