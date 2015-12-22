@extends('layouts.authentication')
@section('title', 'Register')

@section('content')
    @include('common.auth')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="wrap">
                    <p class="form-title">
                        Sign In
                    </p>
                    <form action="/auth/login" method="POST" class="login" novalidate>
                        {{ csrf_field() }}
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" />
                        <input type="password" placeholder="Password" name="password" />
                        <input type="submit" value="Sign In" class="btn btn-success btn-sm"/>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection