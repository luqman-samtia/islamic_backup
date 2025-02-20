@extends('adminlte::page')

@section('title', 'Feedback')

@section('content_header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <h1>
        Feedback
        <a href="{{route('feedback.add')}}" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus"></i> New Feedback</a>
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
                ajax: '{!! route('student.feedback.submit') !!}',
                columns: [
                    { data: 'title' },
                    {
                        data: 'image',
                        render: function(data, type, row){
                            if(row.image_url)
                                return '<img src="'+row.image_url+'" style="width: 50px;height: 50px;">';
                            return'';
                        }
                    },
                    { data: 'feedback' },
                    {
                        data: 'id',
                        render: function(data){
                            let edit = '{!! route('feedback.edit', ':id') !!}';
                            edit = edit.replace(':id', data);
                            let deleteTestimonials = '';
                            deleteTestimonials = deleteTestimonials.replace(':id', data);
                            return '<a href="'+edit+'" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></a> ' +
                                '<button type="button" data-id="'+data+'" class="btn btn-danger btn-xs delete"><i class="fa fa-trash-o"></i></button> ';
                        }
                    },
                ],
                order: [[2, 'asc']]
            });
        // });
        $(document).on('click', '.delete', function(){
            let id = $(this).attr('data-id');
            $.ajax({
                url : "{{ route('feedback.delete') }}",
                data: 'id='+id+"&_token={{ csrf_token() }}&parent=1",
                type:"post",
                success: function(output){
                    datatable.ajax.reload();
                }
            });
        })
    </script>
    @endpush