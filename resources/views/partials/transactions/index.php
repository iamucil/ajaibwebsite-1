<div class="box" ng-controller="TransactionController" ng-init="getTransaction()">
    <div class="box-header bg-transparent">
        <!-- tools box -->
        <div class="pull-right box-tools">
            <div class="btn-group" role="group" aria-label="...">
                <a href="/transactions/create" class="btn btn-default" role="button">
                    Tambah Transaksi
                </a>
                <a class="btn btn-default" role="button" href="/transaction-categories">
                    Daftar Kategori
                </a>
            </div>
        </div>
        <h3 class="box-title">
            <i class="fontello-th-large-outline"></i>
            <span>Daftar Transaksi</span>
        </h3>
    </div>
    <div class="box-body " style="display: block;">
        <table class="table" datatable="ng">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Nomor Transaksi</th>
                    <th>Kategori</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>                    
                <tr ng-repeat="t in transaction">
                    <td align="center">[[$index+1]]</td>
                    <td>[[t.tanggal | date:"dd MMMM, yyyy"]]</td>
                    <td>[[t.invoice_number]]</td>
                    <td>[[t.category_name]]</td>
                    <td style="width: 195px;">
                        <a ng-href="/transactions/[[t.id]]/show" title="Details" class="btn btn-default">
                            <i class="glyphicon glyphicon-list-alt"></i>
                        </a>
                        <a ng-href="/dashboard/transactions/invoice/[[t.enc_id]]/pdf" class="btn btn-default" title="invoice PDF" target="_blank">
                            <i class="glyphicon glyphicon-credit-card" alt="invoice"></i>
                        </a>
                        <a ng-href="/dashboard/transactions/invoice/[[t.enc_id]]" class="btn btn-default" target="_blank" title="invoice html">
                            <i class="glyphicon glyphicon-duplicate"></i>
                        </a>
                        <a ng-href="/dashboard/transactions/invoice/[[t.enc_id]]/image" class="btn btn-default" target="_blank" title="invoice image">
                            <i class="glyphicon glyphicon-save-file"></i>
                        </a>
                    </td>
                </tr>                       
            </tbody>
        </table>            
    </div>
</div>