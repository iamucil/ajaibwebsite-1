@extends('layouts.dashboard')
@section('title')
    Menu Management
@stop

@section('content')
{{--     @forelse ($menus as $menu)
        {{ $menu->name }}
    @empty
        Belum Ada data menu
    @endforelse --}}
@stop

@section('script-bottom')
    @parent
    <script type="text/javascript">
    var url     = '{!! url("/geo-ip") !!}';
    var menus   = {!! $data->getContent() !!};
    var geoloc  = [];
    // $.getJSON( url, function( data ) {
    //     console.log(data);
    // });
    // jQuery.post('//freegeoip.net/json/', function (response) {
    //     console.log(response);
    // }, 'jsonp');

    // jQuery.getJSON('https://randomuser.me/api/?nat=us', function(response) {
    //     console.log(response.results[0].user.picture.thumbnail);
    // });
    </script>
@stop