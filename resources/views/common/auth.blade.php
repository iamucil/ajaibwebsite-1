@if (count($errors) > 0)
<div class="container">
    <div class="row"> </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="alert alert-info alert-labeled">
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">×</span><span class="sr-only">Close</span>
                </button>
                <div class="alert-labeled-row">
                    <span class="alert-label alert-label-left alert-labelled-cell">
                        <i class="glyphicon glyphicon-info-sign"></i>
                    </span>
                    <p class="alert-body alert-body-right alert-labelled-cell">
                        {{ $errors->first() }}
                    </p>

                </div>
            </div>


        </div>
    </div>
</div>
@endif