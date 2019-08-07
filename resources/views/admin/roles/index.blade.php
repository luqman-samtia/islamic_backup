@extends('adminlte::page')

@section('title', 'Manage Roles')

@section('content_header')
    <h1>
        Manage Roles
        @if(auth()->user()->can('roles.add'))
            <a href="{{ route('roles.add') }}" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus"></i> New Role</a>
        @endif
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
                            <th>Permissions</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>{{ implode(' | ', $role->getPermissionNames()->toArray()) }}</td>
                                <td>
                                    @if($role->name != 'SuperAdmin')
                                        @if(auth()->user()->can('rolecontroller.permissions'))
                                            <a title="Assign Permissions" href="{{ route('roles.permissions', $role->id) }}" class="btn btn-info btn-xs assignPermissions" data-loading-text="<i class='fa fa-spinner fa-spin'></i>"><i class="fa fa-lock"></i> </a>
                                        @endif
                                        @if(auth()->user()->can('rolecontroller.edit'))
                                            <a title="Edit Role" href="{{ route('roles.edit', $role->id) }}" class="btn btn-success btn-xs"><i class="fa fa-pencil-square-o"></i> </a>
                                        @endif
                                        @if(auth()->user()->can('rolecontroller.delete'))
                                            <a title="Delete Role" href="{{ route('roles.delete', $role->id) }}" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> </a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        @if(!$roles)
                        <tr>
                            <td colspan="3" class="text-center">No Record Found!</td>
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
        $(document).on('click', '.assignPermissions', function(e){
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