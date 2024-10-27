@extends('adminlte::page')


@section('title', 'Student')

@section('content_header')
<!-- Add SweetAlert CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">

    <h1>
        Student Feedback
        {{-- <a href="" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus"></i> New Scholars</a> --}}
    </h1>
@stop

@section('content')
<div class="container">
    <h2>Submit Feedback</h2>
    <form id="feedbackForm">
        @csrf
        <div class="form-group">
            <label for="title">Title:</label>
            <input id="title" name="title" value="
            @if(!empty($feedback->title))
            {{$feedback->title}}
            @endif
            " class="form-control" >
        </div>
        <div class="form-group">
            <label for="feedback">Feedback:</label>
            <textarea rows="10" id="feedback" name="feedback" class="form-control" >
            @if(!empty($feedback->feedback))
            {{$feedback->feedback}}
            @endif
            </textarea>
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-comments"></i> Submit Feedback
        </button>
    </form>
</div>
    <div class="rolesModal"></div>
@stop

@push('js')
    <script>
       
       $(document).ready(function() {
    $('#feedbackForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: '{{ route("feedback.submit") }}',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Feedback Submitted',
                        text: response.message,
                    });

                    // Update the title and feedback fields with the new data
                    $('#title').val(response.data.title);
                    $('#feedback').val(response.data.feedback);
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = 'Please correct the following errors:<br>';
                $.each(errors, function(key, error) {
                    errorMessage += `${error[0]}<br>`;
                });
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: errorMessage,
                });
            }
        });
    });
});

    </script>
    @endpush