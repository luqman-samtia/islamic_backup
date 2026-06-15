@extends('adminlte::page')

@section('title', 'Student Courses')

@section('content_header')
    <h1>Courses & Permissions — {{ $student->name }}</h1>
@stop

@section('content')
@php $typeLabels = \App\StudentCourse::types(); @endphp
<div class="row">
    <div class="col-md-5">
        <div class="box box-primary">
            <div class="box-header with-border"><h3 class="box-title">Assign New Course</h3></div>
            <form id="assignCourseForm">
                <div class="box-body">
                    <input type="hidden" name="user_id" value="{{ $student->id }}">
                    <div class="form-group">
                        <label>Course Type</label>
                        <select name="lesson_type" class="form-control" required>
                            @foreach($typeLabels as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Course Name</label>
                        <input type="text" name="course_name" class="form-control" placeholder="e.g. Nazra, Hifz, Qaida Level 1" required>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="scholar_can_write" value="1" checked> Scholar can write lessons</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="student_can_write" value="1"> Student can write own lessons</label>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Assign Course</button>
                    <a href="{{ route('admin.lessons.entry', $student->id) }}" class="btn btn-success pull-right">
                        <i class="fa fa-book"></i> Open Lessons
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-7">
        <div class="box box-info">
            <div class="box-header with-border"><h3 class="box-title">Assigned Courses</h3></div>
            <div class="box-body table-responsive">
                <table class="table table-bordered" id="coursesTable">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Course</th>
                            <th>Scholar Write</th>
                            <th>Student Write</th>
                            <th>Active</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($courses as $c)
                        <tr data-id="{{ $c->id }}">
                            <td>{{ $typeLabels[$c->lesson_type] ?? $c->lesson_type }}</td>
                            <td>{{ $c->course_name }}</td>
                            <td><input type="checkbox" class="perm scholar_can_write" {{ $c->scholar_can_write ? 'checked' : '' }}></td>
                            <td><input type="checkbox" class="perm student_can_write" {{ $c->student_can_write ? 'checked' : '' }}></td>
                            <td><input type="checkbox" class="perm is_active" {{ $c->is_active ? 'checked' : '' }}></td>
                            <td><button class="btn btn-danger btn-xs del-course"><i class="fa fa-trash"></i></button></td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted">No courses assigned yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <small class="text-muted">Tip: toggle a checkbox to instantly update permissions.</small>
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
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });

$('#assignCourseForm').on('submit', function (e) {
    e.preventDefault();
    $.post('{{ route('admin.lessons.courses.store') }}', $(this).serialize(), function (res) {
        Swal.fire('Done', res.message, 'success').then(function(){ location.reload(); });
    }).fail(function (xhr) {
        var msg = (xhr.status === 422) ? Object.values(xhr.responseJSON.errors).flat().join('\n') : 'Error';
        Swal.fire('Error', msg, 'error');
    });
});

// Toggle permission instantly
$('#coursesTable').on('change', '.perm', function () {
    var row = $(this).closest('tr');
    $.post('{{ route('admin.lessons.courses.update') }}', {
        id: row.data('id'),
        scholar_can_write: row.find('.scholar_can_write').is(':checked') ? 1 : 0,
        student_can_write: row.find('.student_can_write').is(':checked') ? 1 : 0,
        is_active: row.find('.is_active').is(':checked') ? 1 : 0,
    }, function () {
        if (window.toastr) toastr.success('Updated');
    });
});

$('#coursesTable').on('click', '.del-course', function () {
    var row = $(this).closest('tr');
    Swal.fire({ title:'Remove course?', icon:'warning', showCancelButton:true, confirmButtonColor:'#d33' })
    .then(function (r) {
        if (r.isConfirmed) {
            $.post('{{ route('admin.lessons.courses.delete') }}', { id: row.data('id') }, function () {
                row.remove();
            });
        }
    });
});
</script>
@stop
