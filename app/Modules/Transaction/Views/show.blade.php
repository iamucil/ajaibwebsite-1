@extends('layouts.dashboard')

@section('title')
    Transaction - Details
@stop

@section('script')
    @parent
@stop

@section('content')
<div class="box bg-white">
    <div class="box-body pad-forty" style="display: block;">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th colspan="2">
                        <h4>
                            Data Transaksi
                        </h4>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th style="width: 195px;">
                        Invoice Number
                    </th>
                    <td>
                        {!! $data->invoice_number !!}
                    </td>
                </tr>
                <tr>
                    <th>
                        Invoice For
                    </th>
                    <td>
                        {!! $data->Category->name !!} &mdash;
                        {!! $data->keterangan !!}
                    </td>
                </tr>
                <tr>
                    <th>
                        Payable to
                    </th>
                    <td>
                        {{ $data->AccountPayable->phone_number }} [{!! $data->AccountPayable->email !!}]
                    </td>
                </tr>
                <tr>
                    <th>
                        Date
                    </th>
                    <td>
                        {!! date('Y-m-d', strtotime($data->tanggal)) !!}
                    </td>
                </tr>
                <tr>
                    <th colspan="2">
                        <h5>
                            Details
                        </h5>
                    </th>
                </tr>
                <tr>
                    <td colspan="2" style="padding: 0px;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        Description
                                    </th>
                                    <th>
                                        Quantity
                                    </th>
                                    <th>
                                        Harga
                                    </th>
                                    <th>
                                        Jumlah
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data->TransactionDetails as $detail)
                                    <tr>
                                        <td>
                                            {!! $detail->keterangan !!}
                                        </td>
                                        <td align="right">
                                            {!! $detail->quantity !!}
                                        </td>
                                        <td align="right">
                                            {!! number_format($detail->amount, 2, ',','.') !!}
                                        </td>
                                        <td align="right">
                                            {!! number_format($detail->quantity*$detail->amount, 2, ',','.') !!}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">
                                            Data Kosong
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" align="right">
                                        <h4 style="text-align: right;">
                                            {!! number_format($data->amount, 2, ',','.') !!}
                                        </h4>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <p>
            <a class="btn btn-link" href="{{ route('transactions.index') }}" role="button">Kembali</a>
        </p>
    </div>
</div>
@stop

@section('script-bottom')
    {{-- expr --}}
@stop