@extends('adminlte::page')


@section('title', ' Students')

@section('content_header')
<!-- Add SweetAlert CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <h1>
        Students
        {{-- <a href="{{ route('scholars.add') }}" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus"></i> New Scholars</a> --}}
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
                            <td>Phone</td>
                            {{-- <td>Action</td> --}}
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
                ajax: '{!! route('scholars.students') !!}',
                columns: [
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'contact_no' },
                   
                ],
                order: [[2, 'desc']]
            });
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