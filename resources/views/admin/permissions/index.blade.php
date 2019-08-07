@extends('adminlte::page')

@section('title', 'Manage Permissions')

@section('content_header')
    <h1>
        Manage Permissions
        @if(auth()->user()->can('permissions.add'))
            <a href="{{ route('permissions.add') }}" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus"></i> New Permission</a>
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
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($permissions as $permission)
                            <tr>
                                <td>{{ $permission->name }}</td>
                                <td>{{ implode(', ', $permission->getRoleNames()->toArray()) }}</td>
                                <td>
                                    @if(auth()->user()->can('permissioncontroller.roles'))
                                        <a title="Assign Roles" href="{{ route('permissions.roles', $permission->id) }}" class="btn btn-info btn-xs assignRoles" data-loading-text="<i class='fa fa-spinner fa-spin'></i>"><i class="fa fa-lock"></i> </a>
                                    @endif
                                    @if(auth()->user()->can('permissioncontroller.edit'))
                                        <a title="Edit Permission" href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-success btn-xs"><i class="fa fa-pencil-square-o"></i> </a>
                                    @endif
                                    @if(auth()->user()->can('permissioncontroller.delete'))
                                        <a title="Delete Permission" href="{{ route('permissions.delete', $permission->id) }}" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        @if(!$permissions)
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
        $(document).on('click', '.assignRoles', function(e){
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