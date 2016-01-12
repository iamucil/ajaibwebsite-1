@extends('layouts.dashboard')
@section('title')
    User :: Add
@stop

@section('script-lib')
    @parent
    <script type="text/javascript" src="{{ secure_asset('/js/vendor/bootstrap3-typeahead.min.js') }}"></script>
@stop

@section('content')
    <div class="box">
        <div class="box-header bg-transparent">
            <h3 class="box-title">
                <i class="icon-menu"></i>
                <span>
                    Create User
                </span>
            </h3>
        </div>
        <div class="box-body">
            <form class="form-horizontal" method="post" action="{{ route('user.store') }}" name="frm-user-create" id="frm-user-create" novalidate="true">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="select-role" class="col-sm-2 control-label">
                        Select a Role
                    </label>
                    <div class="col-sm-2">
                        {!! Form::select('role_id', $roles, null, ['placeholder' => 'Pick a role...', 'class' => 'form-control', 'id' => 'select-role']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-retype-password" class="col-sm-2 control-label">Real Name</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="input-retype-password" placeholder="" name="firstname" value="{{ old('firstname') }}">
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="input-retype-password" placeholder="" name="lastname" value="{{ old('lastname') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-name" class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="input-name" placeholder="User Name" name="name" value="{{ old('name') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-email" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-4">
                        <input type="email" class="form-control" id="input-email" placeholder="Email" name="email" value="{{ old('email') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-password" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" id="input-password" placeholder="Password" name="password">
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-retype-password" class="col-sm-2 control-label">Retype Password</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" id="input-retype-password" placeholder="" name="retype-password">
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-phone_number" class="col-sm-2 control-label">Nomor Telepon</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="input-retype-password" placeholder="" name="phone_number">
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-address" class="col-sm-2 control-label">Kota</label>
                    <div class="col-sm-4">
                        <input type="hidden" name="country_id" value="{{ old('country_id') }}" />
                        <input type="hidden" name="country_name" value="{{ old('country_name') }}" />
                        <input type="text" class="typehead" id="country" value="{{ old('country_name') }}" autocomplete="off" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-address" class="col-sm-2 control-label">Alamat</label>
                    <div class="col-sm-4">
                        <textarea class="form-control" id="input-address" name="address" rows="4"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-gender" class="col-sm-2 control-label">Jenis Kelamin</label>
                    <div class="col-sm-4">
                        <div class="radio">
                            <label>
                                <input type="radio" name="gender" value="male"> Laki-laki
                            </label>
                            <label>
                                <input type="radio" name="gender" value="female"> Perempuan
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Simpan</button>
                        <button type="Reset" class="btn btn-default">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script-bottom')
    @parent
    <script type="text/javascript">
        $input          = $('.typeahead');
        $country_id     = $("input[name='country_id']");
        $country_name   = $("input[name='country_name']");
        var url     = '{{ route("country.list") }}';
        $.getJSON( url, function( data ) {
            $("#country").typeahead({
                source:data,
                updater: function (item) {
                    return item;
                },
                afterSelect: function(item){
                    $input.val(item.name);
                    $country_id.val(item.id);
                    $country_name.val(item.name);
                    // console.log(item);
                }
            });
        }, 'json');
    </script>
@stop