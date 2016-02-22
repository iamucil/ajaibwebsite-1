@extends('layouts.dashboard')
@section('title')
Transaction Categories
@stop

@section('content')
    <div class="box">
        <div class="box-header bg-transparent">
            <!-- tools box -->
            <div class="pull-right box-tools">
                <div class="btn-group" role="group" aria-label="...">
                    <a href="{{ route('transaction.category.create') }}" class="btn btn-default" role="button">
                        Tambah Kategori
                    </a>
                    <a class="btn btn-default" role="button" href="{{ route('transactions.index') }}">
                        Daftar Transaksi
                    </a>
                </div>
            </div>
            <h3 class="box-title">
                <i class="fontello-th-large-outline"></i>
                <span>Kategori Transaksi</span>
            </h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body " style="display: block;">
            <table class="table">
                <thead>
                <th style="width: 20px;">
                    #
                </th>
                <th style="width: ">
                    Nama
                </th>
                <th>
                    Deskripsi
                </th>
                <th style="width: 30px;">
                    Transaksi
                </th>
                <th style="width: 90px;">
                    Aksi
                </th>
                </thead>
                <tbody>
                {{--*/ $nomor   = $categories->currentPage() /*--}}
                @forelse ($categories as $category)
                    <tr>
                        <td>
                            {{ $nomor }}
                        </td>
                        <td>
                            {{ $category->name }}
                        </td>
                        <td>
                            @unless (!is_null($category->description))
                            &mdash;
                            @endunless
                            {{ $category->description }}
                        </td>
                        <td>
                            <a class="btn btn-success"
                               href="">
                                Transactions
                                <span class="badge">
                                    {{ $category->Transactions->count() }}
                                </span>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('transaction.category.edit', $category->id) }}" class="btn btn-default">
                                <i class="glyphicon glyphicon-pencil"></i>
                            </a>
                            @if ($category->Transactions->count() > 0)
                                <a class="btn btn-default btn-danger" disabled="disabled" href="#" role="button">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </a>
                            @else
                                <form action="{{ route('transaction.category.destroy', $category->id) }}" method="POST"
                                      class="inline">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button class="btn btn-danger" id="btn-delete" type="submit">
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    <?php $nomor++; ?>
                @empty
                    <tr>
                        <td colspan="5">
                            <center>
                                Data Kosong
                            </center>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{ $categories->render() }}
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