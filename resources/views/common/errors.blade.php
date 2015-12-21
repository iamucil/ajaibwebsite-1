@if (count($errors) > 0)
<!-- notification -->
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p class="text-left text-uppercase">
               <strong class="text-left">Whoops! Something went wrong!</strong>

            </p>
            <ul class="list-unstyled">
               @foreach ($errors->all() as $error)
                   <li class="text-left">{{ $error }}</li>
               @endforeach
            </ul>
        </div>
    </div>
</div>
<!-- end of notification -->
@endif