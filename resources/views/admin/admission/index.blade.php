@extends('adminlte::page')

@section('title', 'Admission Forms')

@section('content_header')
    <h1>Student Admission Forms</h1>
@stop

@section('content')
<div class="box">
    <div class="box-body table-responsive">
        <table id="admissionTable" class="table table-bordered table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Photo</th>
                    <th>Roll No</th>
                    <th>Student Name</th>
                    <th>Father Name</th>
                    <th>Course</th>
                    <th>Age</th>
                    <th>Fee</th>
                    <th>Phone</th>
                    <th>Admission Date</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function () {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });

    var table = $('#admissionTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.admission.index') }}',
        columns: [
            { data: 'id', name: 'admission_forms.id' },
            { data: 'pic_url', name: 'pic', orderable: false, searchable: false,
              render: function (d) {
                  return d ? '<img src="' + d + '" style="height:45px;border-radius:4px">' : '<span class="text-muted">—</span>';
              }},
            { data: 'roll_no', name: 'roll_no' },
            { data: 'student_name', name: 'student_name' },
            { data: 'father_name', name: 'father_name' },
            { data: 'course', name: 'course' },
            { data: 'age', name: 'age' },
            { data: 'fee', name: 'fee' },
            { data: 'phone_no', name: 'phone_no' },
            { data: 'admission_date', name: 'admission_date' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    $('#admissionTable').on('click', '.delete-admission', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete this admission form?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, delete'
        }).then(function (res) {
            if (res.isConfirmed) {
                $.post('{{ route('admin.admission.destroy') }}', { id: id }, function () {
                    table.ajax.reload();
                    Swal.fire('Deleted', 'Admission form removed.', 'success');
                });
            }
        });
    });
});
</script>
@stop
