@extends('layouts.dashboard')
@section('title')
    Vendor Categories
@stop

@section('content')
<div class="box">
    <div class="box-header bg-transparent">
        <!-- tools box -->
        <div class="pull-right box-tools">
            <span class="box-btn" data-widget="collapse">
                <i class="icon-minus"></i>
            </span>
            <span class="box-btn" data-widget="remove">
                <i class="icon-cross"></i>
            </span>
        </div>
        <h3 class="box-title">
            <i class="fontello-th-large-outline"></i>
            <span>Vendor Category</span>
        </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body " style="display: block;">
        <table class="table">
            <thead>
                <th>
                    #
                </th>
                <th>
                    Nama
                </th>
                <th>
                    Deskripsi
                </th>
                <th>
                    Aksi
                </th>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>

                        </td>
                        <td>
                            {{ $category->name }}
                        </td>
                        <td>
                            {{ $category->description }}
                        </td>
                        <td>
                            {{ $category->vendors->count }}
                        </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="4">
                        <center>
                            Data Kosong
                        </center>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $categories }}
    </div>
</div>
@stop