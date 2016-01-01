@extends('layouts.dashboard')
@section('title')
    Generate Oauth Credentials
@stop

@section('content')
<div class="box">
    <div class="box-header bg-transparent">
        <h3 class="box-title">
            <i class="icon-menu"></i>
        <span>
            Client
        </span>
        </h3>

        <div class="pull-right box-tools">
        <span class="box-btn" data-widget="collapse">
            <i class="icon-minus"></i>
        </span>
        </div>
    </div>
    <div class="box-body">
        <form class="form-horizontal" name="frm-credential" id="frm-credential" method="POST" action="{{ route('oauth.store') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="inputName" name="name">
                </div>
                <div class="col-sm-1">
                    <button class="btn btn-success" data-toggle="tooltip" data-placement="right" title="Generate Credentials" name="generate-credentials" id="btn-credential">
                        <i class="glyphicon glyphicon-refresh"></i>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label for="inputClientId" class="col-sm-2 control-label">ID</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="inputClientId" placeholder="CLIENT ID" name="id" readonly>
                </div>
            </div>

            <div class="form-group">
                <label for="inputClientKey" class="col-sm-2 control-label">KEY</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="inputClientKey" placeholder="CLIENT SECRET" name="secret" readonly>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-floppy-save"></i> Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('script-bottom')
    @parent
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();

            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });

            $('button#btn-credential').bind('click', function (event){
                // console.log(event);
                var form        = this.form;
                var client_name = form.name;
                var parent      = client_name.closest("div.form-group");
                $(parent).removeClass (function (index, css) {
                    return (css.match (/(^|\s)has-\S+/g) || []).join(' ');
                });
                if(client_name.value == ''){
                    $(parent).addClass('has-error');
                    $(parent).find('.help-block').remove();
                    $('<span class="help-block">Please fill the data</span>').insertAfter($(client_name));
                    client_name.focus();
                    form.id.value       = '';
                    form.secret.value   = '';
                }else{
                    var request = $.ajax({
                        url: "{{ route('oauth.credentials.post') }}",
                        method: "POST",
                        data: { name : client_name.value },
                        dataType: 'json'
                    });

                    request.done(function (data) {
                        if (data.exists == true){
                            $(parent).addClass('has-error');
                            $(parent).find('.help-block').remove();
                            $('<span class="help-block">Client Name is already registerd in system. Try another</span>').insertAfter($(client_name));
                            client_name.focus();
                            form.id.value       = '';
                            form.secret.value   = '';
                        }else{
                            form.id.value       = data.client_id;
                            form.secret.value   = data.client_secret;
                        }
                    });

                    request.fail(function( jqXHR, textStatus ) {
                        console.log(jqXHR.responseText);
                    });
                }
                return false;
            });

            $('input[name="name"').bind('keyup', function(event) {
                var parent      = this.closest("div.form-group");
                var form        = this.form;
                $(parent).removeClass (function (index, css) {
                    return (css.match (/(^|\s)has-\S+/g) || []).join(' ');
                });
                $(parent).find('.help-block').remove();
                form.id.value       = '';
                form.secret.value   = '';
                return true;
            });
        });
    </script>
@stop