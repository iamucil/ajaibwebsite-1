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
                    <input type="text" name="amount" class="form-control jqAmount" id="txt-amount" />
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
    <script type="text/javascript" src="{{ asset('/js/jqMaskMoney.js') }}"></script>
    <script type="text/javascript">
        function changeSubAmount (el, obj_id) {
            var obj         = document.getElementById(obj_id);
            var nominal     = 0;
            var total       = 0;
            var child_obj   = obj.getElementsByTagName('input');
            var child       = [];

            if(match = el.name.match(/(\w+)\[(\d+)\]\[(\w+)\]/)){
                var id      = match[2];
                var elem    = match[1];
                var qty     = document.getElementsByName(elem+'['+id+'][quantity]')[0].value;
                var amount  = document.getElementsByName(elem+'['+id+'][amount]')[0].value;
                if(!isNaN(parseFloat(qty)*parseFloat(amount))){
                    total   = parseFloat(qty)*parseFloat(amount);
                }
            }
            // console.log(child_obj);
            for (var i = child_obj.length - 1; i >= 0; i--) {
                if(matches = child_obj[i].name.match(/(\w+)\[(\d+)\]\[(\w+)\]/)){
                    switch (matches[3].toLowerCase()) {
                        case 'quantity' :
                            // console.log('Quantity = ' + matches[2] + ' => ' + child_obj[i].value);
                            child   = child_obj[i].name;
                            break;
                        case 'amount' :
                            console.log('Amount = ' + matches[2] + ' => ' + child_obj[i].value);
                            break;
                    }
                }
            };
            console.log(child);
            console.log('Total Amount '+total);
        }

        $(function() {
            var $satuan     = JSON.parse('{!! $satuan_qty->content() !!}');
            var btn         = document.getElementById('btn-add-details');
            var $form       = document.forms['frm-transaction'];
            var $quantity   = $form.quantity;
            var $amount     = $form.amount;
            var $total      = $form.total;
            var $PlaceHolder    = document.getElementById('transaction_PlaceHolder');
            // $('#txt-quantity').maskMoney();
            // $('#txt-amount').maskMoney();

            var changeAmount    = function () {
                var qty     = parseFloat($quantity.value.replace(',', ''));
                var amnt    = parseFloat($amount.value.replace(',',''));

                qty         = isNaN(qty) ? 1 : qty;
                amnt        = isNaN(amnt) ? 0 : amnt;
                $total.value    = qty*amnt;
                // $('#sub-total').maskMoney();
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
                var len             = childObj.length;
                var nomor           = (len+1);

                var row             = document.createElement('tr');
                row.id              = 'row_'+len;
                var colNumber       = document.createElement('td');
                colNumber.innerHTML     = '#';
                var colQuantity     = document.createElement('td');
                var inpQuantity     = document.createElement('input');
                inpQuantity.type    = 'text';
                inpQuantity.name    = 'transactions['+ len +'][quantity]';
                inpQuantity.setAttribute('onkeyup', 'changeSubAmount(this, "'+ this.id +'");');
                colQuantity.appendChild(inpQuantity);
                var colSatuan       = document.createElement('td');
                var cmbSatuan       = document.createElement('select');
                var empOpt          = document.createElement('option');
                empOpt.value        = '';
                empOpt.text         = '(choose)';
                cmbSatuan.appendChild(empOpt);
                for (var i = $satuan.length - 1; i >= 0; i--) {
                    // console.log($satuan[i]);
                    o   = document.createElement('option');
                    o.value     = $satuan[i].id;
                    o.text      = $satuan[i].name;
                    cmbSatuan.appendChild(o);
                };
                colSatuan.appendChild(cmbSatuan);
                var colAmount       = document.createElement('td');
                var inpAmount       = document.createElement('input');
                inpAmount.type      = 'text';
                inpAmount.name      = 'transactions['+ len +'][amount]';
                inpAmount.id        = len;
                inpAmount.setAttribute('onkeyup', 'changeSubAmount(this, "'+ this.id +'");');
                colAmount.appendChild(inpAmount);
                var colCount        = document.createElement('td');
                var inpCount        = document.createElement('input');
                inpCount.type       = 'text';
                colCount.appendChild(inpCount);
                var colAction       = document.createElement('td');
                var deleteAction    = document.createElement('a');
                deleteAction.href   = 'javascript:void(0);';
                deleteAction.classList.add('btn', 'btn-danger');
                var deleteIcon      = document.createElement('i');
                deleteIcon.classList.add('glyphicon', 'glyphicon-trash');
                deleteAction.appendChild(deleteIcon);
                colAction.appendChild(deleteAction);

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