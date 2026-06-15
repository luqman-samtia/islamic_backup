@extends('adminlte::page')

@section('title', 'Lesson Dropdown Options')

@section('content_header')
    <h1>Manage Dropdown Items (Add Item)</h1>
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <form method="GET" class="form-inline" action="{{ route('admin.lessons.options') }}">
            <label>Lesson Type:&nbsp;</label>
            <select name="type" class="form-control" onchange="this.form.submit()">
                @foreach(\App\StudentCourse::types() as $key => $label)
                    <option value="{{ $key }}" {{ $type == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </form>
    </div>
    <div class="box-body">
        <div class="row">
            @foreach($fields as $fieldKey => $fieldLabel)
            <div class="col-md-6">
                <div class="box box-solid">
                    <div class="box-header with-border"><h3 class="box-title">{{ $fieldLabel }}</h3></div>
                    <div class="box-body">
                        <div class="input-group" style="margin-bottom:10px">
                            <input type="text" class="form-control new-option-input"
                                   data-field="{{ $fieldKey }}" placeholder="Add new item...">
                            <span class="input-group-btn">
                                <button class="btn btn-primary add-option-btn" data-field="{{ $fieldKey }}">
                                    <i class="fa fa-plus"></i> Add
                                </button>
                            </span>
                        </div>
                        <ul class="list-group" id="list-{{ $fieldKey }}">
                            @forelse($options->get($fieldKey, collect()) as $opt)
                            <li class="list-group-item" data-id="{{ $opt->id }}">
                                {{ $opt->label }}
                                <button class="btn btn-danger btn-xs pull-right del-option" data-id="{{ $opt->id }}">
                                    <i class="fa fa-times"></i>
                                </button>
                            </li>
                            @empty
                            <li class="list-group-item text-muted empty-note">No items yet.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
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
var LESSON_TYPE = '{{ $type }}';

$('.add-option-btn').on('click', function () {
    var field = $(this).data('field');
    var input = $('.new-option-input[data-field="' + field + '"]');
    var label = input.val().trim();
    if (!label) return;

    $.post('{{ route('admin.lessons.options.store') }}', {
        lesson_type: LESSON_TYPE, field_key: field, label: label
    }, function (res) {
        var li = $('<li class="list-group-item" data-id="' + res.option.id + '">' +
                   res.option.label +
                   ' <button class="btn btn-danger btn-xs pull-right del-option" data-id="' + res.option.id + '"><i class="fa fa-times"></i></button></li>');
        $('#list-' + field + ' .empty-note').remove();
        $('#list-' + field).append(li);
        input.val('');
    });
});

$(document).on('click', '.del-option', function () {
    var li = $(this).closest('li');
    $.post('{{ route('admin.lessons.options.delete') }}', { id: $(this).data('id') }, function () {
        li.remove();
    });
});
</script>
@stop
