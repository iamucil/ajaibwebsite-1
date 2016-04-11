@extends('layouts.dashboard')

@section('title')
Transaction
@stop

@section('content')
    <div class="box">
        <div class="box-header bg-transparent">
            <!-- tools box -->
            <div class="pull-right box-tools">
                <div class="btn-group" role="group" aria-label="...">
                    <a href="{{ route('transactions.create') }}" class="btn btn-default" role="button">
                        Tambah Transaksi
                    </a>
                    <a class="btn btn-default" role="button" href="{{ route('transaction.category.index') }}">
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
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Tanggal
                        </th>
                        <th>
                            Nomor Transaksi
                        </th>
                        <th>
                            Kategori
                        </th>
                        <th>
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {{--*/ $nomor   = $transactions->currentPage() /*--}}
                    @forelse ($transactions as $transaction)
                        <tr>
                            <td align="center">
                                {!! $nomor !!}
                            </td>
                            <td>
                                {{ date('d F, Y', strtotime($transaction->tanggal)) }}
                            </td>
                            <td>
                                {{ $transaction->invoice_number }}
                            </td>
                            <td>
                                {{ $transaction->category->name }}
                            </td>
                            <td style="width: 195px;">
                                <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-default">
                                    <i class="glyphicon glyphicon-list-alt"></i>
                                </a>
                                <a href="{{ route('transactions.invoice.print', [\Crypt::encrypt($transaction->id), 'pdf']) }}" class="btn btn-default" title="invoice PDF" target="_blank">
                                    <i class="glyphicon glyphicon-credit-card" alt="invoice"></i>
                                </a>
                                <a href="{{ route('transactions.invoice.print', \Crypt::encrypt($transaction->id)) }}" class="btn btn-default" target="_blank" title="invoice html">
                                    <i class="glyphicon glyphicon-duplicate"></i>
                                </a>
                                <a href="{{ route('transactions.invoice.print', [
                                \Crypt::encrypt($transaction->id),
                                'image']) }}" class="btn btn-default" target="_blank" title="invoice image">
                                    <i class="glyphicon glyphicon-save-file"></i>
                                </a>
                            </td>
                        </tr>
                        <?php $nomor++; ?>
                    @empty
                        <tr>
                            <th colspan="4">
                                Data Kosong
                            </th>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {!! $transactions->render() !!}
        </div>
    </div>
@stop

@section('script-bottom')
    @parent
@stop