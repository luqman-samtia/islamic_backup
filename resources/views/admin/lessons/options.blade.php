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
        <p class="text-muted" style="margin:8px 0 0">
            <i class="fa fa-info-circle"></i> Tip: items ko <b>drag</b> (<i class="fa fa-bars"></i> handle se) kar ke
            upar-neeche karein — tarteeb khud save ho jayegi.
        </p>
    </div>
    <div class="box-body">
        <div class="row">
            @foreach($fields as $fieldKey => $fieldLabel)
            <div class="col-md-6">
                <div class="box box-solid">
                    <div class="box-header with-border"><h3 class="box-title">{{ $fieldLabel }}</h3></div>
                    <div class="box-body">

                        {{-- Add new item --}}
                        <div class="input-group" style="margin-bottom:10px">
                            <input type="text" class="form-control new-option-input"
                                   data-field="{{ $fieldKey }}" placeholder="Add new item...">
                            <span class="input-group-btn">
                                <button class="btn btn-primary add-option-btn" data-field="{{ $fieldKey }}">
                                    <i class="fa fa-plus"></i> Add
                                </button>
                            </span>
                        </div>

                        {{-- Search / filter this list --}}
                        <div class="input-group" style="margin-bottom:10px">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            <input type="text" class="form-control filter-option-input"
                                   data-field="{{ $fieldKey }}" placeholder="Search...">
                        </div>

                        <ul class="list-group sortable-list" id="list-{{ $fieldKey }}" data-field="{{ $fieldKey }}"
                            style="max-height:320px; overflow-y:auto; margin-bottom:0;">
                            @forelse($options->get($fieldKey, collect()) as $opt)
                            <li class="list-group-item" data-id="{{ $opt->id }}" data-label="{{ $opt->label }}">
                                <span class="drag-handle"><i class="fa fa-bars"></i></span>
                                <span class="pos-badge">{{ $loop->iteration }}</span>
                                <span class="opt-label">{{ $opt->label }}</span>
                                <button class="btn btn-danger btn-xs pull-right del-option" data-id="{{ $opt->id }}">
                                    <i class="fa fa-times"></i>
                                </button>
                            </li>
                            @empty
                            <li class="list-group-item text-muted empty-note">No items yet.</li>
                            @endforelse
                        </ul>

                        <p class="text-muted no-results" data-field="{{ $fieldKey }}"
                           style="display:none; margin:8px 2px 0;">No matching items.</p>

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
<style>
    .drag-handle { cursor:move; color:#aaa; margin-right:8px; }
    .drag-handle:hover { color:#555; }
    .pos-badge {
        display:inline-block; min-width:22px; text-align:center;
        background:#eee; color:#555; border-radius:3px;
        font-size:11px; padding:1px 5px; margin-right:8px;
    }
    .sortable-list .list-group-item { display:flex; align-items:center; }
    .sortable-list .opt-label { flex:1; }
    .sortable-ghost { opacity:.4; background:#f0f7ff; }
    .sortable-chosen { background:#fafafa; }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
var LESSON_TYPE = '{{ $type }}';

// Position number (1,2,3...) dobara likho
function renumber(field) {
    $('#list-' + field + ' li.list-group-item').not('.empty-note').each(function (i) {
        $(this).find('.pos-badge').text(i + 1);
    });
}

// Mojooda tarteeb backend ko bhejo (sort_order save)
function saveOrder(field) {
    var ids = [];
    $('#list-' + field + ' li.list-group-item').not('.empty-note').each(function () {
        ids.push($(this).data('id'));
    });
    renumber(field);
    $.post('{{ route('admin.lessons.options.reorder') }}', {
        lesson_type: LESSON_TYPE, field_key: field, ids: ids
    });
}

// Har list ko drag-drop sortable banao
document.querySelectorAll('ul.sortable-list').forEach(function (ul) {
    new Sortable(ul, {
        handle: '.drag-handle',
        animation: 150,
        filter: '.empty-note',
        ghostClass: 'sortable-ghost',
        chosenClass: 'sortable-chosen',
        onEnd: function () { saveOrder(ul.dataset.field); }
    });
});

// Search filter
function applyFilter(field) {
    var q = $('.filter-option-input[data-field="' + field + '"]').val().toLowerCase().trim();
    var visible = 0;
    $('#list-' + field + ' li.list-group-item').not('.empty-note').each(function () {
        var match = $(this).text().toLowerCase().indexOf(q) > -1;
        $(this).toggle(match);
        if (match) visible++;
    });
    $('.no-results[data-field="' + field + '"]').toggle(q !== '' && visible === 0);
}
$(document).on('keyup', '.filter-option-input', function () {
    applyFilter($(this).data('field'));
});

// Add option (naya item list ke aakhir mein lagta hai)
$('.add-option-btn').on('click', function () {
    var field = $(this).data('field');
    var input = $('.new-option-input[data-field="' + field + '"]');
    var label = input.val().trim();
    if (!label) return;

    $.post('{{ route('admin.lessons.options.store') }}', {
        lesson_type: LESSON_TYPE, field_key: field, label: label
    }, function (res) {
        var safe = $('<div>').text(res.option.label).html();
        var li = $(
            '<li class="list-group-item" data-id="' + res.option.id + '" data-label="' + safe + '">' +
                '<span class="drag-handle"><i class="fa fa-bars"></i></span>' +
                '<span class="pos-badge"></span>' +
                '<span class="opt-label">' + safe + '</span>' +
                '<button class="btn btn-danger btn-xs pull-right del-option" data-id="' + res.option.id + '"><i class="fa fa-times"></i></button>' +
            '</li>'
        );
        $('#list-' + field + ' .empty-note').remove();
        $('#list-' + field).append(li);
        renumber(field);
        applyFilter(field);
        input.val('').focus();
    });
});

// Enter key se bhi add
$('.new-option-input').on('keypress', function (e) {
    if (e.which === 13) {
        e.preventDefault();
        $('.add-option-btn[data-field="' + $(this).data('field') + '"]').click();
    }
});

// Delete option
$(document).on('click', '.del-option', function () {
    var li = $(this).closest('li');
    var field = li.closest('ul').data('field');
    $.post('{{ route('admin.lessons.options.delete') }}', { id: $(this).data('id') }, function () {
        li.remove();
        if ($('#list-' + field + ' li.list-group-item').length === 0) {
            $('#list-' + field).append('<li class="list-group-item text-muted empty-note">No items yet.</li>');
        } else {
            renumber(field);
        }
    });
});
</script>
@stop