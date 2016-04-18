    <div class="box bg-white" ng-controller="TransactionCategoryController" ng-init="getShow()">
        <div class="box-header bg-transparent">            
            <h3 class="box-title">
                <i class="fontello-th-large-outline"></i>
                <span>Transaction Category - Details</span>
            </h3>
        </div>
        <div class="box-body pad-forty" style="display: block;">
            <div class="row">
                <div class="col-md-3">
                    <dl>
                        <dt>[[category.name]]</dt>
                        <dd>[[category.description != '' ? category.description : '&mdash;']]</dd>
                    </dl>                    
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>