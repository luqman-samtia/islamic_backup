@extends('adminlte::page')


@section('title', 'Student')

@section('content_header')
<!-- Add SweetAlert CSS and JS -->
<style>
    .cursor-pointer {
    cursor: pointer !important;
}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
                            {{-- <td>Image</td> --}}
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
                    // { data: 'image' },
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
                    //  <button type="button" data-id="${data}" class="btn btn-success btn-xs verify_student">
                    //  Verify Student
                    // </button>    
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
                    
                    <button class="btn btn-danger btn-xs dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item  verify_student cursor-pointer"  type="button" data-id="${data}" data-action="verify">✅ Verify</a>
                        </li>
                        <li>
                            <a class="dropdown-item unverify_student cursor-pointer" type="button" data-id="${data}" data-action="unverify">❌ Disable</a>
                        </li>
                    </ul>
                
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


    // verify student by admin button
    $(document).on('click', '.verify_student', function() {
    let sid = $(this).attr('data-id');

    // First, check if the student is already verified
    $.ajax({
        url: "{{ url('admin/check-student-status') }}/" + sid, // New route to check status
        type: "GET",
        success: function(response) {
            if (response.is_verified) {
                Swal.fire(
                    'Error!',
                    'This student is already verified!',
                    'error'
                );
            } else {
                // If not verified, then show the confirmation popup
                Swal.fire({
                    title: 'Are you sure to verify student?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, verify it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('admin/verify/student') }}/" + sid,
                            type: "GET",
                            success: function(response) {
                                Swal.fire(
                                    'Success!',
                                    response.success,
                                    'success'
                                );
                                datatable.ajax.reload();
                            },
                            error: function(xhr) {
                                let errorMessage = xhr.responseJSON?.error || 'Something went wrong!';
                                Swal.fire(
                                    'Error!',
                                    errorMessage,
                                    'error'
                                );
                            }
                        });
                    }
                });
            }
        },
        error: function(xhr) {
            let errorMessage = xhr.responseJSON?.error || 'Something went wrong!';
            Swal.fire(
                'Error!',
                errorMessage,
                'error'
            );
        }
    });
});

// unverify student by admin button

$(document).on('click', '.unverify_student', function() {
    let sid = $(this).attr('data-id');

    // First, check if the student is already verified
    $.ajax({
        url: "{{ url('admin/check-student-disable') }}/" + sid, // New route to check status
        type: "GET",
        success: function(response) {
            if (response.is_verified) {
                Swal.fire(
                    'Error!',
                    'This student is already disabled!',
                    'error'
                );
            } else {
                // If not verified, then show the confirmation popup
                Swal.fire({
                    title: 'Are you sure to disable student?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, disable it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('admin/disable/student') }}/" + sid,
                            type: "GET",
                            success: function(response) {
                                Swal.fire(
                                    'Success!',
                                    response.success,
                                    'success'
                                );
                                datatable.ajax.reload();
                            },
                            error: function(xhr) {
                                let errorMessage = xhr.responseJSON?.error || 'Something went wrong!';
                                Swal.fire(
                                    'Error!',
                                    errorMessage,
                                    'error'
                                );
                            }
                        });
                    }
                });
            }
        },
        error: function(xhr) {
            let errorMessage = xhr.responseJSON?.error || 'Something went wrong!';
            Swal.fire(
                'Error!',
                errorMessage,
                'error'
            );
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