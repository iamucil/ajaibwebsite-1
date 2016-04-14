@extends('layouts.blank')
@section('content')
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="menuLabelModal">Select Path</h4>
    </div>
    <div class="modal-body">
        <table class="table">
            <thead>
                <tr>
                    <th>
                        Route Name
                    </th>
                    <th>
                        URI
                    </th>
                    <th>
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($routes as $route)
                    <tr>
                        <td>{{ $route['name'] }}</td>
                        <td>
                            {{ $route['uri'] }}
                        </td>
                        <td>
                            <a href="#" class="btn btn-default" onclick="setRoute('{{ $route['name'] }}'); $(this).preventDefault();"><i class="glyphicon glyphicon-check"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" align="center">Empty</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
    <script type="text/javascript">
    var setRoute = function (name) {
        $('input:text[name="route"]').val(name);
        $('#menusModal').modal('hide');
    }
    </script>
@stop