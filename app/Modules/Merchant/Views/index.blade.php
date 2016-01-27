@extends('layouts.dashboard')

@section('title')
    Daftar Vendor
@stop

@section('content')
<div class="box bg-white">
    <div class="box-header bg-transparent">
        <!-- tools box -->
        <div class="pull-right box-tools">
            <div class="btn-group" role="group" aria-label="...">
                <a href="{{ route('vendor.create') }}" class="btn btn-default" role="button">
                    Tambah Vendor
                </a>
                <a href="#" class="btn btn-default" role="button" href="vendor.category.index">
                    Daftar Kategori
                </a>
                {{-- <button type="button" class="btn btn-default">Tambah Kategory</button>
                <button type="button" class="btn btn-default">Daftar Vendor</button> --}}
                {{-- <button type="button" class="btn btn-default">Right</button> --}}
            </div>
        </div>
        <h3 class="box-title">
            <i class="fontello-th-large-outline"></i>
            <span>Vendor</span>
        </h3>
    </div>
    <div class="box-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 30px;">
                        #
                    </th>
                    <th style="width: 115px;">
                        Nama
                    </th>
                    <th style="width: 95px;">
                        Kategori
                    </th>
                    <th>
                        Deskripsi
                    </th>
                    <th style="width: 135px;">

                    </th>
                </tr>
            </thead>
            <tbody>
                {{--*/ $nomor   = $vendors->currentPage() /*--}}
                @forelse ($vendors as $vendor)
                    <tr>
                        <td>
                            {{ $nomor }}
                        </td>
                        <td>
                            {{ $vendor->name }}
                        </td>
                        <td>
                            <a href="{{ route('vendor.category.show', $vendor->category->id) }}">
                                {{ $vendor->category->name }}
                            </a>
                        </td>
                        <td>
                            {{ $vendor->description }}
                        </td>
                        <td>
                            <a href="{{ route('vendor.edit', $vendor->id) }}" class="btn btn-default">
                                <i class="glyphicon glyphicon-pencil"></i>
                            </a>
                            <a href="{{ route('vendor.show', $vendor->id) }}" class="btn btn-default">
                                <i class="glyphicon glyphicon-list-alt"></i>
                            </a>
                            <form action="{{ route('vendor.destroy', $vendor->id) }}" method="POST" class="inline">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button class="btn btn-danger" id="btn-delete" type="submit">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php $nomor++; ?>
                @empty
                    <tr>
                        <td colspan="5">
                            Data Kosong
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop

@section('script-bottom')
    @parent
    <script type="text/javascript">
        $('button#btn-delete').bind('click', function (event){
            var $form   = this.form;
            event.preventDefault();
            // return confirm(
            //     'Are you sure you wish to delete this recipe?'
            // );
            return alertify.confirm("Are you sure you wish to delete this recipe?", function (e) {
                if (e) {
                    $form.submit();
                } else {
                    // nothing happend
                }
            });
        })
    </script>
@stop