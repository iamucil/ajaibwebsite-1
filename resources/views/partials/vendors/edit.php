<div class="box bg-white" ng-controller="VendorController" ng-init="getEdit()">
    <div class="box-header bg-transparent">
        <h3 class="box-title"><i class="icon-menu"></i><span>Vendors - Edit</span></h3>
        <div class="pull-right box-tools">
            <span class="box-btn" data-widget="collapse"><i class="icon-minus"></i></span>
        </div>            
    </div>
    <div class="box-body pad-forty" style="display: block;">
        <form class="form-horizontal" novalidate ng-submit="ActEdit(form_edit.$valid)" method="post" name="form_edit">
            <input type="hidden" name="id" ng-value="currentId" ng-model="form.id">
            <div class="form-group" ng-class="{'has-error' : form_edit.category_id.$invalid && submitted }">
                <label for="select-category" class="col-sm-2 control-label">
                    Select a Category
                </label>
                <div class="col-sm-6">
                    <select ng-model="form.category_id" name="category_id" class="form-control" id="select-category" ng-required="true" ng-options="key as value for (key,value) in category" >
                        <option value="">Pick a category...</option>
                    </select>
                </div>
                <p ng-show="form_edit.category_id.$invalid && submitted" class="help-block">Category is required.</p>
            </div>
            <div class="form-group" ng-class="{'has-error' : form_edit.name.$invalid && submitted }">
                <label for="inputName" class="col-sm-2 control-label">Nama</label>

                <div class="col-sm-6">
                    <input type="text" class="form-control" id="inputName" ng-required="true" name="name" ng-model="form.name">
                </div>
                <p ng-show="form_edit.name.$invalid && submitted" class="help-block">Name is required.</p>
            </div>
            <div class="form-group">
                <label for="inputDeskripsi" class="col-sm-2 control-label">Deskripsi</label>

                <div class="col-sm-6">
                    <input type="text" class="form-control" id="inputDeskripsi" ng-model="form.description">
                </div>                    
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit" ><i class="glyphicon glyphicon-floppy-disk"></i> Simpan</button>
            <a class="btn btn-default" type="button" ng-href="/vendors"><i class="glyphicon glyphicon-floppy-remove"></i>  Batal</a>
            </div>
        </form>        
    </div>
</div>