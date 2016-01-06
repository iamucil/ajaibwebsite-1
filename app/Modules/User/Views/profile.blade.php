@extends('layouts.dashboard')

@section('title')
    User Profile
@stop

@section('style')
    @parent
    <link rel="stylesheet" type="text/css" href="{{asset('/css/image-uploader.css')}}" />
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
                            <button type="button" class="btn btn-primary btn-block btn-lg" id="change-photo-profile" data-toggle="modal" data-target="#uploadPhotoModal">
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

                <!-- Modal -->
                <div class="modal fade" id="uploadPhotoModal" tabindex="-1" role="dialog" aria-labelledby="uploadPhotoModalLabel">
                    <form id="upload_form" enctype="multipart/form-data" method="post" action="upload/photo">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Upload Your Photo</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-danger" id="error">
                                        You should select valid image files only!
                                    </div>
                                    <div class="alert alert-danger" id="error2">
                                        An error occurred while uploading the file
                                    </div>
                                    <div class="alert alert-danger" id="abort">
                                        The upload has been canceled by the user or the browser dropped the connection
                                    </div>
                                    <div class="alert alert-danger" id="warnsize">
                                        Your file is very big. We can't accept it. Please select more small file
                                    </div>

                                    <div class="row">
                                        <img src="http://placehold.it/250x250" id="image_preview" width="250"/>
                                    </div>

                                    <div id="progress_info">
                                        <div id="progress"></div>
                                        <div id="b_transfered" class="pull-left"> </div>
                                        <div id="progress_percent" class="pull-right"> </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}" >
                                    <span class="btn btn-primary fileinput-button pull-left">
                                        <i class="glyphicon glyphicon-folder-open"></i> Choose
                                        <input type="file" name="image_file" id="image_file" onchange="fileSelected();" >
                                    </span>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-success" onclick="startUploading('upload/photo')" >
                                        <i class="glyphicon glyphicon-floppy-saved"></i> Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!--/panel-->


        </div>
    </div>
</div>
@stop

@section('script-lib')
    @parent
    <script type="text/javascript" src="{{asset('/js/image-uploader.js')}}"></script>
@stop

@section('script-bottom')
    @parent
    <script>
        function refreshPhoto(){
            alert("asd");
        }
    </script>
@stop