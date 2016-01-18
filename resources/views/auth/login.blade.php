@extends('layouts.authentication')
@section('title', 'Log-in')

@section('content')
    @include('common.auth')
    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="wrap">
                    <p class="form-title">
                        Wellome to ajaib
                    </p>
                    <form action="/auth/login" method="POST" class="login" novalidate>
                        {{ csrf_field() }}
                        <span class=" icon-user"></span><input type="email" name="email" value="{{ old('email') }}" placeholder="Email" />
                        <span class=" icon-lock-open"></span><input type="password" placeholder="Password" name="password" />
                        <input type="submit" value="Sign In" class="pull-right btn btn-success"/>
                    </form>
                    <div style="clear: both;"></div>
                </div>
            </div>
              <div class="col-md-4"></div>
        </div>
    </div>

@endsection