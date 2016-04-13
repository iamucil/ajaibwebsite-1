@extends('layouts.dashboard')
@section('title')
    Menu Management
@stop

@section('content')
    <div class="row">
        <div class="col-md-2">
            <div class="bg-complete-profile">
                <a href="{{ route('menus.create') }}">
                    <span class="icon-plus"></span>
                    <h6 class="bg-black text-white"><strong>Add new Menu</strong></h6>
                </a>
            </div>
        </div>
    </div>
@stop

@section('script-bottom')
    @parent
@stop