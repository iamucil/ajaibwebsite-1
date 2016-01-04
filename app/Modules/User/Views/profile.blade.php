@extends('layouts.dashboard')

@section('title')
    User Profile
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 text-center">
                            <img src="http://api.randomuser.me/portraits/men/98.jpg" alt="" class="center-block img-circle img-responsive">
                            <div class="clearfix"></div>
                            <br />
                            <button type="button" class="btn btn-primary btn-block btn-lg" id="change-photo-profile">
                               <i class="glyphicon glyphicon-camera"></i> Change Photo
                            </button>
                        </div><!--/col-->
                        <div class="col-xs-12 col-sm-8">
                            <h2>
                                {{ is_null($user->firstname) ? $user->name : $user->firstname }}
                            </h2>
                            <p>
                                <h5>
                                    {{ $user->email }}
                                    <small>{{ $user->address }}</small>
                                </h5>
                            </p>
                            <p>
                                <strong>Since: </strong> {{ $user->created_at }}
                            </p>

                            <p>
                                <strong>Phone Number: </strong> {{ $user->phone_number }}
                            </p>

                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-3">
                                    <a class="btn btn-primary btn-block"><span class="fa fa-user"></span> Update Profile </a>
                                </div><!--/col-->
                                <div class="col-xs-12 col-sm-4">
                                    <a class="btn btn-danger btn-block"><span class="fa fa-gear"></span> Change Password </a>
                                </div><!--/col-->
                            </div>
                        </div><!--/col-->

                    </div><!--/row-->

                </div><!--/panel-body-->
            </div><!--/panel-->


        </div>
    </div>
</div>
@stop