@extends('adminlte::page')

@section('title', 'Manage Users')

@section('content_header')
    <h1>
        Manage Users
        <a href="{{ route('users.add') }}" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus"></i> New User</a>
    </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-body table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ implode(',', $user->getRoleNames()->toArray()) }}</td>
                                <td>
                                    @if(!$user->hasRole('SuperAdmin'))
                                        @if(auth()->user()->can('usercontroller.role'))
                                        <a title="Manage Role" href="{{ route('users.role', $user->id) }}" class="btn btn-info btn-xs manageRole" data-loading-text="<i class='fa fa-spinner fa-spin'></i>"><i class="fa fa-lock"></i> </a>
                                        @endif
                                        @if(auth()->user()->can('usercontroller.edit'))
                                        <a title="Edit User" href="{{ route('users.edit', $user->id) }}" class="btn btn-success btn-xs"><i class="fa fa-pencil-square-o"></i> </a>
                                        @endif
                                        @if(auth()->user()->can('usercontroller.delete'))
                                        <a title="Delete User" href="{{ route('users.delete', $user->id) }}" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> </a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        @if(!$user)
                        <tr>
                            <td class="text-center">No Record Found!</td>
                        </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
    <div class="rolesModal"></div>
@stop

@push('js')
    <script !src="">
        $(document).on('click', '.manageRole', function(e){
            e.preventDefault();
            let url = $(this).attr('href');
            let btn = this;
            $(btn).button('loading');
            $.ajax({
                url: url,
                dataType:"json",
                success:function(output){
                    $('.rolesModal').html(output.html);
                    $('#rolesModal').modal('show');
                    $(btn).button('reset');
                }
            })
        });
    </script>
@endpush