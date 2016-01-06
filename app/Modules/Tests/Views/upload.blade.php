<html lang="en" >
<head>
    <meta charset="utf-8" />
    <title>Pure HTML5 file upload | Script Tutorials</title>
    <link href="{{asset('/css/image-uploader.css')}}" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="container">
    <div class="contr"><h2>You can select the file (image) and click Upload button</h2></div>

    <div class="upload_form_cont">
        <form id="upload_form" enctype="multipart/form-data" method="post" action="upload/process">
            <div>
                <div><label for="image_file">Please select image file</label></div>
                <div><input type="file" name="image_file" id="image_file" onchange="fileSelected();" /></div>
            </div>
            <div>
                <input type="button" value="Upload" onclick="startUploading('upload/process')" />
            </div>
            <div id="error">You should select valid image files only!</div>
            <div id="error2">An error occurred while uploading the file</div>
            <div id="abort">The upload has been canceled by the user or the browser dropped the connection</div>
            <div id="warnsize">Your file is very big. We can't accept it. Please select more small file</div>

            <div id="progress_info">
                <div id="progress"></div>
                <div id="progress_percent"> </div>
                <div class="clear_both"></div>
                <div>
                    <div id="speed"> </div>
                    <div id="remaining"> </div>
                    <div id="b_transfered"> </div>
                    <div class="clear_both"></div>
                </div>
                <div id="upload_response"></div>
            </div>
        </form>

        <img id="preview" />
    </div>
</div>
<script src="{{asset('/js/image-uploader.js')}}"></script>
</body>
</html>