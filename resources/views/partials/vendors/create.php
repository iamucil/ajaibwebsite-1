    <div class="box bg-white" ng-controller="VendorController" ng-init="getAdd()">
        <div class="box-header bg-transparent">
            <h3 class="box-title"><i class="icon-menu"></i><span>Vendors - Tambah</span></h3>
            <div class="pull-right box-tools">
                <span class="box-btn" data-widget="collapse"><i class="icon-minus"></i></span>
            </div>            
        </div>
        <div class="box-body pad-forty" style="display: block;">
            <form class="form-horizontal" novalidate="true" method="post" ng-submit="ActAdd(form_create.$valid)" name="form_create">
                <div class="form-group" ng-class="{'has-error' : form_create.category_id.$invalid && submitted }">
                    <label for="select-category" class="col-sm-2 control-label">
                        Select a Category
                    </label>
                    <div class="col-sm-6">
                        <select ng-model="form.category_id" name="category_id" class="form-control" id="select-category" ng-required="true" placeholder="Pick a category...">
                            <option value="">Pick a category...</option>
                            <option ng-repeat="(key, value) in category" ng-value="key">[[value | ucfirst]]</option>
                        </select>
                    </div>
                    <p ng-show="form_create.category_id.$invalid && submitted" class="help-block">Category is required.</p>
                </div>
                <div class="form-group" ng-class="{'has-error' : form_create.name.$invalid && submitted }">
                    <label for="inputName" class="col-sm-2 control-label">Nama</label>

                    <div class="col-sm-6">
                        <input type="text" ng-model="form.name" class="form-control" ng-required="true" id="inputName" name="name">
                    </div>
                    <p ng-show="form_create.name.$invalid && submitted" class="help-block">Name is required.</p>
                </div>
                <div class="form-group" >
                    <label for="inputDeskripsi" class="col-sm-2 control-label">Deskripsi</label>

                    <div class="col-sm-6">
                        <input type="text" ng-model="form.description" class="form-control" id="inputDeskripsi" name="description" >
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit" ><i class="glyphicon glyphicon-floppy-disk"></i> Simpan</button>
                <a class="btn btn-default" type="button" ng-href="/vendors"><i class="glyphicon glyphicon-floppy-remove"></i>  Batal</a>
                </div>
            </form>
        </div>
    </div>
