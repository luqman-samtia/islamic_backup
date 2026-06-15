@extends('adminlte::page')

@section('title', 'Fee Records')

@section('content_header')
    <h1>Fee Records — Students</h1>
@stop

@section('content')
<div class="box">
    <div class="box-body table-responsive">
        <table id="feeStudentsTable" class="table table-bordered table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@stop

@section('js')
<script>
$(function () {
    $('#feeStudentsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.fees.index') }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'contact_no', name: 'contact_no' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
@stop
