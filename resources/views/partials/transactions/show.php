<div class="box bg-white" ng-controller="TransactionController" ng-init="getShow()">
    <div class="box-header bg-transparent">
        <h3 class="box-title">
            <i class="fontello-th-large-outline"></i>
            <span>Detail Transaksi</span>
        </h3>
    </div>
    <div class="box-body pad-forty" style="display: block;">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th colspan="2"><h4>Data Transaksi</h4>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th style="width: 195px;">Invoice Number</th>
                    <td>[[transaction.invoice_number]]</td>
                </tr>
                <tr>
                    <th>Invoice For</th>
                    <td>[[transaction.category_name]]  &mdash; [[transaction.keterangan]] 
                    </td>
                </tr>
                <tr>
                    <th>Payable to</th>
                    <td>[[transaction.phone_number]] [[transaction.email]]</td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td>[[transaction.tanggal | date:"dd MMMM yyyy"]]</td>
                </tr>
                <tr>
                    <th colspan="2"><h5>Details</h5></th>
                </tr>
                <tr>
                    <td colspan="2" style="padding: 0px;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Quantity (x)</th>
                                    <th>Harga (Rp)</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                <tr ng-repeat="dt in detail_transaction">
                                    <td>[[dt.keterangan]]</td>
                                    <td align="right">[[dt.quantity]]</td>
                                    <td align="right">[[dt.amount | number:2]]</td>
                                    <td align="right">[[dt.quantity * dt.amount | number:2]]</td>
                                </tr>                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" align="right"><h4 style="text-align: right;">[[transaction.amount | number:2]]</h4>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <p>
            <a class="btn btn-link" ng-href="/transactions" role="button">Kembali</a>
        </p>
    </div>
</div>
