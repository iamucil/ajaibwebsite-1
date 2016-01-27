@extends('layouts.dashboard')

@section('title')
    Daftar Vendor
@stop

@section('content')
<div class="box bg-white">
    <div class="box-header bg-transparent">
        <!-- tools box -->
        <div class="pull-right box-tools">
            <div class="btn-group" role="group" aria-label="...">
                <a href="{{ route('vendor.create') }}" class="btn btn-default" role="button">
                    Tambah Vendor
                </a>
                <a href="#" class="btn btn-default" role="button" href="vendor.category.index">
                    Daftar Kategori
                </a>
                {{-- <button type="button" class="btn btn-default">Tambah Kategory</button>
                <button type="button" class="btn btn-default">Daftar Vendor</button> --}}
                {{-- <button type="button" class="btn btn-default">Right</button> --}}
            </div>
        </div>
        <h3 class="box-title">
            <i class="fontello-th-large-outline"></i>
            <span>Vendor</span>
        </h3>
    </div>
</div>
@stop