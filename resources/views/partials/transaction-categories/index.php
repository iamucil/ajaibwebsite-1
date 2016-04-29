<div class="box" ng-controller="TransactionCategoryController" ng-init="getTransactionCategory()">
    <div class="box-header bg-transparent">
        <!-- tools box -->
        <div class="pull-right box-tools">
            <div class="btn-group" role="group" aria-label="...">
                <a href="/transaction-categories/create" class="btn btn-default" role="button">
                    Tambah Kategori
                </a>
                <a class="btn btn-default" role="button" href="/transactions">Daftar Transaksi</a>
            </div>
        </div>
        <h3 class="box-title">
            <i class="fontello-th-large-outline"></i>
            <span>Kategori Transaksi</span>
        </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body " style="display: block;">
        <table class="table" datatable="ng">
            <thead>
                <th style="width: 20px;">#</th>
                <th style="width: ">Nama</th>
                <th>Deskripsi</th>
                <th style="width: 30px;">Transaksi</th>
                <th style="width: 90px;">Aksi</th>
            </thead>
            <tbody>                
                <tr ng-repeat="c in category">
                    <td>[[$index+1]]</td>
                    <td>[[c.name]]</td>
                    <td>[[c.description != '' ? c.description : '&mdash;']]</td>
                    <td>
                        <a class="btn btn-success" href="">Transactions
                            <span class="badge">[[c.transaction_count]]</span>
                        </a>
                    </td>
                    <td>
                        <a ng-href="/transaction-categories/[[c.id]]/edit" class="btn btn-default">
                            <i class="glyphicon glyphicon-pencil"></i>
                        </a>
                        <button  ng-disabled="c.transaction_count > '0'" class="btn btn-danger" id="btn-delete" type="button" ng-click="ActDelete(c.id,true)" >
                            <i class="glyphicon glyphicon-trash"></i>
                        </button>                            
                    </td>
                </tr>                    
            </tbody>
        </table>
        
    </div>
</div>