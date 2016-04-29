@extends('layouts.authentication')
@section('title', 'Log-in')

@section('content')
    @include('common.auth')
    <div class="container" ng-controller="AuthController" ng-init="getAdd()">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="wrap">
                    <p class="form-title">Wellome to ajaib</p>
                    <form name="form_login" class="login form-horizontal" novalidate ng-submit="actLogin(form_login.$valid)" id="form">
                        <div class="form-group" ng-class="{'has-error' : form_login.email.$invalid && submitted }">
                            
                            <div class="col-sm-12">
                                <span class="icon-user"></span>
                                <input type="text" name="email" ng-required="true" ng-value="" ng-model="form.email" placeholder="Email or Username">
                                <p ng-show="form_login.email.$invalid && submitted" class="help-block">Email is required.</p>
                            </div>
                            
                        </div>

                        <div class="form-group" ng-class="{'has-error' : form_login.password.$invalid && submitted }">
                            <div class="col-sm-12">
                                <span class="icon-lock-open"></span>
                                <input type="password" ng-required="true" ng-value="" placeholder="Your secret" name="password" ng-model="form.password" >
                                <p ng-show="form_login.password.$invalid && submitted" class="help-block">Password is required.</p>
                            </div>
                            
                        </div>
                        <div class="form-group">                            
                            <div class="col-sm-12">
                                <input type="submit" value="Sign In" class="pull-right btn btn-success" />
                            </div>                            
                        </div>
                    </form>
                    <div style="clear: both;"></div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>

@endsection