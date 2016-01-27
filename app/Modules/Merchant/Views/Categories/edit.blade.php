@extends('layouts.dashboard')

@section('title')
    Vendor Category - Update
@stop

@section('content')
<div class="box bg-white">
    <div class="box-body pad-forty" style="display: block;">
        <form class="form-horizontal" novalidate="true" method="post" action="{{ route('vendor.category.update', $category->id) }}" enctype="mutipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">Nama</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="inputName" placeholder="nama" name="name" value="{{ old('name', $category->name) }}">
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-group">
                <label for="inputDeskripsi" class="col-sm-2 control-label">Deskripsi</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="inputDeskripsi" placeholder="Deskripsi" name="description" value="{{ old('description', $category->description) }}">
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Simpan</button>
                    <a href="{{ route('vendor.category.index') }}" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-remove"></i> Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@stop