@extends('layouts.dashboard')

@section('title')
    Reset Password
@stop

@section('content')
    <div class="box">
        <div class="box-header bg-transparent">
            <h3 class="box-title">
                <i class="icon-menu"></i>
                <span>
                    Reset Password
                </span>
            </h3>
        </div>
        <div class="box-body">
            <form class="form-horizontal" method="POST" action="{{ route('users.do-reset-password') }}" name="frm-user-reset" id="frm-user-reset" novalidate="true">
                {{ csrf_field() }}
                <input type="hidden" name="user_id" value="{{ $user->id }}" />
                <div class="form-group">
                    <label for="current_password" class="col-sm-2 control-label">
                        Current Paswword
                    </label>
                    <div class="col-sm-4">
                        <input type="password" name="current_password"  id="current_password" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="old-password" class="col-sm-2 control-label">
                        Password
                    </label>
                    <div class="col-sm-4">
                        <input type="password" name="password"  class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="old-password" class="col-sm-2 control-label">
                        Retype Password
                    </label>
                    <div class="col-sm-4">
                        <input type="password" name="password_confirmation"  class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Simpan</button>
                        @if (auth()->user()->hasRole(['root', 'admin']))
                            <a href="{{ route('user.list') }}" class="btn btn-default">Batal</a>
                        @else
                            <a href="{{ route('admin::dashboard') }}" class="btn btn-default">Batal</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script-bottom')
    @parent
    <script type="text/javascript">
        $('form[name="frm-user-reset"').on('submit', function (evt) {
            var Form        = this;
            var $action     = Form.action;
            var $data       = {};
            $.each(this.elements, function(i, v){
                var input = $(v);
                $data[input.attr("name")] = input.val();
                delete $data["undefined"];
            });
            // console.log($action);
            $.ajax({
                cache: false,
                url : $action,
                type: "POST",
                dataType : "json",
                data : $data,
                context : Form,
                beforeSend: function (jqXHR, settings) {
                    return true;
                }
            }).done(function(data,  status, jqXHR) {
                alertify.success(data.message);
                setTimeout(function(){
                    window.location.assign(data.url);
                }, 3000);

            }).error(function(jqXHR, status, errors) {
                var $errors     = jqXHR.responseJSON;
                if(jqXHR.status == 422) {
                    $.each($errors, function ( index, value) {
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
                        alertify.error(value);
                    });
                }

                evt.preventDefault();
                return false;
            });

            evt.preventDefault();
        })
    </script>
@stop