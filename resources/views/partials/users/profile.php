<!-- <link rel="stylesheet" type="text/css" href="{{asset('/css/image-uploader.css')}}" />  -->
<div class="container" ng-controller="UserController" ng-init="getProfile()">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 text-center">
                            <img src="[[profile.photo]]" alt="" id="photo-profile" class="center-block img-circle img-responsive">
                            <div class="clearfix"></div>
                            <br />
                            <button type="button" class="btn btn-primary btn-block btn-lg" id="change-photo-profile" data-toggle="modal" data-target="#uploadPhotoModal">
                                <i class="glyphicon glyphicon-camera"></i> Change Photo
                            </button>
                        </div>
                        <!--/col-->
                        <div class="col-xs-12 col-sm-8">
                            <h2>
                                [[ isExists(profile.firstname) ? profile.firstname : profile.name | ucfirst]]
                            </h2>
                            <p>
                                <h5>
                                    [[profile.email]]
                                    <small>[[profile.address]]</small>
                                </h5>
                            </p>
                            <p>
                                <strong>Since: </strong>  [[profile.created_at | date : 'dd/MM/yyyy HH:MM:ss']]
                            </p>
                            <p>
                                <strong>Phone Number: </strong> [[profile.phone_number]]
                            </p>
                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-3">
                                    <a class="btn btn-primary btn-block" href="/users/[[currentId]]/edit">
                                        <span class="fa fa-user"></span> Update Profile
                                    </a>
                                </div>
                                <!--/col-->
                                <div class="col-xs-12 col-sm-4">
                                    <a class="btn btn-danger btn-block"><span class="fa fa-gear"></span> Change Password </a>
                                </div>
                                <!--/col-->
                            </div>
                        </div>
                        <!--/col-->
                    </div>
                    <!--/row-->
                </div>
                <!--/panel-body-->
                <!-- Upload Photo Modal -->
                <div class="modal fade" id="uploadPhotoModal" tabindex="-1" role="dialog" aria-labelledby="uploadPhotoModalLabel">
                    <form id="upload_form" enctype="multipart/form-data" method="post" action="upload/photo" name="profileForm">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <a type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
                                    <h4 class="modal-title" id="uploadPhotoModalLabel">Upload Your Photo</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <img src="[[profile.photo]]" id="image_preview" width="250"/>
                                    </div>

                                    <div id="progress_info">
                                        <div id="progress"></div>
                                        <div id="b_transfered" class="pull-left"> </div>
                                        <div id="progress_percent" class="pull-right"> </div>
                                    </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <input type="text" style="display:none" name="user_id" id="user_id" ng-model="user_id" ng-value="[[ profile.id ]]">
                                    <span class="btn btn-primary fileinput-button pull-left">
                                        <i class="glyphicon glyphicon-folder-open"></i> Choose
                                        <input 
                                        id="image_file"
                                        type="file" 
                                        ngf-select 
                                        ng-model="picFile" 
                                        name="file"    
                                        accept="image/*" 
                                        ngf-max-size="1MB" 
                                        required
                                        ngf-model-invalid="errorFile">
                                        <i class="label label-error" ng-show="profileForm.file.$error.required">*required</i><br>
                                        <i class="label label-error" ng-show="profileForm.file.$error.maxSize">File too large 
                                        [[errorFile.size / 1000000|number:1]]MB: max 2M</i>
                                    </span>
                                    <button ng-click="picFile = null" class="btn fileinput-button pull-left" ng-show="picFile">Remove</button>
                                    <img ng-show="profileForm.file.$valid" ngf-thumbnail="picFile" width="200" height="200" class="thumb">
                                    <a type="button" class="btn btn-default" data-dismiss="modal">Cancel</a>
                                    <a type="button" ng-disabled="!profileForm.$valid" class="btn btn-success" ng-click="profileSubmit(profileForm)">
                                        <i class="glyphicon glyphicon-floppy-saved"></i> Save
                                    </a>
                                    <span class="progress" ng-show="picFile.progress >= 0">
                                        <div class="progress-bar" style="width:[[picFile.progress]]%" 
                                            ng-bind="picFile.progress + '%'"></div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--/panel-->
        </div>
    </div>
</div>
<!-- <script type="text/javascript" src="{{asset('/js/image-uploader.js')}}"></script>
<script>
function refreshPhoto(url_photo) {
    document.getElementById('photo-profile').src = url_photo + '?' + new Date().getTime();
}

function hiddenAjaxPhotoInfo() {
    document.getElementById('error').style.display = 'none';
    document.getElementById('error2').style.display = 'none';
    document.getElementById('abort').style.display = 'none';
    document.getElementById('warnsize').style.display = 'none';
    document.getElementById('progress').style.display = 'none';
    document.getElementById('b_transfered').style.display = 'none';
    document.getElementById('progress_percent').style.display = 'none';
}
</script>
 -->
