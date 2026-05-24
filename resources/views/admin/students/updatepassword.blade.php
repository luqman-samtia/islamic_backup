@extends('adminlte::page')


@section('title', 'Student')

@section('content_header')
<!-- Add SweetAlert CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">

    <h1>
        {{ auth()->user()->type ==='admin' ? 'Admin' : 'Student' }}
         Update Password
        {{-- <a href="" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus"></i> New Scholars</a> --}}
    </h1>
@stop

@section('content')
{{-- <div class="container">
    <h2>Update Password</h2>
    <form id="updatePasswordForm">
        <div class="form-group">
            <label for="current_password">Current Password</label>
            <input type="password" class="form-control" id="current_password" name="current_password" >
        </div>
        <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" class="form-control" id="new_password" name="new_password" >
        </div>
        <div class="form-group">
            <label for="new_password_confirmation">Confirm New Password</label>
            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" >
        </div>
        <button type="submit" class="btn btn-primary">Update Password</button>
    </form>
</div> --}}

<div class="container">
    <form id="updatePasswordForm" class="mx-auto" style="max-width: 500px;">
        <h2 class="text-center ">Update Password</h2>
        <div class="form-group">
            <label for="current_password">Current Password</label>
            <input type="password" class="form-control" id="current_password" name="current_password" >
        </div>
        <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" class="form-control" id="new_password" name="new_password" >
        </div>
        <div class="form-group">
            <label for="new_password_confirmation">Confirm New Password</label>
            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" >
        </div>
        <button type="submit" class="btn btn-primary btn-block">Update Password</button>
    </form>
</div>

    <div class="rolesModal"></div>
@stop

@push('js')
    <script>
       
       $(document).ready(function() {
    $('#updatePasswordForm').on('submit', function(e) {
        e.preventDefault();

        // Collect form data
        let currentPassword = $('#current_password').val();
        let newPassword = $('#new_password').val();
        let confirmPassword = $('#new_password_confirmation').val();

        // Clear any previous error messages
        $('.error-message').remove();

        // Perform AJAX request to update password
        $.ajax({
            type: 'POST',
            url: '{{ route("information.student.update-password") }}', // Route to handle password update
            data: {
                current_password: currentPassword,
                new_password: newPassword,
                new_password_confirmation: confirmPassword,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                    });
                    $('#updatePasswordForm')[0].reset();
                }
            },
            error: function(xhr) {
                // Display error messages
                if (xhr.status === 422) { // Validation error
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        // Display each validation error next to the relevant input field
                        $('#' + key).after('<span class="error-message" style="color:red;">' + value[0] + '</span>');
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON.error || 'An error occurred',
                    });
                }
            }
        });
    });
});

    </script>
    @endpush