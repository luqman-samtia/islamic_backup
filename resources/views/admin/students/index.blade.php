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

<!-- Update Dates Modal -->
<div class="modal fade" id="updateDatesModal" tabindex="-1" role="dialog" aria-labelledby="updateDatesModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateDatesModalLabel">Update Student Dates</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateDatesForm">
                <div class="modal-body">
                    <input type="hidden" name="student_id" id="date_student_id">
                    
                    <div class="form-group">
                        <label>Student Name</label>
                        <input type="text" class="form-control" id="date_student_name" readonly>
                    </div>

                    <div class="form-group">
                        <label for="created_at">Join Date (In)</label>
                        <input type="date" class="form-control" name="created_at" id="created_at" required>
                    </div>

                    <div class="form-group">
                        <label for="leave_date">Leave Date (Out)</label>
                        <input type="date" class="form-control" name="leave_date" id="leave_date">
                        <small class="text-muted">Leave empty if student is still active</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Dates</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scholar Assignment Modal -->
<div class="modal fade" id="assignScholarModal" tabindex="-1" role="dialog" aria-labelledby="assignScholarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignScholarModalLabel">Assign Scholar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Student Password</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="changePasswordForm">
                <div class="modal-body">
                    <input type="hidden" name="student_id" id="student_id">
                    <div class="form-group">
                        <label>Student Name</label>
                        <input type="text" class="form-control" id="student_name_display" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" class="form-control" name="new_password" id="new_password" required>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" name="new_password_confirmation" id="new_password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="change-password" type="submit" class="btn btn-primary">Change Password</button>
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
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                            <td>Name</td>
                            <td>Scholar</td>
                            <td>Contact</td>
                            <td>Email</td>
                            <td>Status</td>
                            <td>In</td>
                            <td>Out</td>
                            <td>Change Password</td>
                            <td>Action</td>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
 
    <div class="rolesModal"></div>

@stop

