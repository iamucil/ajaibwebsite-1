@extends('layouts.backend')

@section('title', 'Dashboard Admin')

@section('notification')
    @include('common.alerts')
    @include('common.errors')
    @include('common.info')
    @include('common.success')
@endsection

@section('content')

        <p>This is ajaib body content.</p>

@endsection