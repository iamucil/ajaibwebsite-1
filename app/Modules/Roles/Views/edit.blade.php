@extends('layouts.dashboard')
@section('title')
    {{ $title }}
@stop

@section('content')
    <div class="box">
        <div class="box-header bg-transparent">
            <h3 class="box-title"><i class="icon-menu"></i><span>Edit Role</span></h3>
        </div>
        <div class="box-body">
            <form action="{{ route('roles.update', $role->id) }}" method="POST" enc-type="multipart/form-data" class="form-horizontal">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">
                        Name
                    </label>
                    <div class="col-sm-4">
                        <label style="font-weight: bold;" class="form-control-static">
                            {{ old('name', $role->name) }}
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputDisplayName" class="col-sm-2 control-label">
                        Display Name
                    </label>
                    <div class="col-sm-6">
                        <input type="text" name="display_name" class="form-control" id="inputDisplayName" placeholder="Display Name" value="{{ old('diplay_name', $role->display_name) }}" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputDescription" class="col-sm-2 control-label">
                        Description
                    </label>
                    <div class="col-sm-6">
                        <textarea name="description" id="inputDescription" class="form-control" rows="3">{{ old('description', $role->description) }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">
                            <i class="glyphicon glyphicon-plus-sign"></i> Tambah
                        </button>
                        <a href="{{ route('roles.index') }}" class="btn btn-default">
                            <i class="glyphicon glyphicon-floppy-remove"></i> Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop