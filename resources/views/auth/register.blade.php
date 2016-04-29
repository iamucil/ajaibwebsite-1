@extends('layouts.default')
@section('title', 'Account Register')

@section('content')
    <div id="tf-home" class="text-center" ng-controller="AuthController" ng-init="getCountry()">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-offset-4 col-sm-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Account Register
                            </div>
                            <div class="panel-body">

                                @include('common.errors')

                                <form ng-submit="actRegister(frm_register.$valid)" name="frm_register" id="form-register" novalidate>
                                    <div class="form-group"  ng-class="{'has-error' : frm_register.email.$invalid && submitted }">
                                        <label for="exampleInputEmail1" class="control-label">Email address</label>
                                        <input 
                                            type="email" 
                                            class="form-control" 
                                            id="exampleInputName2" 
                                            placeholder="Alamat email anda" 
                                            name="email"
                                            ng-model="form.email"
                                            ng-required="true">
                                        <p ng-show="frm_register.email.$invalid && submitted" class="help-block pull-left">Email is required.</p>
                                    </div>
                                    <br/>
                                    <div class="form-group" ng-class="{'has-error' : frm_register.phone_number.$invalid && submitted }">
                                        <label for="exampleInputPassword1" class="control-label">Phone Number</label>
                                        <div class="clearfix"></div>
                                        <div class="input-group">                                            
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                id="exampleInputEmail2" 
                                                placeholder="" 
                                                name="phone_number"
                                                ng-required="true"
                                                ng-model="form.phone_number"
                                                international-phone-number 
                                                default-country="id"
                                                preferred-countries="id,us,gb">
                                        </div>
                                        <p ng-show="frm_register.phone_number.$invalid && submitted" class="help-block pull-left">Phone Number is required.</p>
                                    </div>
                                    <br/>

                                    <button type="submit" class="btn btn-default btn-block btn-ajaib">Sign Up</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection