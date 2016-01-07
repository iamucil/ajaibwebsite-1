@extends('layouts.dashboard');
@section('title')
    Menu Management
@stop

@section('content')
{{ $data->getContent() }}
{{--     @forelse ($menus as $menu)
        {{ $menu->name }}
    @empty
        Belum Ada data menu
    @endforelse --}}
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