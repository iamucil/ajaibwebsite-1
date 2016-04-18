    <div class="box bg-white" ng-controller="VendorCategoryController" ng-init="getVendorCategory()" >
        <div class="box-header bg-transparent">
            <!-- tools box -->
            <div class="pull-right box-tools">
                <div class="btn-group" role="group" aria-label="...">
                    <a ng-href="/vendor-categories/create" class="btn btn-default" role="button">Tambah Kategori
                    </a>
                    <a class="btn btn-default" role="button" ng-href="/vendors">Daftar Vendor</a>
                    <!-- <button type="button" class="btn btn-default">Tambah Kategory</button>
                    <button type="button" class="btn btn-default">Daftar Vendor</button> 
                    <button type="button" class="btn btn-default">Right</button>  -->
                </div>
            </div>
            <h3 class="box-title">
                <i class="fontello-th-large-outline"></i>
                <span>Vendor Category</span>
            </h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body " style="display: block;">
            <table class="table" datatable="ng">
                <thead>
                    <th style="width: 20px;">#</th>
                    <th style="width: ">Nama</th>
                    <th>Deskripsi</th>
                    <th style="width: 30px;">Vendors</th>
                    <th style="width: 90px;">Aksi</th>
                </thead>
                <tbody>                
                    <tr ng-repeat="vc in vendor_category">
                        <td>[[$index+1]]</td>
                        <td>[[vc.name]] </td>
                        <td>[[vc.description != null ? vc.description : '&mdash;']]</td>
                        <td>
                            <a class="btn btn-success"
                               ng-href="[[vc.vendors > '0' ?  '/vendor-categories/vc.id/show' : 'javascript:void()']]">Vendors <span class="badge">[[vc.vendors]]</span>
                            </a>
                        </td>
                        <td>
                            <a ng-href="/vendor-categories/[[vc.id]]/edit" class="btn btn-default">
                                <i class="glyphicon glyphicon-pencil"></i>
                            </a>                                                    
                            <a ng-disabled="vc.vendors > '0'" class="btn btn-danger" id="btn-delete" role="button" ng-click="ActDelete(vc.id,true)" method="DELETE">
                                <i class="glyphicon glyphicon-trash"></i>
                            </a>
                        </td>
                    </tr>                    
                </tbody>
            </table>            
        </div>
    </div>


<script type="text/javascript">
    /*
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
    */
</script>
