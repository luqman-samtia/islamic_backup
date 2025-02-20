@extends('adminlte::page')


@section('title', 'Student')

@section('content_header')
<!-- Add SweetAlert CSS and JS -->
<style>
    .cursor-pointer {
    cursor: pointer !important;
}
.modal {
    z-index: 1050 !important;
    opacity: 1 !important;
}
.fade{
    /* opacity: 0.5 !important; */
}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


<meta name="csrf-token" content="{{ csrf_token() }}">
    <h1>
       Student List
      
    </h1>
@stop
     <!-- Scholar Assignment Modal -->
<div class="modal fade" id="assignScholarModal" tabindex="-1" role="dialog" aria-labelledby="assignScholarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignScholarModalLabel">Assign Scholar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                {{-- <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"> --}}
                    {{-- <span aria-hidden="true">&times;</span> --}}
                {{-- </button> --}}
            </div>
            <form id="assignScholarForm">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" >
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" id="student_name" readonly>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" id="student_email" readonly>
                    </div>
                    <div class="form-group">
                        <label for="scholar_id">Assign Scholar</label>
                        <select class="form-control" name="scholar" id="scholar">
                            <option value="">Select Scholar</option>
                            @foreach($scholars as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
                            <td>Scholar</td>
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
                    { data: 'scholar' },
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
                    <button type="button" data-id="${data}" class="btn btn-success btn-xs assign-scholar">
                        <i class="fa fa-user"></i> Add scholar
                    </button>
                    <button type="button" data-id="${data}" class="btn btn-info btn-xs show-feedback">
                    <i class="fa fa-comments"></i> Show Feedback
                    </button>
                    
                    <button class="btn btn-danger btn-xs dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="true">
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


        $(document).on('click', '.show-feedback', function() {
            let studentId = $(this).data('id');
            // window.location.href = `/admin/feedbacks/${studentId}`;
            window.location.href = '{{ route('admin.feedback.show', ':id') }}'.replace(':id', studentId);
        });

$('.table').on('click', '.add-links', function() {
    // let studentId = $(this).data('id');
    let studentId = $(this).data('id'); 
    window.location.href = '{{ route('admin.student.addLinks', ':id') }}'.replace(':id', studentId);
});

// Assign scholar to student
$(document).on('click', '.assign-scholar', function() {
    var studentId = $(this).data('id');

    console.log($.fn.modal ? 'Bootstrap Modal Detected' : 'Bootstrap Modal Not Found');

    // Fetch student details using AJAX
    $.ajax({
        url: '/admin/student/' + studentId,
        method: 'GET',
        success: function(data) {
            $('#id').val(data.id);
            $('#student_name').val(data.name);
            $('#student_email').val(data.email);
            $('#assignScholarModal').modal('show');
            // $('#assignScholarModal').modal('show').attr('aria-hidden', 'false').css('display', 'block').focus();

        }
    });
});

$('#assignScholarForm').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '{{ route('admin.student.assign-scholar') }}',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            $('#assignScholarModal').modal('hide');
            // datatable.ajax.reload();
            // alert(response.success);
            Swal.fire(
            'Success!',
            response.success,
            'success'
        );
        // datatable.ajax.reload();
        window.location.reload();
        },
        error: function(xhr) {
            alert('An error occurred while assigning the scholar.');
        }
    });
});

    </script>


{{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- jQuery (required for Bootstrap 4) -->
{{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> --}}

<!-- Bootstrap 4 JS -->
{{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @endpush