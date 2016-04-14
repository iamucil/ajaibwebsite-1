@extends('layouts.dashboard')

@section('title')
    Menu Create
@stop

@section('content')
    <div class="box bg-white">
        <div class="box-body pad-forty" style="display: block;">
            <form class="form-horizontal" novalidate="true" method="post" action="{{ route('menus.store') }}" enctype="mutipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="select-role" class="col-sm-2 control-label">
                        Select a Role
                    </label>

                    <div class="col-sm-2">
                        {!! Form::select('role_id', $roles, old('role_id'), ['placeholder' => 'Pick a role...', 'class' => 'form-control', 'id' => 'select-roles']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <label>
                                <input type="hidden" name="set_parent" value="0" />
                                <input type="checkbox" name="set_parent" value="1" @unless ($request->set_parent == 0) checked="true" @endunless> Check me out as parent Menu
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="parent-menu-wrapper">
                    <label class="col-sm-2 control-label">
                        Parent Menu
                    </label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="hidden" name="parent_id" value="{{ old('parent_id', 0) }}">
                            <input type="text" name="parent_name" class="form-control" aria-describedby="sizing-addon2" readonly value="{{ old('parent_name') }}" />
                            <a class="input-group-addon" id="sizing-addon2" data-toggle="modal" data-target="#menusModal" data-whatever="@getbootstrap" href="{{ route('parent_menu') }}">
                                <i class="glyphicon glyphicon-search"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="txt-name" class="col-sm-2 control-label">
                        Name
                    </label>
                    <div class="col-sm-4">
                        <input type="text" name="name" id="txt-name" value="{{ old('name') }}" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="menu-icon" class="col-sm-2 control-label">
                        Icon
                    </label>
                    <div class="col-sm-4">
                        {{-- glyphicon glyphicon-th --}}
                        <div class="input-group">
                            <input type="text" name="icon" id="menu-icon" value="{{ old('icon') }}" class="form-control" aria-describedby="helpBlock">
                            <a class="input-group-addon" id="sizing-addon2" data-toggle="modal" data-target="#menusModal" data-whatever="@getbootstrap" href="{{ route('icons-pack') }}">
                                <i class="glyphicon glyphicon-th"></i>
                            </a>
                        </div>
                        <span id="helpBlock" class="help-block">
                            Checkout icon on <a href="http://fontello.com/" target="_blank">fontello icon pack site here</a>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        Path
                    </label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <input type="text" name="route" class="form-control" aria-describedby="sizing-addon2" readonly />
                            <a class="input-group-addon" id="sizing-addon2" data-toggle="modal" data-target="#menusModal" data-whatever="@getbootstrap" href="{{ route('route-list') }}">
                                Load Route List
                            </a>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        Description
                    </label>
                    <div class="col-sm-6">
                        <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i>
                            Simpan
                        </button>
                        <a href="{{ route('menus.index') }}" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-remove"></i> Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- modal box --}}
    <div class="modal fade" id="menusModal" tabindex="-1" role="dialog" aria-labelledby="menuLabelModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

            </div>
        </div>
    </div>
@stop

@section('script-bottom')
    @parent

    <script type="text/javascript">
        var toggleParentMenu    = function (el) {
            if ($(el).prop('checked')) {
                $('#parent-menu-wrapper').show();
            } else {
                $('input:hidden[name="parent_id"]').val('');
                $('input:text[name="parent_name"]').val('');
                $('#parent-menu-wrapper').hide();
            }
        }
        $('input[name="set_parent"]').change(function () {
            toggleParentMenu($(this));
        });
        toggleParentMenu($('input:checkbox[name="set_parent"]'));

        $('#menusModal').on('show.bs.modal', function (event) {
            var button      = $(event.relatedTarget);
            var url         = button.attr('attr');
            var modal       = $(this);
            // console.log(modal)
            // modal.load('.modal-content', url);
        }).on('hide.bs.modal', function (event) {
            var modal   = $(this);
            $(this).removeData('bs.modal');
        });
    </script>
@stop