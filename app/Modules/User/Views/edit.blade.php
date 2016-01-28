@extends('layouts.dashboard')

@section('title')
    Update Profile
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
                    Update Profile User
                </span>
            </h3>
        </div>
        <div class="box-body">
            <form class="form-horizontal" method="post" action="{{ route('user.update', $user->id) }}" name="frm-user-create" id="frm-user-create" novalidate="true">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label for="input-retype-password" class="col-sm-2 control-label">Real Name</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="input-retype-password" placeholder="" name="firstname" value="{{ old('firstname', $user->firstname) }}">
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="input-retype-password" placeholder="" name="lastname" value="{{ old('lastname', $user->lastname) }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-email" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-4">
                        <input type="email" class="form-control" id="input-email" placeholder="Email" name="email" value="{{ old('email', $user->email) }}" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-address" class="col-sm-2 control-label">Kota</label>
                    <div class="col-sm-4">
                        <input type="hidden" name="country_id" value="{{ old('country_id', $user->country->id) }}" />
                        <input type="hidden" name="country_name" value="{{ old('country_name', $user->country->name) }}" />
                        <input type="text" class="typehead" id="country" value="{{ old('country_name', $user->country->name) }}" autocomplete="off" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-address" class="col-sm-2 control-label">Alamat</label>
                    <div class="col-sm-4">
                        <textarea class="form-control" id="input-address" name="address" rows="4">{{ old('address', $user->address) }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-phone_number" class="col-sm-2 control-label">Nomor Telepon</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="input-retype-password" placeholder="" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" readonly>
                        <span id="helpBlock" class="help-block">ex: 85600000000.</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-gender" class="col-sm-2 control-label">Jenis Kelamin</label>
                    <div class="col-sm-4">
                        <div class="radio">
                            <label>
                                <input type="radio" name="gender" value="male" {{ request()->old('gender', $user->gender) == 'male' ? 'checked' : '' }}> Laki-laki
                            </label>
                            <label>
                                <input type="radio" name="gender" value="female" {{ request()->old('gender', $user->gender) == 'female' ? 'checked' : '' }}> Perempuan
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
@endsection

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