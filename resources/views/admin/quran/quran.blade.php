@extends('adminlte::page')

@section('title', $quran->title)

@section('content_header')
    <h1>
        {{ $quran->title }}
        <a href="{{ route('quran.child.add', $quran->id) }}" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus"></i> Add New </a>
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
                            <td>Page #</td>
                            <td>Title</td>
                            <td>Image</td>
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
                ajax: '{!! route('quran.quran', $quran->id) !!}',
                columns: [
                    { data: 'number' },
                    { data: 'title' },
                    {
                        data: 'image',
                        render: function(data, type, row){
                            if(row.image_url)
                                return '<img src="'+row.image_url+'" style="width: 50px;height: 50px;">';
                            return'';
                        }
                    },
                    {
                        data: 'id',
                        render: function(data, type , row)
                        {
                            let edit = '{{ route('child.edit', [':id', ':id2']) }}';
                            edit = edit.replace(':id', row.parent_id);
                            edit = edit.replace(':id2', data);

                            let deleteQuran = '{{ route('quran.delete', ':id') }}';
                            deleteQuran = deleteQuran.replace(':id', data);
                            return '<a href="'+edit+'" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></a> ' +
                                // '<a href="'+edit+'" class="btn btn-primary"><i class="fa fa-plus-square"></i></a> ' +
                                '<button type="button" data-id="'+data+'" class="btn btn-danger btn-xs delete"><i class="fa fa-trash-o"></i></button> ';
                        }
                    },
                ]
            });
        // });
        $(document).on('click', '.delete', function(){
            let id = $(this).attr('data-id');
            $.ajax({
                url : "{{ route('quran.delete') }}",
                data: 'id='+id+"&_token={{ csrf_token() }}",
                type:"post",
                success: function(output){
                    datatable.ajax.reload();
                }
            });
        })
    </script>
    @endpush