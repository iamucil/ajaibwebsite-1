@extends('layouts.default')
@section('title', 'Account Register')

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

                                <form method="post" action="/auth/register" name="frm-register" id="form-register" novalidate name="form-register" id="form-register">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="control-label">Email address</label>
                                        <input type="email" class="form-control" id="exampleInputName2" placeholder="Alamat email anda" name="email" value="{{ old('email') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1" class="control-label">Phone Number</label>
                                        <div class="clearfix"></div>
                                        <div class="input-group">
                                            <div class="input-group-addon" id="call-code-label" style="background-color: #eee; "><strong>62</strong></div>
                                            <input type="text" class="form-control" id="exampleInputEmail2" placeholder="" name="phone_number" value="{{ old('phone_number') }}">
                                        </div>
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
        var url         = '{!! url("/geo-ip") !!}';
        $.getJSON( url, function( data ) {
            var form        = document.forms['form-register'];
            var call_code   = document.createElement('span');
            call_code.style.fontWeight  = 'bold';
            call_code.innerHTML         = data.call_code;
            var inpCountryId            = document.createElement('input');
            inpCountryId.type           = 'hidden';
            inpCountryId.value          = data.country_id;
            inpCountryId.name           = 'country_id';
            document.getElementById('call-code-label').innerHTML    = '';
            document.getElementById('call-code-label').appendChild(call_code);
            form.appendChild(inpCountryId);
        }, 'json');
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