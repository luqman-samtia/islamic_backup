@extends('adminlte::page')


@section('title', 'Islamic Scholars')

@section('content_header')
<!-- Add SweetAlert CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <h1>
        Islamic Scholars
        <a href="{{ route('scholars.add') }}" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus"></i> New Scholars</a>
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
                            <td>Email</td>
                            <td>Salary</td>
                            <td>Phone</td>
                            <td>Address</td>
                            <td>CNIC</td>
                            <td>Notes</td>
                            <td>Image</td>
                            <td>Order</td>
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
                ajax: '{!! route('scholars') !!}',
                columns: [
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'salary' },
                    { data: 'phone' },
                    { data: 'address' },
                    { data: 'cnic' },
                    { data: 'notes' },
                    {
                        data: 'image',
                        render: function(data, type, row){
                            if(row.image_url)
                                return '<img src="'+row.image_url+'" style="width: 50px;height: 50px;">';
                            return'';
                        }
                    },
                    { data: 'sort' },
                    {
                        data: 'id',
                        render: function(data){
                            let edit = '{{ route('scholars.edit', ':id') }}';
                            edit = edit.replace(':id', data);
                            let deleteScholars = '{{ route('scholars.delete', ':id') }}';
                            deleteScholars = deleteScholars.replace(':id', data);
                            return '<a href="'+edit+'" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></a> ' +
                                '<button type="button" data-id="'+data+'" class="btn btn-danger btn-xs delete"><i class="fa fa-trash-o"></i></button> ';
                        }
                    },
                ],
                order: [[2, 'desc']]
            });
        // });

        // old delete code>>>>>>>>>>>>>>>>>>>>>

        // $(document).on('click', '.delete', function(){
        //     let id = $(this).attr('data-id');
        //     $.ajax({
        //         url : "{{ route('scholars.delete') }}",
        //         data: 'id='+id+"&_token={{ csrf_token() }}&parent=1",
        //         type:"post",
        //         success: function(output){
        //             datatable.ajax.reload();
        //         }
        //     });
        // })
        $(document).on('click', '.delete', function(){
    let id = $(this).attr('data-id');
    
    Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url : "{{ route('scholars.delete') }}",
                data: 'id='+id+"&_token={{ csrf_token() }}&parent=1",
                type: "post",
                success: function(output){
                    Swal.fire(
                        'Deleted!',
                        'The scholar has been deleted.',
                        'success'
                    );
                    datatable.ajax.reload();
                }
            });
        }
    });
});

    </script>
    @endpush