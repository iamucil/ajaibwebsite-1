@extends('layouts.dashboard')

@section('title')
    Transaction - ADD
@stop

@section('content')
<div class="box bg-white">
    <div class="box-body pad-forty" style="display: block;">
        <div class="row">
            <div class="col-sm-3">
                Module Actions
            </div>
            <div class="col-sm-9">
                <form class="form-horizontal" method="post" action="{{ route('transactions.store') }}" enc-type="multipart/form-data">
                    {{ csrf_field() }}
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
    </div>
</div>
@stop

@section('script-bottom')
    @parent
    <script language="javascript">
        $(function() {
            console.log('add some transaction')
        });
    </script>
@stop