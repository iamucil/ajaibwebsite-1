@extends('layouts.dashboard')

@section('title')
    Transaction - ADD
@stop

@section('script')
    @parent
@stop
@section('content')
<div class="box bg-white">
    <div class="box-body pad-forty" style="display: block;">
        <form class="form-horizontal" method="post" action="{{ route('transactions.store') }}" enc-type="multipart/form-data" name="add-transaction" id="frm-transaction">
            {{ csrf_field() }}
            <div class="form-group">
                <label class="col-sm-2 control-label">Operator</label>
                <div class="col-sm-10">
                    <p class="form-control-static">
                        <strong>{!! auth()->user()->name !!}</strong>
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
            <div class="form-group">
                <label class="col-sm-2 control-label">Acoount Payable</label>
                <div class="col-sm-4">
                    <input class="form-control" type="text" />
                </div>
            </div>
            <div class="form-group">
                <label for="tanggal" class="col-sm-2 control-label">Tanggal</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="txt-date" placeholder="DD/MM/YYYY" name="tanggal" />
                </div>
            </div>
            <div class="form-group">
                <label for="select-category" class="col-sm-2 control-label">Kategory</label>
                <div class="col-sm-10">
                    {!! Form::select('category_id', $categories, old('category_id'), ['placeholder' => 'Pick a category...', 'class' => 'form-control', 'id' => 'select-category']) !!}
                </div>
            </div>
            <div class="form-group">
                <label for="txt-quantity" class="col-sm-2 control-label">Quantity</label>
                <div class="col-sm-2">
                    <input type="text" name="quantity" class="form-control" id="txt-quantity" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="txt-amount">Amount</label>
                <div class="col-sm-4">
                    <input type="text" name="amount" class="form-control" id="txt-amount" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="sub-total">Total</label>
                <div class="col-sm-10">
                    <input type="text" name="total" id="sub-total" readonly />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="txt-keterangan">Keterangan</label>
                <div class="col-sm-10">
                    <textarea name="keterangan" rows="4" style="height: auto !important;">{{ old('keterangan') }}</textarea>
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
                                <button type="button" class="btn btn-success" id="btn-add-details"> <i class="glyphicon glyphicon-plus"></i> Tambah Detail</button>
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
                        <tr id="empty-row">
                            <td>
                                Data Kosong
                            </td>
                        </tr>
                    </tbody>
                </table>
            </fieldset>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" class="btn btn-default" value="Simpan" />
                    <a class="btn btn-default">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('script-bottom')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js" type="text/javascript"></script>
    <script language="javascript">
        $(function() {
            var btn         = document.getElementById('btn-add-details');
            var $form       = document.forms['frm-transaction'];
            var $quantity   = $form.quantity;
            var $amount     = $form.amount;
            var $total      = $form.total;
            var $PlaceHolder    = document.getElementById('transaction_PlaceHolder');
            $('#txt-quantity').maskMoney();
            $('#txt-amount').maskMoney();

            var changeAmount    = function () {
                var qty     = parseFloat($quantity.value.replace(',', ''));
                var amnt    = parseFloat($amount.value.replace(',',''));

                qty         = isNaN(qty) ? 1 : qty;
                amnt        = isNaN(amnt) ? 0 : amnt;
                $total.value    = qty*amnt;
                $('#sub-total').maskMoney();
            }
            $quantity.onkeyup   = changeAmount;
            $amount.onkeyup     = changeAmount;

            $PlaceHolder.addRows    = function () {
                var childObj        = this.getElementsByTagName('tr');
                for (var i = 0; i < childObj.length; i++) {
                    if(childObj[i].id == 'empty-row' || childObj[i].id == 'row-total') {
                        this.removeChild(childObj[i]);
                    }
                }
                var row             = document.createElement('tr');
                var colNumber       = document.createElement('td');
                colNumber.innerHTML     = '#';
                var colQuantity     = document.createElement('td');
                var inpQuantity     = document.createElement('input');
                inpQuantity.type    = 'text';
                inpQuantity.name    = 'transactions[][quantity]';
                colQuantity.appendChild(inpQuantity);
                var colSatuan       = document.createElement('td');
                var cmbSatuan       = document.createElement('select');
                colSatuan.appendChild(cmbSatuan);
                var colAmount       = document.createElement('td');
                var inpAmount       = document.createElement('input');
                inpAmount.type      = 'text';
                colAmount.appendChild(inpAmount);
                var colCount        = document.createElement('td');
                var inpCount        = document.createElement('input');
                inpCount.type       = 'text';
                colCount.appendChild(inpCount);
                var colAction       = document.createElement('td');

                row.appendChild(colNumber);
                row.appendChild(colQuantity);
                row.appendChild(colSatuan);
                row.appendChild(colAmount);
                row.appendChild(colCount);
                row.appendChild(colAction);

                this.appendChild(row);

                var rowTotal        = document.createElement('tr');
                rowTotal.id         = 'row-total';
                var tdSummaryLabel  = document.createElement('td');
                tdSummaryLabel.classList.add('text-right');
                tdSummaryLabel.style.fontWeight     = 'bold';
                tdSummaryLabel.setAttribute('colspan', 4);
                tdSummaryLabel.innerHTML    = 'Total';
                var tdSummary       = document.createElement('td');
                var tdSummaryEmpty  = document.createElement('td');
                rowTotal.appendChild(tdSummaryLabel);
                rowTotal.appendChild(tdSummary);
                rowTotal.appendChild(tdSummaryEmpty);

                this.appendChild(rowTotal);
            }
            btn.onclick         = function (e) {
                $PlaceHolder.addRows();
                e.preventDefault();
                return false;
            }
        });
    </script>
@stop