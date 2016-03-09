@extends('layouts.dashboard')

@section('title')
    Daftar Vendor
@stop

@section('content')
    <div class="box bg-white">
        <div class="box-body pad-forty">
            <h3>
                {{ $vendor->name }} <small>{{ $vendor->category->name }}</small>
            </h3>
            <p>
                {{ $vendor->description }}
            </p>
            <hr />
            <a class="btn btn-default" href="#" role="button">Link</a>

        </div>
    </div>
@stop