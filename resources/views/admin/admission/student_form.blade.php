@extends('adminlte::page')

@section('title', 'My Admission Form')

@section('content_header')
    <h1>My Admission Form</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Fill / Update your details</h3>
            </div>
            <form id="myAdmissionForm" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Student Name <span class="text-danger">*</span></label>
                            <input type="text" name="student_name" class="form-control"
                                   value="{{ $form->student_name ?? $user->name }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Father Name</label>
                            <input type="text" name="father_name" class="form-control" value="{{ $form->father_name ?? '' }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Course</label>
                            <input type="text" name="course" class="form-control" value="{{ $form->course ?? '' }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Age</label>
                            <input type="text" name="age" class="form-control" value="{{ $form->age ?? '' }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Phone No</label>
                            <input type="text" name="phone_no" class="form-control"
                                   value="{{ $form->phone_no ?? $user->contact_no }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Admission Date</label>
                            <input type="date" name="admission_date" class="form-control"
                                   value="{{ isset($form->admission_date) ? \Carbon\Carbon::parse($form->admission_date)->format('Y-m-d') : '' }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Photo</label>
                            <input type="file" name="pic" class="form-control" accept="image/*">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Address</label>
                            <textarea name="address" class="form-control" rows="2">{{ $form->address ?? '' }}</textarea>
                        </div>
                    </div>

                    @if(isset($form) && ($form->roll_no || $form->fee))
                    <div class="callout callout-info" style="margin-top:10px">
                        <p style="margin:0">
                            <b>Roll No:</b> {{ $form->roll_no ?? 'Not assigned yet' }}
                            &nbsp;|&nbsp;
                            <b>Fee:</b> {{ $form->fee ?? 'Not assigned yet' }}
                            <br><small>Roll No and Fee are assigned by the admin.</small>
                        </p>
                    </div>
                    @endif
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save My Form</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-success">
            <div class="box-header with-border"><h3 class="box-title">My Photo</h3></div>
            <div class="box-body text-center">
                @if(isset($form) && $form->pic)
                    <img id="currentPic" src="{{ asset('storage/'.$form->pic) }}" class="img-responsive" style="margin:auto;max-height:260px;border-radius:6px">
                @else
                    <p id="noPic" class="text-muted">No photo yet — upload one above.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$('#myAdmissionForm').on('submit', function (e) {
    e.preventDefault();
    var fd = new FormData(this);
    $.ajax({
        url: '{{ route('admission.my-form.store') }}',
        method: 'POST',
        data: fd,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        beforeSend: function(){ Swal.fire({title:'Saving...', didOpen:()=>Swal.showLoading(), allowOutsideClick:false}); },
        success: function (res) {
            Swal.fire('Success', res.message, 'success').then(function(){ location.reload(); });
        },
        error: function (xhr) {
            var msg = 'Something went wrong.';
            if (xhr.status === 422) msg = Object.values(xhr.responseJSON.errors).flat().join('\n');
            Swal.fire('Error', msg, 'error');
        }
    });
});
</script>
@stop
