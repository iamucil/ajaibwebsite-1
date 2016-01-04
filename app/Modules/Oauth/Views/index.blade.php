@extends('layouts.dashboard')

@section('title')
    Oauth
@stop

@section('content')

<div class="box">

    <div class="box-header bg-transparent">
        <h3 class="box-title">
            <i class="icon-menu"></i>
        <span>
            Client
        </span>
        </h3>

        <div class="pull-right box-tools">
        <span class="box-btn" data-widget="collapse">
            <i class="icon-minus"></i>
        </span>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-4 col-md-offset-8">
                <div class="pull-right">
                    <a href="{{ URL::route('oauth.create') }}" class="btn btn-success">
                        <i class="fa fa-plus"></i> Tambah Data
                    </a>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="width: 40px;">
                                #
                            </th>
                            <th style="width: 90px;">
                                Client
                            </th>
                            <th>
                                ID
                            </th>
                            <th>
                                Secret
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        {{--*/ $nomor   = $clients->currentPage() /*--}}

                        @forelse ($clients as $client)
                            <tr>
                                <td>
                                    {{ $nomor }}
                                </td>
                                <td>
                                    {{ $client->name }}
                                </td>
                                <td>
                                    {{ $client->id }}
                                </td>
                                <td>
                                    {{ $client->secret }}
                                </td>
                                <td>
                                </td>
                            </tr>
                            <?php $nomor++; ?>
                        @empty
                            <tr>
                                <td colspan="5">
                                    Data Kosong
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {!! $clients !!}
    </div>
</div>
@stop