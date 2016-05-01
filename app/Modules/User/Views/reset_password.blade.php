@extends('layouts.dashboard')

@section('title')
    Reset Password
@stop

@section('content')
    <div class="box">
        <div class="box-header bg-transparent">
            <h3 class="box-title">
                <i class="icon-menu"></i>
                <span>
                    Reset Password
                </span>
            </h3>
        </div>
        <div class="box-body">
            <form class="form-horizontal" method="post" action="{{ route('users.reset-password') }}" name="frm-user-reset" id="frm-user-reset" novalidate="true">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="old-password" class="col-sm-2 control-label">
                        Old Password
                    </label>
                    <div class="col-sm-4">
                        <input type="password" name="old_password"  class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="old-password" class="col-sm-2 control-label">
                        Password
                    </label>
                    <div class="col-sm-4">
                        <input type="password" name="password"  class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="old-password" class="col-sm-2 control-label">
                        Retype Password
                    </label>
                    <div class="col-sm-4">
                        <input type="password" name="retype_password"  class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Simpan</button>
                        @if (auth()->user()->hasRole(['root', 'admin']))
                            <a href="{{ route('user.list') }}" class="btn btn-default">Batal</a>
                        @else
                            <a href="{{ route('admin::dashboard') }}" class="btn btn-default">Batal</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script-bottom')
    @parent
@stop