@extends('layouts.blank')

@section('content')
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="menuLabelModal">Select Parent Menu</h4>
    </div>
    <div class="modal-body">
        <table class="table">
            <thead>
                <tr>
                    <th>
                        Name
                    </th>
                    <th>
                        Description
                    </th>
                    <th>
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($menus as $menu)
                    <tr>
                        <td>
                            {{ $menu->name }}
                        </td>
                        <td>
                            {{ $menu->description }}
                        </td>
                        <td>
                            <a href="javascript:void(0);" class="btn btn-default" onclick="setParent('{{ $menu->id }}', '{{ $menu->name }}'); $(this).preventDefault();"><i class="glyphicon glyphicon-check"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" align="center">Empty</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
    <script type="text/javascript">
        var setParent   = function (id, name) {
            $('input:hidden[name="parent_id"]').val(id);
            $('input:text[name="parent_name"]').val(name);
            $('#menusModal').modal('hide');
        }
    </script>
@stop