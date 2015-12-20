@extends('layouts.default')
@section('title', 'Register')

@section('content')
    <div id="tf-home" class="text-center">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-offset-4 col-sm-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Account Register
                            </div>
                            <div class="panel-body">
                                {{-- Display Validation Errors --}}
                                   @include('common.errors')

                                   {{-- New Form Login --}}
                                   <form action="/auth/login" method="POST" class="form-horizontal">
                                      {{ csrf_field() }}

                                      {{-- Email Address --}}
                                      <div class="form-group">
                                         <label for="email" class="col-sm-3 control-label">E-mail</label>
                                         <div class="col-sm-6">
                                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" />
                                         </div>
                                      </div>

                                      {{-- Password --}}
                                      <div class="form-group">
                                         <label for="password" class="col-sm-3 control-label">Password</label>
                                         <div class="col-sm-6">
                                            <input type="password" name="password" class="form-control" />
                                         </div>
                                      </div>

                                      {{-- Login Button --}}
                                      <div class="form-group">
                                         <div class="col-sm-offset-3 col-sm-6">
                                            <button type="submit" class="btn btn-default">
                                               <i class="fa fa-btn fa-sign-in"></i>Login
                                            </button>
                                         </div>
                                      </div>
                                   </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection