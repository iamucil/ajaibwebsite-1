@extends('layouts.dashboard')

@section('title')
    {{ $title }}
@stop

@section('content')
    <div class="box">
        <div class="box-header bg-transparent">
            <h3 class="box-title">
                <i class="icon-menu"></i>
                <span>Roles {{ $role->name }}</span>
            </h3>
        </div>
        <div class="box-body">
            <table class="table table-grid">
                <thead>
                    <tr>
                        <th>
                            Email
                        </th>
                        <th style="width: 60px;">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if ($users->total() > 0)
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    @unless ($user->hasRole($role->name))
                                        <form action="{{ route('roles.attach', $role->id) }}" method="POST" class="frm-role">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="user_id" value="{{ $user->id }}" />
                                            <input type="hidden" name="role_id" value="{{ $role->id }}" />
                                            <button type="submit" id="attach-role-{{ $user->id }}" class="btn btn-default">
                                                <i class="glyphicon glyphicon-floppy-saved"></i>
                                            </button>
                                        </form>
                                    @endunless
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="pagination">  </div>
            {{-- {{ $users->total() }} --}}
            {{-- {{ $users->nextPageUrl() }} --}}
        </div>
    </div>
@stop

@section('script-bottom')
    @parent
    <script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $( 'form.frm-role' ).each (function () {
        $(this).submit(function(event){
            event.preventDefault();
            var form    = $(this);
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize()
            }).done(function(response, status, code){
                var btn_id     = response.data.user_id;
                $('button[type="submit"]#attach-role-'+btn_id).hide();

                console.log(response);
            });
            // console.log(form.attr('action'));
        })
    });
    $( "a.btn-attach-role" ).click(function(){
        // alert(this);
        $.ajax({
            url : "{{ route('roles.attach') }}",
            method:"POST",
            data : {'role_id' : {{ $role->id }} }
        }).done(function(data){
            console.log(data);

        });
    })
    </script>
@stop