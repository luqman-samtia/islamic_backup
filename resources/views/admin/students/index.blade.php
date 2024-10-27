@extends('adminlte::page')


@section('title', 'Student')

@section('content_header')
<!-- Add SweetAlert CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
    <h1>
       Student List
      
    </h1>
@stop

@section('content')
<div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="feedbackModalLabel">Student Feedback</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Student Name:</strong> <span id="studentName"></span></p>
                <p><strong>Feedback Title:</strong> <span id="feedbackTitle"></span></p>
                <p><strong>Feedback Message:</strong></p>
                <p id="feedbackMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-body table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                        <tr>
                            <td>Image</td>
                            <td>Name</td>
                            <td>Email</td>
                            <td>Status</td>
                            <td>Joined</td>
                            
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
 
    {{-- <button type="button" onclick="$('#feedbackModal').modal('show');">Test Modal</button> --}}

    <div class="rolesModal"></div>

@stop

@push('js')
    <script>
        // $(function() {
            var datatable = $('.table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.student') }}',
                columns: [
                    { data: 'image', name: 'image', orderable: false, searchable: false },
                    { data: 'name' },
                    { data: 'email' },
                    { 
                        data: 'is_verified' ,
                        render:function(data){
                            if(data==0){
                            return '<span class="badge" style="background:red;">Not Verified</span>';
                        }
                        else{
                            return '<span class="badge" style="background:green;">Verified</span>';
                        }
                        }
                        

                    },
                    { 
                        data: 'created_at',
                        render: function(data, type, row) {
                            // Format the date using JavaScript's Date object
                            let date = new Date(data);
                            let day = date.getDate().toString().padStart(2, '0');
                            let month = (date.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-indexed
                            let year = date.getFullYear();
                            
                            // Return only the date in DD-MM-YYYY format
                            return `${day}-${month}-${year}`;
                        }
                     },
                    {
                        data: 'id',
                        render: function(data) {
                            let deleteStudent = '{{ route('admin.student.destroy', ':id') }}';
                            deleteStudent = deleteStudent.replace(':id', data);
                            
                            return `
                    <button type="button" data-id="${data}" class="btn btn-danger btn-xs delete">
                        <i class="fa fa-trash-o"></i>
                    </button>
                    <button type="button" data-id="${data}" class="btn btn-primary btn-xs add-links">
                        <i class="fa fa-link"></i> Add Links
                    </button>
                    <button type="button" data-id="${data}" class="btn btn-info btn-xs show-feedback">
                    <i class="fa fa-comments"></i> Show Feedback
                    </button>
                `;
                        }
                    }
                ]
              
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
                url : "{{ route('admin.student.destroy') }}",
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


    // Event listener for "Show Feedback" button
    $(document).on('click', '.show-feedback', function() {
    let studentId = $(this).data('id');

    // AJAX request to fetch feedback
    $.ajax({
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        type: 'GET',
        // url: `/feedback/${studentId}`, // Route to get feedback by student ID
        url:"{{ route('feedback.get', ':id') }}".replace(':id', studentId),
        success: function(response) {
            if (response.success) {
                // Populate modal with feedback data
                $('#studentName').text(response.data.student_name);
                $('#feedbackTitle').text(response.data.title);
                $('#feedbackMessage').text(response.data.feedback);

                $('#feedbackModal').modal('show');
            } else {
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Feedback not found for this student',
                });
            }
        
        },
            error: function(xhr) {
            let message = 'Failed to retrieve feedback. Please try again later.';
            if (xhr.status === 404) {
                message = xhr.responseJSON?.message || message; // Use server-provided message if available
            }
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message,
            });
        }
    });
});


$('.table').on('click', '.add-links', function() {
    // let studentId = $(this).data('id');
    let studentId = $(this).data('id'); // Get the student ID from the button
    // $('#dynamicStudentForm')[0].reset(); // Clear any previous data in the form
    // $('#dynamicStudentContainer').empty(); // Clear previous fields from container

    // // Set a hidden input with student ID for submission
    // $('#dynamicStudentContainer').append(`<input type="hidden" name="student_id" value="${studentId}">`);
    // Redirect to the add links page with studentId as a parameter
    window.location.href = '{{ route('admin.student.addLinks', ':id') }}'.replace(':id', studentId);
});
    </script>
    @endpush