@push('js')
    <script>
        var datatable = $('.table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.student') }}',
            columns: [
                { data: 'name' },
                { data: 'scholar' },
                { data: 'contact_no' },
                { data: 'email' },
                { 
                    data: 'is_verified' ,
                    render:function(data){
                        if(data==0){
                            return '<span class="badge" style="background:red;">Not Verified</span>';
                        } else {
                            return '<span class="badge" style="background:green;">Verified</span>';
                        }
                    }
                },
                { 
                    data: 'created_at',
                    render: function(data, type, row) {
                        let date = new Date(data);
                        let year = date.getFullYear();
                        let month = (date.getMonth() + 1).toString().padStart(2, '0');
                        let day = date.getDate().toString().padStart(2, '0');
                        let formattedDate = `${year}-${month}-${day}`;
                        
                        return `<span class="cursor-pointer badge bg-info" onclick="editDates(${row.id}, '${row.name}', '${data}', '${row.leave_date}')" title="Click to edit">
                                    ${formattedDate}
                                </span>`;
                    }
                },
                { 
                    data: 'leave_date',
                    render: function(data, type, row) {
                        if (!data || data === null || data === '') {
                            return '<span class="badge bg-warning cursor-pointer" onclick="editDates(' + row.id + ', \'' + row.name + '\', \'' + row.created_at + '\', \'\')" title="Click to edit">N/A</span>';
                        }
                        
                        let date = new Date(data);
                        let year = date.getFullYear();
                        let month = (date.getMonth() + 1).toString().padStart(2, '0');
                        let day = date.getDate().toString().padStart(2, '0');
                        let formattedDate = `${year}-${month}-${day}`;
                        
                        return `<span class="cursor-pointer badge bg-danger" onclick="editDates(${row.id}, '${row.name}', '${row.created_at}', '${data}')" title="Click to edit">
                                    ${formattedDate}
                                </span>`;
                    }
                },
                { data: 'password_action' },
                {
                    data: 'id',
                    render: function(data) {
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
                                    <a class="dropdown-item verify_student cursor-pointer" type="button" data-id="${data}" data-action="verify">✅ Verify</a>
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

        // Function to edit dates
        function editDates(studentId, studentName, createdAt, leaveDate) {
            $('#date_student_id').val(studentId);
            $('#date_student_name').val(studentName);
            
            // Convert dates to date format (YYYY-MM-DD)
            if (createdAt) {
                const createdDate = new Date(createdAt);
                const year = createdDate.getFullYear();
                const month = String(createdDate.getMonth() + 1).padStart(2, '0');
                const day = String(createdDate.getDate()).padStart(2, '0');
                const formattedDate = `${year}-${month}-${day}`;
                $('#created_at').val(formattedDate);
            }
            
            if (leaveDate && leaveDate !== 'null' && leaveDate !== '') {
                const leaveD = new Date(leaveDate);
                const year = leaveD.getFullYear();
                const month = String(leaveD.getMonth() + 1).padStart(2, '0');
                const day = String(leaveD.getDate()).padStart(2, '0');
                const formattedDate = `${year}-${month}-${day}`;
                $('#leave_date').val(formattedDate);
            } else {
                $('#leave_date').val('');
            }
            
            $('#updateDatesModal').modal('show');
        }

        // Handle update dates form submission
        $('#updateDatesForm').on('submit', function(e) {
            e.preventDefault();

            const studentId = $('#date_student_id').val();
            const createdAt = $('#created_at').val();
            const leaveDate = $('#leave_date').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/admin/student/' + studentId + '/update-dates',
                method: 'POST',
                data: {
                    created_at: createdAt,
                    leave_date: leaveDate
                },
                success: function(response) {
                    $('#updateDatesModal').modal('hide');
                    Swal.fire(
                        'Success!',
                        response.success || 'Dates updated successfully!',
                        'success'
                    );
                    datatable.ajax.reload();
                },
                error: function(xhr) {
                    let error = xhr.responseJSON?.error || 'Error occurred';
                    Swal.fire(
                        'Error!',
                        error,
                        'error'
                    );
                }
            });
        });

        // Rest of your existing JavaScript code...
        $(document).on('click', '.change-password', function() {
            let studentId = $(this).data('id');
            
            $.ajax({
                url: '/admin/student/' + studentId,
                method: 'GET',
                success: function(data) {
                    $('#student_id').val(data.id);
                    $('#student_name_display').val(data.name);
                    $('#new_password').val('');
                    $('#new_password_confirmation').val('');
                    $('#changePasswordModal').modal('show');
                }
            });
        });

        $('#changePasswordForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('admin.student.changePassword') }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#changePasswordModal').modal('hide');
                    Swal.fire('Success!', response.success, 'success');
                    datatable.ajax.reload();
                },
                error: function(xhr) {
                    let error = xhr.responseJSON?.error || 'Error occurred';
                    Swal.fire('Error!', error, 'error');
                }
            });
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
                            Swal.fire('Deleted!', 'The student has been deleted.', 'success');
                            datatable.ajax.reload();
                        }
                    });
                }
            });
        });

        $(document).on('click', '.verify_student', function() {
            let sid = $(this).attr('data-id');

            $.ajax({
                url: "{{ url('admin/check-student-status') }}/" + sid,
                type: "GET",
                success: function(response) {
                    if (response.is_verified) {
                        Swal.fire('Error!', 'This student is already verified!', 'error');
                    } else {
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
                                        Swal.fire('Success!', response.success, 'success');
                                        datatable.ajax.reload();
                                    },
                                    error: function(xhr) {
                                        let errorMessage = xhr.responseJSON?.error || 'Something went wrong!';
                                        Swal.fire('Error!', errorMessage, 'error');
                                    }
                                });
                            }
                        });
                    }
                },
                error: function(xhr) {
                    let errorMessage = xhr.responseJSON?.error || 'Something went wrong!';
                    Swal.fire('Error!', errorMessage, 'error');
                }
            });
        });

        $(document).on('click', '.unverify_student', function() {
            let sid = $(this).attr('data-id');

            $.ajax({
                url: "{{ url('admin/check-student-disable') }}/" + sid,
                type: "GET",
                success: function(response) {
                    if (response.is_verified) {
                        Swal.fire('Error!', 'This student is already disabled!', 'error');
                    } else {
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
                                        Swal.fire('Success!', response.success, 'success');
                                        datatable.ajax.reload();
                                    },
                                    error: function(xhr) {
                                        let errorMessage = xhr.responseJSON?.error || 'Something went wrong!';
                                        Swal.fire('Error!', errorMessage, 'error');
                                    }
                                });
                            }
                        });
                    }
                },
                error: function(xhr) {
                    let errorMessage = xhr.responseJSON?.error || 'Something went wrong!';
                    Swal.fire('Error!', errorMessage, 'error');
                }
            });
        });

        $(document).on('click', '.show-feedback', function() {
            let studentId = $(this).data('id');
            window.location.href = '{{ route('admin.feedback.show', ':id') }}'.replace(':id', studentId);
        });

        $('.table').on('click', '.add-links', function() {
            let studentId = $(this).data('id'); 
            window.location.href = '{{ route('admin.student.addLinks', ':id') }}'.replace(':id', studentId);
        });

        $(document).on('click', '.assign-scholar', function() {
            var studentId = $(this).data('id');

            $.ajax({
                url: '/admin/student/' + studentId,
                method: 'GET',
                success: function(data) {
                    $('#id').val(data.id);
                    $('#student_name').val(data.name);
                    $('#student_email').val(data.email);
                    $('#assignScholarModal').modal('show');
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
                    Swal.fire('Success!', response.success, 'success');
                    window.location.reload();
                },
                error: function(xhr) {
                    alert('An error occurred while assigning the scholar.');
                }
            });
        });
    </script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @endpush