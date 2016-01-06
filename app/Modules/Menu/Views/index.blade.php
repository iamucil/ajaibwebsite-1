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
    var menus   = '{!! $data->getContent() !!}';
    console.log(menus);
    </script>
@stop