@extends('layouts.dashboard')
@section('title', 'Roles and Permission')
@section('content')
<div class="box">
    <div class="box-header bg-transparent">
        <h3 class="box-title">
            <i class="icon-menu"></i>
            <span>
                Daftar Roles
            </span>
        </h3>
        <div class="pull-right box-tools">
            <span class="box-btn" data-widget="collapse">
                <i class="icon-minus"></i>
            </span>
        </div>
    </div>
    <div class="box-body">
        @if (Auth::user()->hasRole(['root']))
            <div class="row">
                <div class="col-md-4 col-md-offset-8">
                    <div class="pull-right">
                        <a href="{{ URL::route('roles.create') }}" class="btn btn-success">
                            <i class="fa fa-plus"></i> Tambah Data
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>
                        Name
                    </th>
                    <th>
                        Display Name
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
                @if (empty($roles))
                    <tr>
                        <td colspan="3" align="center">
                            <strong>Data Not Available</strong>
                        </td>
                    </tr>
                @else
                    @foreach ($roles as $role)
                        <tr>
                            <td>
                                {{ $role->name }}
                            </td>
                            <td>
                                {{ $role->display_name }}
                            </td>
                            <td>
                                {{ $role->description }}
                            </td>
                            <td>
                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-default">
                                    <i class="glyphicon glyphicon-pencil"></i> Edit
                                </a>
                                <a href="{{ route('roles.show', $role->id) }}" class="btn btn-default">
                                    <i class="glyphicon glyphicon-share"></i> Assign Role
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection