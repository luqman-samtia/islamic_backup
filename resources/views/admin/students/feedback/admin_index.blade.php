@extends('adminlte::page')

@section('title', 'Feedback')

@section('content_header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <h1>Feedback for {{$student->name}}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-body table-responsive">
                    <table class="table table-hover table-striped table-bordered" id="feedbacksTable">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Description</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@stop

@push('js')
    <script>
        // $(document).ready(function() {
        //     var datatable = $('#feedbacksTable').DataTable({
        //         processing: true,
        //         serverSide: true,
        //         ajax: '{!! route('admin.feedback.show', $student->id) !!}',
        //         columns: [
        //             { data: 'title', name: 'title' },
        //             {
        //                 data: 'image_complete_url',
        //                 name: 'image_complete_url',
        //                 render: function(data) {
        //                     return data ? `<img src="${data}" class="img-thumbnail" width="50" height="50">` : 'No Image';
        //                 }
        //             },
        //             { data: 'feedback', name: 'feedback' }
        //         ],
        //         order: [[0, 'asc']]
        //     });
        // });

        $(document).ready(function() {
        var datatable = $('#feedbacksTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! route('admin.feedback.show', $student->id) !!}',
                type: 'GET',
                error: function(xhr) {
                    if (xhr.status === 404) {
                        let message = xhr.responseJSON?.message || 'Feedback not added by student yet';
                        
                        Swal.fire({
                            icon: 'info',
                            title: 'No Feedback Found',
                            text: message,
                        });

                        // Clear the table and destroy DataTables instance
                        $('#feedbacksTable').DataTable().clear().destroy();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to retrieve feedbacks. Please try again later.',
                        });
                    }
                }
            },
            columns: [
                { data: 'title', name: 'title' },
                {
                    data: 'image_complete_url',
                    name: 'image_complete_url',
                    render: function(data) {
                        return data ? `<img src="${data}" class="img-thumbnail" width="50" height="50">` : 'No Image';
                    }
                },
                { data: 'feedback', name: 'feedback' }
            ],
            order: [[0, 'asc']]
        });
    });
    </script>
@endpush
