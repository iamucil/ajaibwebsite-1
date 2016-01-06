
<div class="col-lg-12 text-center">
    {!! Form::open(array('route' => 'admin.upload', 'method' => 'POST', 'id' => 'my-dropzone', 'class' => 'form single-dropzone', 'files' => true)) !!}
    <div id="img-thumb-preview">
        <img id="img-thumb" class="user size-lg img-thumbnail" src="{{ Helper::defaultDentistPic($user) }}">
    </div>
    <button id="upload-submit" class="btn btn-default margin-t-5"><i class="fa fa-upload"></i> Upload Picture</button>
    {!! Form::close() !!}
</div>
