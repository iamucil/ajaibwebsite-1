@extends('layouts.dashboard')

@section('title')
    Vendor Category - Details
@stop

@section('content')
    <div class="box bg-white">
        <div class="box-body pad-forty" style="display: block;">
            <div class="row">
                <div class="col-md-3">
                    <dl>
                        <dt>{{ $category->name }}</dt>
                        <dd>@unless (!is_null($category->description))
                            &mdash;
                            @endunless {{ $category->description }}</dd>
                    </dl>
                    <form action="{{ route('vendor.category.destroy', $category->id) }}" method="POST" class="inline">
                        <div class="btn-group-vertical" role="group" aria-label="...">
                            <a class="btn btn-default btn-block" href="{{ route('vendor.category.index') }}">
                                Daftar Kategori
                            </a>
                            <a class="btn btn-default btn-block" href="{{ route('vendor.category.create') }}">
                                Tambah Kategori
                            </a>
                            <a class="btn btn-default btn-block" href="{{ route('vendor.index') }}">
                                Daftar Vendor
                            </a>
                            <a class="btn btn-default btn-block" href="{{ route('vendor.create') }}">
                                Tambah Vendor
                            </a>
                            @unless ($category->vendors->count() <> 0)
                                {{-- expr --}}
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button class="btn btn-danger" id="btn-delete" type="submit">
                                    Hapus Kategori <span class="badge"><i class="glyphicon glyphicon-trash"></i></span>
                                </button>
                            @endunless
                        </div>
                    </form>
                </div>
                <div class="col-md-9">
                    <table class="table table-condensed">
                        <thead>
                        <tr>
                            <th style="width: 30px;">
                                #
                            </th>
                            <th style="width: 115px;">
                                Nama
                            </th>
                            <th>
                                Deskripsi
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        {{--*/ $nomor   = 1 /*--}}
                        @forelse ($category->vendors as $vendor)
                            <tr>
                                <td>
                                    {{ $nomor }}
                                </td>
                                <td>
                                    {{ $vendor->name }}
                                </td>
                                <td>
                                    {{ $vendor->description }}
                                </td>
                            </tr>
                            <?php $nomor++; ?>
                        @empty
                            <tr>
                                <td colspan="3">
                                    Data Kosong
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script-bottom')
    @parent
    <script type="text/javascript">
        $('button#btn-delete').bind('click', function (event) {
            var $form = this.form;
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