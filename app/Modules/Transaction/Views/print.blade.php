@extends('layouts.invoice')
@section('title', $transaction->invoice_number)
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="invoice-title">
                <h2>Invoice</h2><h3 class="pull-right">Order # {{ $transaction->invoice_number }}</h3>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                    <strong>Billed To:</strong><br>
                        {{ $transaction->AccountPayable->name }}<br>
                        {{ $transaction->AccountPayable->address }}
                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    <address>
                    <strong>Shipped To:</strong><br>
                        {{ $transaction->AccountPayable->name }}<br>
                        {{ $transaction->AccountPayable->address }}
                    </address>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                        <strong>Payment Method:</strong><br>
                        Visa ending **** 4242<br>
                        {{ $transaction->AccountPayable->email }}
                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    <address>
                        <strong>Order Date:</strong><br>
                        {{ date('F d, Y', strtotime($transaction->tanggal)) }}<br><br>
                    </address>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Order summary</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <td><strong>Item</strong></td>
                                    <td class="text-center"><strong>Price</strong></td>
                                    <td class="text-center"><strong>Quantity</strong></td>
                                    <td class="text-right"><strong>Totals</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                @forelse ($transaction->TransactionDetails as $detail)
                                    <tr>
                                        <td>
                                            {{ $detail->keterangan }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($detail->amount, 2, ',','.') }}
                                        </td>
                                        <td class="text-center">
                                            {{ $detail->quantity }}
                                        </td>
                                        <td class="text-right">
                                            {!! number_format($detail->quantity*$detail->amount, 2, ',','.') !!}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">No Details</td>
                                    </tr>
                                @endforelse
                                <tr>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line text-center"><strong>Subtotal</strong></td>
                                    <td class="thick-line text-right">{!! number_format($transaction->amount, 2, ',','.') !!}</td>
                                </tr>
                                <tr>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line text-center"><strong>Shipping</strong></td>
                                    <td class="no-line text-right">0</td>
                                </tr>
                                <tr>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line text-center"><strong>Total</strong></td>
                                    <td class="no-line text-right">{!! number_format($transaction->amount, 2, ',','.') !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop