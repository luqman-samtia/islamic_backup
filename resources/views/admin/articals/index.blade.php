@extends('adminlte::page')

@section('title', 'Articles')

@section('content_header')
    <h1>
        Articles
        <a href="{{ route('articals.add') }}" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus"></i> New Article</a>
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
                            <td>Title</td>
{{--                            <td>Image</td>--}}
                            <td>Action</td>
                        </tr>
                        </thead>
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
    <script>
        // $(function() {
            var datatable = $('.table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('articals') !!}',
                columns: [
                    { data: 'title' },
                    {
                        data: 'id',
                        render: function(data){
                            let edit = '{{ route('articals.edit', ':id') }}';
                            edit = edit.replace(':id', data);
                            let deleteArtical = '{{ route('articals.delete', ':id') }}';
                            deleteArtical = deleteArtical.replace(':id', data);
                            return '<a href="'+edit+'" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></a> ' +
                                '<button type="button" data-id="'+data+'" class="btn btn-danger btn-xs delete"><i class="fa fa-trash-o"></i></button> ';
                        }
                    },
                ]
            });
        // });
        $(document).on('click', '.delete', function(){
            let id = $(this).attr('data-id');
            $.ajax({
                url : "{{ route('articals.delete') }}",
                data: 'id='+id+"&_token={{ csrf_token() }}&parent=1",
                type:"post",
                success: function(output){
                    datatable.ajax.reload();
                }
            });
        })
    </script>
    @endpush