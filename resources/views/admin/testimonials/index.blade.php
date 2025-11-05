@extends('adminlte::page')

@section('title', 'Testimonials')

@section('content_header')
    <h1>
        Testimonials
        <a href="{{ route('testimonials.add') }}" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus"></i> New Testimonial</a>
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
                            <td>Name</td>
                            <td>Image</td>
                            <td>Description</td>
                            <td>Source Type</td>
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
        var datatable = $('.table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('testimonials') !!}',
            columns: [
                { data: 'name' },
                {
                    data: 'image_complete_url',
                    render: function(data, type, row){
                        if(data)
                            return '<img src="'+data+'" style="width: 50px;height: 50px;">';
                        return '';
                    }
                },
                { data: 'description' },
                {
                    data: 'source_type',
                    render: function(data){
                        const isStudent = data === 'Feedback';
                        return '<span class="label ' + (isStudent ? 'label-warning' : 'label-info') + '">' + 
                            (isStudent ? 'Student' : 'Admin') + '</span>';
                    }
                },
                {
                    data: 'id',
                    render: function(data, type, row){
                        let sourceType = row.source_type.toLowerCase();
                        let edit = '{{ route('testimonials.edit', ['id' => ':id', 'sourceType' => ':sourceType']) }}';
                        edit = edit.replace(':id', data).replace(':sourceType', sourceType);
                        
                        return '<a href="'+edit+'" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></a> ' +
                            '<button type="button" data-id="'+data+'" data-source="'+sourceType+'" class="btn btn-danger btn-xs delete"><i class="fa fa-trash-o"></i></button> ';
                    }
                },
            ],
            order: [[3, 'asc']]
        });

        $(document).on('click', '.delete', function(){
            let id = $(this).attr('data-id');
            let sourceType = $(this).attr('data-source');
            
            if(confirm('Are you sure you want to delete this record?')) {
                $.ajax({
                    url : "{{ route('testimonials.delete') }}",
                    data: {
                        id: id,
                        source_type: sourceType,
                        _token: '{{ csrf_token() }}'
                    },
                    type: "post",
                    success: function(output){
                        if(output.status === 200) {
                            datatable.ajax.reload();
                            alert(output.message);
                        } else {
                            alert('Error: ' + output.message);
                        }
                    },
                    error: function(xhr){
                        alert('Error deleting record');
                    }
                });
            }
        });
    </script>
@endpush