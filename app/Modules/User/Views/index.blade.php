@extends('layouts.dashboard')

@section('title')
    List Users
@stop

@section('content')
<div class="box">

    <div class="box-header bg-transparent">
        <h3 class="box-title">
            <i class="icon-menu"></i>
        <span>
            Users
        </span>
        </h3>

        <div class="pull-right box-tools">
        <span class="box-btn" data-widget="collapse">
            <i class="icon-minus"></i>
        </span>
        </div>
    </div>
    <div class="box-body">
        @if (Auth::user()->hasRole(['root', 'admin']))
            <div class="row">
                <div class="col-md-4 col-md-offset-8">
                    <div class="pull-right">
                        <a href="{{ URL::route('user.add') }}" class="btn btn-success">
                            <i class="fa fa-plus"></i> Tambah Data
                        </a>
                    </div>
                </div>
            </div>
        @endif
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        User Name
                    </th>
                    <th>
                        Email
                    </th>
                    <th>
                        Phone Number
                    </th>
                    <th>
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                {{--*/ $nomor = 1 /*--}}
                @forelse ($users as $user)
                    <tr>
                        <td align="center">
                            {{ $nomor }}
                        </td>
                        <td>
                            {{ $user->name }}
                        </td>
                        <td>
                            {{ $user->email }}
                        </td>
                        <td>
                            {{ $user->phone_number }}
                        </td>
                        <td>
                            <a href="{{ route('user.profile', $user->id) }}" class="btn btn-default" title="User Profile">
                                <i class="glyphicon glyphicon-user"></i>
                            </a>

                            @unless ((bool)$user->status === true)
                                <form action="{{ route('user.setactive', $user->id) }}" method="POST" class="inline">
                                    {{ csrf_field() }}

                                    {{ method_field('PUT') }}
                                    <button class="btn btn-success" id="btn-approval">
                                        <i class="glyphicon glyphicon-floppy-saved"></i>
                                    </button>
                                </form>
                            @endunless

                            @unless ($user->roles->count())
                                <a href="#" class="btn btn-default" title="assign role">
                                    <i class="glyphicon glyphicon-share"></i>
                                </a>
                            @endunless

                            @if (!$user->hasRole(['root', 'admin']) OR $user->roles->count() <= 0)
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="inline">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button class="btn btn-danger" id="btn-delete" type="submit">
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    {{--*/ $nomor++ /*--}}
                @empty
                    <tr>
                        <td colspan="5" align="center" class="info">
                            No Users
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <nav class="pagination">
        {!! $users !!}
    </nav>
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