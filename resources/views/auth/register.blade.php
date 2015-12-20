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

                                @include('common.errors')

                                <form method="post" action="/auth/register" name="frm-register" id="form-register" novalidate>
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="control-label">Email address</label>
                                        <input type="email" class="form-control" id="exampleInputName2" placeholder="Alamat email anda" name="email" value="{{ old('email') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1" class="control-label">Phone Number</label>
                                        <input type="text" class="form-control" id="exampleInputEmail2" placeholder="+62" name="phone_number" value="{{ old('phone_number') }}">
                                    </div>
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

@section('script-bottom')
    @parent
    <script type="text/javascript">
        var errors      = new Array();
        @if (count($errors) > 0)
            var errors  = {!! $errors !!}
        @endif

        $.each(errors, function ( index, value) {
            var elSpanError     = document.createElement('span');
            elSpanError.classList.add('glyphicon', 'glyphicon-remove', 'form-control-feedback');
            elSpanError.setAttribute('aria-hidden', true);
            var elSpanStatus    = document.createElement('span');
            elSpanStatus.classList.add('sr-only');
            elSpanStatus.innerHTML  = '(error)';
            var parentIndex     = $('input[name="'+index+'"]').parent();
            parentIndex.children('.control-label').css('font-weight', 'bold');
            parentIndex.addClass('has-error has-feedback');
            parentIndex.append(elSpanError, elSpanStatus);
        });
    </script>
@endsection