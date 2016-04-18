    <div class="box bg-white" ng-controller="VendorController" ng-init="getVendor()">

        <div class="box-header bg-transparent">
            <h3 class="box-title"><i class="fontello-th-large-outline"></i><span>Vendors</span></h3>
            <div class="pull-right box-tools">
                <span class="box-btn" data-widget="collapse"><i class="icon-minus"></i></span>
            </div>
            <!-- tools box -->
            <div class="pull-right box-tools">
                <div class="btn-group" role="group" aria-label="...">
                    <a ng-href="/vendors/create" class="btn btn-default" role="button">
                        Tambah Vendor
                    </a>
                    <a ng-href="/vendor-categories" class="btn btn-default" role="button">
                        Daftar Kategori
                    </a>
                    <!-- <button type="button" class="btn btn-default">Tambah Kategory</button>
                    <button type="button" class="btn btn-default">Daftar Vendor</button> 
                    <button type="button" class="btn btn-default">Right</button>  -->
                </div>
            </div>            
        </div>
        <div class="box-body">
            <table class="table table-striped" datatable="ng">
                <thead>
                <tr>
                    <th style="width: 30px;">#</th>
                    <th style="width: 115px;">Nama</th>
                    <th style="width: 95px;">Kategori</th>
                    <th>Deskripsi</th>
                    <th style="width: 135px;"></th>
                </tr>
                </thead>
                <tbody>
                
                    <tr ng-repeat="vendor in vendors">
                        <td>[[$index+1]]</td>
                        <td>[[vendor.name]] </td>
                        <td>
                            <a class="btn btn-large" ng-href="/vendor-categories/[[vendor.category_id]]/show"><label class="label label-info">[[vendor.category_name]]</label></a>
                        </td>
                        <td>[[vendor.description]]</td>
                        <td>
                            <a ng-href="/vendors/[[vendor.id]]/edit" class="btn btn-default">
                                <i class="glyphicon glyphicon-pencil"></i>
                            </a>                            
                            <a ng-href="/vendors/[[vendor.id]]/show" class="btn btn-default">
                                <i class="glyphicon glyphicon-list-alt"></i>
                            </a>

                            <button class="btn btn-danger" id="btn-delete" type="button" ng-click="ActDelete(vendor.id)">
                                <i class="glyphicon glyphicon-trash"></i>
                            </button>
                            
                        </td>
                    </tr>                    
                </tbody>
            </table>
        </div>
    </div>
    <!-- 
    <script type="text/javascript">
        $('button#btn-delete').bind('click', function (event) {
            var $form = this.form;
            event.preventDefault();
            // return confirm(
            //     'Are you sure you wish to delete this recipe?'
            // );
            return alertify.confirm("Are you sure you wish to delete this recipe?", function (e) {
                if (e) {
                    $form.submit();
                } else {
                    // nothing happend
                }
            });
        })
    </script>
 -->