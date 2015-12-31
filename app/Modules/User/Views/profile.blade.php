@extends('layouts.dashboard')

@section('title')
   User Profile
@stop

@section('content')
<div class="box">
   <div class="box-header bg-transparent">
        <h3 class="box-title">
            <i class="icon-user"></i>
            <span>
                Profile
            </span>
        </h3>
        <div class="pull-right box-tools">
            <span class="box-btn" data-widget="collapse">
                <i class="icon-minus"></i>
            </span>
        </div>
    </div>
    <div class="box-body">
        {!! $user !!}

        {{ $url }}
   </div>
</div>
@stop