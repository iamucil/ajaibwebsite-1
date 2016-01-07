@extends('layouts.dashboard')
@section('title')
    Menu Management
@stop

@section('script')
    @parent
@stop

@section('content')
    <div class="box">
        <div class="box-header bg-transparent">
            <h3 class="box-title">
                <i class="icon-menu"></i>
            <span>
                Menu Management
            </span>
            </h3>
        </div>
        <div class="box-body">
        </div>
    </div>
@stop

@section('script-bottom')
    @parent
    <script type="text/javascript">
    var menus   = {!! $data->getContent() !!};
    var geoloc  = [];
    jQuery.post('//freegeoip.net/json/', function (response) {
        console.log(response);
    }, 'jsonp');

    jQuery.getJSON('https://randomuser.me/api/?nat=us', function(response) {
        console.log(response.results[0].user.picture.thumbnail);
    });
    </script>
@stop

