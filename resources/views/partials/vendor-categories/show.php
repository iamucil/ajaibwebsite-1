<div class="box bg-white" ng-controller="VendorCategoryController" ng-init="getShow()">
    <div class="box-header bg-transparent">            
        <h3 class="box-title">
            <i class="fontello-th-large-outline"></i>
            <span>Vendor Category - Details</span>
        </h3>
    </div>
    <div class="box-body pad-forty" style="display: block;">
        <div class="row">
            <div class="col-md-3">
                <dl>
                    <dt>[[category.name]]</dt>
                    <dd>[[category.description != null ? category.description : '&mdash;']]</dd>
                </dl>
                
                <div class="btn-group-vertical" role="group" aria-label="...">
                    <a class="btn btn-default btn-block" href="/vendor-categories">
                        Daftar Kategori
                    </a>
                    <a class="btn btn-default btn-block" href="/vendor-categories/create">
                        Tambah Kategori
                    </a>
                    <a class="btn btn-default btn-block" href="/vendors">Daftar Vendor</a>
                    <a class="btn btn-default btn-block" href="/vendors/create">Tambah Vendor</a>
                    <button ng-show="vendors.length == '0'" class="btn btn-danger" id="btn-delete" type="button" ng-click="ActDelete(category.id)">
                        Hapus Kategori <span class="badge"><i class="glyphicon glyphicon-trash"></i></span>
                    </button>                        
                </div>                
            </div>
            <div class="col-md-9">
                <table class="table table-condensed" datatable="ng">
                    <thead>
                    <tr>
                        <th style="width: 30px;">#</th>
                        <th style="width: 115px;">Nama</th>
                        <th>Deskripsi</th>
                    </tr>
                    </thead>
                    <tbody>                                                
                        <tr ng-repeat="vendor in vendors">
                            <td>[[$index+1]]</td>
                            <td>[[vendor.name]]</td>
                            <td>[[vendor.description]]</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>