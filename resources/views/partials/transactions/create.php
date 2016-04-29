<!-- <script type="text/javascript" src="{{ secure_asset('/js/vendor/bootstrap3-typeahead.min.js') }}"></script> -->
<script type="text/javascript" src="/js/jqMaskMoney.js"></script>
<div class="box bg-white" ng-controller="TransactionController" ng-init="getAdd()">
    <div class="box-header bg-transparent">    
        <h3 class="box-title">
            <i class="fontello-th-large-outline"></i>
            <span>Tambah Transaksi</span>
        </h3>
    </div>
    <div class="box-body pad-forty" style="display: block;">
        <form class="form-horizontal" method="post" novalidate ng-submit="ActAdd(form_create.$valid)"  name="form_create" id="form_create">            
            <div class="form-group">
                <label class="col-sm-2 control-label">Operator</label>
                <div class="col-sm-10">
                    <p class="form-control-static">
                        <strong>[[form.auth_user_name | ucfirst]]</strong>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Invoice Number</label>
                <div class="col-sm-10">
                    <p class="form-control-static">
                        <strong>Auto Number</strong>
                    </p>
                </div>
            </div>
            <div class="form-group" ng-class="{'has-error' : form_create.ap.$invalid && submitted }">
                <label class="col-sm-2 control-label">Account Payable</label>
                <div class="col-sm-4">
                    <input type="hidden" name="user_id" ng-model="form.user_id" />
                    <input type="hidden" name="user_name" ng-model="form.user_name" />
                    <input 
                        class="form-control" 
                        type="text" 
                        class="typeahead" 
                        id="acount-payable" 
                        autocomplete="off" 
                        placeholder="eg: 85640427774" 
                        ng-model="form.ap" 
                        name="ap" 
                        uib-typeahead="user as user.name for user in data_users | filter:$viewValue | limitTo:5"
                        typeahead-editable="false"
                        typeahead-on-select="editTypeahead($item, $model, $label)"
                        autocomplete="off"
                        ng-required="true"/>
                </div>
                <p ng-show="form_create.ap.$invalid && submitted" class="help-block">Account Payable is required.</p>
            </div>
            <div class="form-group" ng-class="{'has-error' : form_create.tanggal.$invalid && submitted }">
                <label for="tanggal" class="col-sm-2 control-label">Tanggal</label>
                <div class="col-sm-4">
                    <div class="input-group">
                    <input type="text" class="form-control datepicker" uib-datepicker-popup="MM/dd/yyyy" id="txt-date" placeholder="MM/DD/YYYY" name="tanggal" is-open="popup_datepicker.opened" datepicker-options="dateOptions" ng-model="form.tanggal" autocomplete="off" />
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default" ng-click="popup_datepicker_open()"><i class="glyphicon glyphicon-calendar"></i></button>
                        </span>
                    </div>
                </div>
                <p ng-show="form_create.tanggal.$invalid && submitted" class="help-block">Tanggal is required.</p>
            </div>
            <div class="form-group" ng-class="{'has-error' : form_create.category_id.$invalid && submitted }">
                <label for="select-category" class="col-sm-2 control-label">Kategory</label>
                <div class="col-sm-4">                    
                    <select ng-model="form.category_id" name="category_id" class="form-control" id="select-category" ng-required="true" ng-options="key as value for (key,value) in category" >
                        <option value="">Pick a category...</option>
                    </select>
                </div>
                <p ng-show="form_create.category_id.$invalid && submitted" class="help-block">Category is required.</p>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="sub-total">Amount</label>
                <div class="col-sm-5">
                    <input type="text" name="total" id="sub-total" readonly ng-model="form.total" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="txt-keterangan">Keterangan</label>
                <div class="col-sm-10">
                    <textarea name="keterangan" rows="4" style="height: auto !important;" ng-model="form.keterangan"></textarea>
                </div>
            </div>
            <fieldset>
                <lagend>
                    <div class="row">
                        <div class="col-sm-2">
                            Detail Transaction
                        </div>
                        <div class="col-sm-10">
                            <p class="text-right">
                                <button type="button" class="btn btn-success" ng-click="AddDetail()" id="btn-add-details"> <i class="glyphicon glyphicon-plus"></i> Tambah Detail</button>
                            </p>
                        </div>
                    </div>
                </lagend>
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th colspan="2">Quantity</th>
                            <th>Amount</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="transaction_PlaceHolder">
                        <tr id="empty-row" ng-show="transactions_empty">
                            <td colspan="5" align="center" style="font-style: italic;">
                                Data Kosong
                            </td>
                        </tr>
                    </tbody>
                </table>
            </fieldset>
            <hr />
            <div class="form-group">
                <button class="btn btn-primary" type="submit" ><i class="glyphicon glyphicon-floppy-disk"></i> Simpan</button>
                <a class="btn btn-default" type="button" ng-href="/transactions"><i class="glyphicon glyphicon-floppy-remove"></i>  Batal</a>
            </div>
        </form>
    </div>
</div>