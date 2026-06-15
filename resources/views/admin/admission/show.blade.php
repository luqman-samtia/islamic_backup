@extends('adminlte::page')

@section('title', 'Admission Form')

@section('content_header')
    <h1>Admission Form — {{ $form->student_name }}</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border"><h3 class="box-title">Edit Details</h3></div>
            <form id="admissionEditForm" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Roll No</label>
                            <input type="text" name="roll_no" class="form-control" value="{{ $form->roll_no }}" placeholder="Assigned by admin">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Student Name <span class="text-danger">*</span></label>
                            <input type="text" name="student_name" class="form-control" value="{{ $form->student_name }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Father Name</label>
                            <input type="text" name="father_name" class="form-control" value="{{ $form->father_name }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Course</label>
                            <input type="text" name="course" class="form-control" value="{{ $form->course }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Age</label>
                            <input type="text" name="age" class="form-control" value="{{ $form->age }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Fee</label>
                            <input type="text" name="fee" class="form-control" value="{{ $form->fee }}" placeholder="Assigned by admin">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Phone No</label>
                            <input type="text" name="phone_no" class="form-control" value="{{ $form->phone_no }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Admission Date</label>
                            <input type="date" name="admission_date" class="form-control"
                                   value="{{ $form->admission_date ? \Carbon\Carbon::parse($form->admission_date)->format('Y-m-d') : '' }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Photo</label>
                            <input type="file" name="pic" class="form-control" accept="image/*">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Address</label>
                            <textarea name="address" class="form-control" rows="2">{{ $form->address }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
                    <a href="{{ route('admin.admission.index') }}" class="btn btn-default">Back</a>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-success">
            <div class="box-header with-border"><h3 class="box-title">Photo</h3></div>
            <div class="box-body text-center">
                @if($form->pic)
                    <img src="{{ asset('storage/'.$form->pic) }}" class="img-responsive" style="margin:auto;max-height:280px;border-radius:6px">
                @else
                    <p class="text-muted">No photo uploaded.</p>
                @endif
                <hr>
                <p><b>Login Email:</b> {{ optional($form->user)->email }}</p>
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
$('#admissionEditForm').on('submit', function (e) {
    e.preventDefault();
    var fd = new FormData(this);
    $.ajax({
        url: '{{ route('admin.admission.update', $form->id) }}',
        method: 'POST',
        data: fd,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
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
