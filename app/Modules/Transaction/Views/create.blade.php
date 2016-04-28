@extends('layouts.dashboard')

@section('title')
    Transaction - ADD
@stop

@section('script')
    @parent
@stop

@section('script-lib')
    @parent
    <script type="text/javascript" src="{{ secure_asset('/js/vendor/bootstrap3-typeahead.min.js') }}"></script>
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
                <label class="col-sm-2 control-label">Account Payable</label>
                <div class="col-sm-4">
                    <input type="hidden" name="user_id" value="{{ old('user_id') }}" />
                    <input type="hidden" name="user_name" value="{{ old('user_name') }}" />
                    <input class="form-control" type="text" class="typehead" id="acount-payable" autocomplete="off" placeholder="eg: 85640427774" value="{{ old('ap') }}" name="ap" />
                </div>
            </div>
            <div class="form-group">
                <label for="tanggal" class="col-sm-2 control-label">Tanggal</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control datepicker" id="txt-date" placeholder="MM/DD/YYYY" name="tanggal" value="{{ old('tanggal', date('m/d/Y', time())) }}" autocomplete="off" />
                </div>
            </div>
            <div class="form-group">
                <label for="select-category" class="col-sm-2 control-label">Kategory</label>
                <div class="col-sm-4">
                    {!! Form::select('category_id', $categories, old('category_id'), ['placeholder' => 'Pick a category...', 'class' => 'form-control', 'id' => 'select-category']) !!}
                </div>
            </div>
            <div class="form-group">
                <label for="select-vendor" class="col-sm-2 control-label">Vendor</label>
                <div class="col-sm-6">
                    {!! Form::select('vendor_id', $vendors, old('vendor_id'), ['placeholder' => 'Pick a vendor...', 'class' => 'form-control', 'id' => 'select-vendor']) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="sub-total">Amount</label>
                <div class="col-sm-5">
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
                            <td colspan="5" align="center" style="font-style: italic;">
                                Data Kosong
                            </td>
                        </tr>
                    </tbody>
                </table>
            </fieldset>
            <hr />
            <div class="form-group">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary" style="border-radius: 4px;"><i class="glyphicon glyphicon-floppy-disk"></i> Simpan</button>
                    <a class="btn btn-danger" style="border-radius: 4px;" href="{{ route('transactions.index') }}">
                        <i class="glyphicon glyphicon-floppy-remove"></i> Batal
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
        $input          = $('.typeahead');
        $user_id     = $("input[name='user_id']");
        $user_name   = $("input[name='user_name']");
        var url     = '{{ route("member.lists") }}';
        $.getJSON( url, function( data ) {
            $("#acount-payable").typeahead({
                source:data,
                updater: function (item) {
                    console.log(item);
                    return item;
                },
                afterSelect: function(item){
                    $input.val(item.name);
                    $user_id.val(item.id);
                    $user_name.val(item.name);
                    // console.log(item);
                }
            });
        }, 'json');
        function changeSubAmount (el, obj_id) {
            var obj         = document.getElementById(obj_id);
            var nominal     = 0;
            var total       = 0;

            if(match = el.name.match(/(\w+)\[(\d+)\]\[(\w+)\]/)){
                var id      = match[2];
                var elem    = match[1];
                var qty     = document.getElementsByName(elem+'['+id+'][quantity]')[0].value;
                var amount  = document.getElementsByName(elem+'['+id+'][amount]')[0].value;
                var node_total  = document.getElementsByName(elem +'['+id+'][total]')[0];
                if(!isNaN(parseFloat(qty)*parseFloat(amount))){
                    total   = parseFloat(qty)*parseFloat(amount);
                    node_total.value    = total;
                }
            }
            submitAmount(obj);
        }

        function submitAmount (obj) {
            if(obj !== undefined && obj != null){
                var child_obj       = obj.getElementsByTagName('input');
                var element_total   = document.getElementsByName('total')[0];
                var child           = [];
                var index           = 0;
                var total_amount    = 0;
                for (var i = child_obj.length - 1; i >= 0; i--) {
                    if(matches = child_obj[i].name.match(/(\w+)\[(\d+)\]\[(\w+)\]/)){
                        var idx     = matches[2];
                        // create new array for multidimensional array in js
                        child[idx]  = [];
                        child[idx]['quantity']  = document.getElementsByName('transactions['+idx+'][quantity]')[0].value;
                        child[idx]['amount']    = document.getElementsByName('transactions['+idx+'][amount]')[0].value;
                    }
                };

                if(child.length > 0){
                    for (var i in child){
                        total_amount    += parseFloat(child[i].quantity)*parseFloat(child[i].amount);
                    }
                }

                element_total.value     = total_amount;
            }
        }

        function deleteItem (el, obj_id) {
            var tBody       = document.getElementById(obj_id);
            if(typeof(tBody) != 'undefined' && tBody != null){
                var childObj        = tBody.getElementsByTagName('tr');
                var parentNode      = el.parentNode.parentNode;
                var nodeDesc        = parentNode.nextSibling;

                var firstNode     = tBody.firstChild.nextSibling;

                if(firstNode.id != 'empty-row' || firstNode.id !=  'row-total'){
                    if(nodeDesc.classList.contains('row-descriptions')){
                        tBody.removeChild(parentNode.nextSibling);
                    }
                    tBody.removeChild(parentNode);
                    if(childObj.length === 0){
                        setEmptyRecord(tBody);
                    }else{
                        var nomor       = 1;
                        for(var i = 0; i < childObj.length; i++){
                          if(childObj[i].id != 'row-total' && !childObj[i].classList.contains('row-descriptions')){
                            childObj[i].cells[0].innerHTML   = nomor;
                            nomor+=1;
                          }
                        }
                        if(childObj[0].id == 'row-total' ){
                            setEmptyRecord(tBody);
                        }
                    }

                    submitAmount(tBody);
                }else{
                    setEmptyRecord(tBody);
                }
            } else {
                if(window.console && window.console.log){
                    console.log('Cannot find element');
                }
            }

        }

        function setEmptyRecord (elem){
            var childObj   = elem.getElementsByTagName('tr');
            for (var i = childObj.length - 1; i >= 0; i--) {
                elem.removeChild(childObj[i]);
            };

            var frag       = document.createDocumentFragment();
            var tr         = document.createElement('tr');
            tr.id          = 'empty-row';
            var td         = document.createElement('td');
            td.setAttribute('colspan', 11);
            td.style.textAlign   = 'center';
            td.style.fontStyle   = 'italic';
            td.innerHTML   = 'Data Kosong';

            tr.appendChild(td);
            frag.appendChild(tr);
            elem.insertBefore(frag, elem.firstChild);

            return true;
        }

        $(function() {
            $('.datepicker').each(function () {
                $(this).datepicker({
                    'autoclose' : true,
                    'startView' : 0,
                    'todayBtn' : 'linked'
                });
            });
            var $transactions   = JSON.parse('{!! $transactions->content() !!}');
            var $satuan     = JSON.parse('{!! $satuan_qty->content() !!}');
            var btn         = document.getElementById('btn-add-details');
            var $form       = document.forms['frm-transaction'];
            var $PlaceHolder    = document.getElementById('transaction_PlaceHolder');

            var changeAmount    = function () {
                var qty     = parseFloat($quantity.value.replace(',', ''));
                var amnt    = parseFloat($amount.value.replace(',',''));

                qty         = isNaN(qty) ? 1 : qty;
                amnt        = isNaN(amnt) ? 0 : amnt;
                $total.value    = qty*amnt;
            }

            $PlaceHolder.addRows    = function (id, qty, satuan, amount, keterangan) {
                var childObj        = this.getElementsByTagName('tr');
                var index           = 0;
                var nomor           = 1;
                for (var i = 0; i < childObj.length; i++) {
                    if(childObj[i].id == 'empty-row' || childObj[i].id == 'row-total') {
                        this.removeChild(childObj[i]);
                        continue;
                    }

                    if(childObj[i].classList.contains('row-descriptions')){
                        continue;
                    }

                    index++;
                    nomor+=1;
                }

                var len             = childObj.length;
                qty                 = (qty === undefined || qty == null) ? 0 : parseInt(qty);
                amount              = (amount === undefined || amount == null) ? 0 : parseFloat(amount);
                var nominal         = qty*amount;
                var inHidId         = document.createElement('input');
                inHidId.type        = 'hidden';
                inHidId.name        = 'transactions['+index+'][id]';
                inHidId.value       = id;

                var row             = document.createElement('tr');
                row.id              = 'row_'+index;
                var colNumber       = document.createElement('td');
                colNumber.innerHTML = nomor;
                colNumber.align     = 'center';
                colNumber.vAlign    = 'middle';
                var colQuantity     = document.createElement('td');
                var inpQuantity     = document.createElement('input');
                inpQuantity.type    = 'text';
                inpQuantity.name    = 'transactions['+ index +'][quantity]';
                inpQuantity.size    = 4;
                inpQuantity.value   = qty;
                inpQuantity.setAttribute('onkeyup', 'changeSubAmount(this, "'+ this.id +'");');
                colQuantity.appendChild(inpQuantity);
                var colSatuan       = document.createElement('td');
                var cmbSatuan       = document.createElement('select');
                cmbSatuan.name      = 'transactions['+index+'][satuan]';
                // var empOpt          = document.createElement('option');
                // empOpt.value        = '';
                // empOpt.text         = '(choose)';
                // cmbSatuan.appendChild(empOpt);
                for (var i = $satuan.length - 1; i >= 0; i--) {
                    // console.log($satuan[i]);
                    o   = document.createElement('option');
                    o.value     = $satuan[i].id;
                    o.text      = $satuan[i].name;
                    if(satuan !== undefined && satuan == $satuan[i].id) {
                        o.selected  = true;
                    }
                    cmbSatuan.appendChild(o);
                };
                colSatuan.appendChild(cmbSatuan);
                var colAmount       = document.createElement('td');
                var inpAmount       = document.createElement('input');
                inpAmount.type      = 'text';
                inpAmount.name      = 'transactions['+ index +'][amount]';
                inpAmount.id        = index;
                inpAmount.size      = 18;
                inpAmount.value     = amount;
                inpAmount.setAttribute('onkeyup', 'changeSubAmount(this, "'+ this.id +'");');
                colAmount.appendChild(inpAmount);
                var colCount        = document.createElement('td');
                var inpCount        = document.createElement('input');
                inpCount.type       = 'text';
                inpCount.readOnly   = true;
                inpCount.size       = 20;
                inpCount.name       = 'transactions['+index+'][total]';
                inpCount.value      = nominal;
                colCount.appendChild(inpCount);

                var colAction       = document.createElement('td');
                colAction.setAttribute('rowspan', '2');
                var deleteAction    = document.createElement('a');
                deleteAction.href   = 'javascript:void(0);';
                deleteAction.classList.add('btn', 'btn-danger');
                deleteAction.style.borderRadius   = '4px';
                deleteAction.setAttribute('onclick', 'deleteItem(this, "'+this.id+'")');
                var deleteIcon      = document.createElement('i');
                deleteIcon.classList.add('glyphicon', 'glyphicon-trash');
                deleteAction.appendChild(deleteIcon);

                colAction.appendChild(deleteAction);
                row.appendChild(inHidId);
                row.appendChild(colNumber);
                row.appendChild(colQuantity);
                row.appendChild(colSatuan);
                row.appendChild(colAmount);
                row.appendChild(colCount);
                row.appendChild(colAction);

                this.appendChild(row);

                var rowKeterangan   = document.createElement('tr');
                rowKeterangan.classList.add('row-descriptions');
                var tdLabelKeterangan   = document.createElement('td');
                tdLabelKeterangan.setAttribute('colspan', '3');
                tdLabelKeterangan.innerHTML     = 'Keterangan';
                tdLabelKeterangan.style.fontWeight  = 'bold';
                tdLabelKeterangan.style.textAlign   = 'right';
                var tdKeterangan        = document.createElement('td');
                tdKeterangan.setAttribute('colspan','2');
                var inpKeterangan   = document.createElement('textarea');
                inpKeterangan.name  = 'transactions['+index+'][keterangan]';
                inpKeterangan.placeholder   = 'Keterangan';
                inpKeterangan.value = (keterangan === undefined || keterangan == '') ? '' : keterangan;
                inpKeterangan.style.width   = '100%';
                inpKeterangan.rows  = 3;
                inpKeterangan.style.resize  = 'none';
                inpKeterangan.style.height  = '100%';
                tdKeterangan.appendChild(inpKeterangan);

                rowKeterangan.appendChild(tdLabelKeterangan);
                rowKeterangan.appendChild(tdKeterangan);
                this.appendChild(rowKeterangan);

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
            }

            btn.onclick         = function (e) {
                $PlaceHolder.addRows(null, null, null, null, null);
                e.preventDefault();
                return false;
            }

            // if request has returned error or return any data
            if($transactions !== undefined && $transactions != null){
                for (var t in $transactions) {
                    $PlaceHolder.addRows($transactions[t].id, $transactions[t].quantity, $transactions[t].satuan, $transactions[t].amount, $transactions[t].keterangan);
                }

                submitAmount($PlaceHolder);
            }
        });
    </script>
@stop