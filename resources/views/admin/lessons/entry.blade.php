@extends('adminlte::page')

@section('title', 'Lessons')

@section('content_header')
    <h1>Lessons — {{ $student->name }}</h1>
@stop

@section('content')

@php
    // Build a clean config array for the front-end
    $config = [];
    foreach ($tables as $type => $t) {
        $opts = [];
        foreach ($t['options'] as $fieldKey => $list) {
            $opts[$fieldKey] = $list->map(function ($o) {
                return ['id' => $o->id, 'label' => $o->label];
            })->values();
        }
        $config[$type] = [
            'columns'  => $t['columns'],
            'options'  => $opts,
            'records'  => $t['records'],
            'canWrite' => $t['can_write'],
        ];
    }
@endphp

@if(empty($tables))
    <div class="callout callout-warning">
        <h4>No courses assigned</h4>
        <p>This student has no active course yet. Assign a course first to start writing lessons.</p>
    </div>
@endif

@foreach($tables as $type => $t)
<div class="box box-primary lesson-box" data-type="{{ $type }}">
    <div class="box-header with-border">
        <h3 class="box-title">
            <i class="fa fa-book"></i> {{ $typeLabels[$type] ?? ucfirst($type) }}
        </h3>
        <div class="pull-right">
            @if($t['can_write'])
                <button class="btn btn-default btn-sm add-row-btn" data-type="{{ $type }}">
                    <i class="fa fa-plus"></i> Add Row
                </button>
                <button class="btn btn-primary btn-sm save-btn" data-type="{{ $type }}">
                    <i class="fa fa-save"></i> Save
                </button>
            @else
                <span class="label label-default">Read only</span>
            @endif
        </div>
    </div>
    <div class="box-body table-responsive">
        <table class="table table-bordered table-hover lesson-table" data-type="{{ $type }}" style="min-width:900px">
            <thead>
                <tr class="bg-gray">
                    @foreach($t['columns'] as $col)
                        <th>{{ $col['label'] }}</th>
                    @endforeach
                    @if($t['can_write'])<th style="width:50px">Del</th>@endif
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endforeach
@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<style>
    .lesson-table input.cell, .lesson-table select.cell { min-width: 90px; }
    .day-label { font-size: 11px; color:#777; display:block; }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });

var LESSON_CONFIG = @json($config);
var STUDENT_ID    = {{ $student->id }};

function esc(s) {
    return (s == null ? '' : String(s))
        .replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
        .replace(/"/g,'&quot;').replace(/'/g,'&#39;');
}

function dayFromDate(val) {
    if (!val) return '';
    var d = new Date(val + 'T00:00:00');
    if (isNaN(d)) return '';
    return d.toLocaleDateString('en-US', { weekday: 'long' });
}

// Build a single cell based on its column definition
function buildCell(type, col, record) {
    var val = record ? (record[col.key] != null ? record[col.key] : '') : '';
    var canWrite = LESSON_CONFIG[type].canWrite;
    var disabled = canWrite ? '' : 'disabled';

    if (col.type === 'date') {
        var dayVal = record && record.day ? record.day : dayFromDate(val);
        return '<td>' +
                 '<input type="date" class="form-control input-sm cell date-cell" data-key="' + col.key + '" value="' + esc(val) + '" ' + disabled + '>' +
                 '<span class="day-label">' + esc(dayVal) + '</span>' +
                 '<input type="hidden" class="cell day-hidden" data-key="day" value="' + esc(dayVal) + '">' +
               '</td>';
    }

    if (col.type === 'dropdown') {
        var opts = LESSON_CONFIG[type].options[col.key] || [];
        var html = '<td><select class="form-control input-sm cell drop-cell" data-key="' + col.key + '" data-field="' + col.key + '" ' + disabled + '>';
        html += '<option value="">--</option>';
        var found = false;
        opts.forEach(function (o) {
            var sel = (o.label === val) ? 'selected' : '';
            if (sel) found = true;
            html += '<option value="' + esc(o.label) + '" ' + sel + '>' + esc(o.label) + '</option>';
        });
        // keep an existing value even if it's not in options anymore
        if (val && !found) html += '<option value="' + esc(val) + '" selected>' + esc(val) + '</option>';
        if (canWrite) html += '<option value="__add__">+ Add new...</option>';
        html += '</select></td>';
        return html;
    }

    // text
    return '<td><input type="text" class="form-control input-sm cell" data-key="' + col.key + '" value="' + esc(val) + '" ' + disabled + '></td>';
}

function buildRow(type, record) {
    var cols = LESSON_CONFIG[type].columns;
    var tr = '<tr>';
    if (record && record.id) tr = '<tr data-id="' + record.id + '">';
    cols.forEach(function (col) { tr += buildCell(type, col, record); });
    if (LESSON_CONFIG[type].canWrite) {
        tr += '<td><button class="btn btn-danger btn-xs del-row"><i class="fa fa-trash"></i></button></td>';
    }
    tr += '</tr>';
    return tr;
}

// Initial render of all tables
Object.keys(LESSON_CONFIG).forEach(function (type) {
    var tbody = $('.lesson-table[data-type="' + type + '"] tbody');
    var records = LESSON_CONFIG[type].records || [];
    records.forEach(function (rec) { tbody.append(buildRow(type, rec)); });
    if (records.length === 0 && LESSON_CONFIG[type].canWrite) {
        tbody.append(buildRow(type, null)); // one blank starter row
    }
});

// Add row
$('.add-row-btn').on('click', function () {
    var type = $(this).data('type');
    $('.lesson-table[data-type="' + type + '"] tbody').append(buildRow(type, null));
});

// Delete row
$(document).on('click', '.del-row', function () {
    $(this).closest('tr').remove();
});

// Date -> auto day
$(document).on('change', '.date-cell', function () {
    var day = dayFromDate($(this).val());
    var td = $(this).closest('td');
    td.find('.day-label').text(day);
    td.find('.day-hidden').val(day);
});

// Dropdown "+ Add new..."  ->  add option inline
$(document).on('change', '.drop-cell', function () {
    var $sel  = $(this);
    if ($sel.val() !== '__add__') return;

    var type  = $sel.closest('.lesson-table').data('type');
    var field = $sel.data('field');
    $sel.val(''); // reset selection while we ask

    Swal.fire({
        title: 'Add new item',
        input: 'text',
        inputPlaceholder: 'Type the new option',
        showCancelButton: true,
        confirmButtonText: 'Add'
    }).then(function (result) {
        if (!result.isConfirmed || !result.value || !result.value.trim()) return;
        var label = result.value.trim();

        $.post('{{ route('admin.lessons.options.store') }}', {
            lesson_type: type, field_key: field, label: label
        }, function (res) {
            // add to in-memory config
            LESSON_CONFIG[type].options[field] = LESSON_CONFIG[type].options[field] || [];
            LESSON_CONFIG[type].options[field].push({ id: res.option.id, label: res.option.label });

            // inject into every dropdown of this field in this table, before "+ Add new"
            $('.lesson-table[data-type="' + type + '"] select[data-field="' + field + '"]').each(function () {
                var addOpt = $(this).find('option[value="__add__"]');
                var newOpt = $('<option>').val(res.option.label).text(res.option.label);
                if (addOpt.length) addOpt.before(newOpt); else $(this).append(newOpt);
            });
            // select it in the dropdown that triggered
            $sel.val(res.option.label);
        }).fail(function () {
            Swal.fire('Error', 'Could not add item.', 'error');
        });
    });
});

// Save a table
$('.save-btn').on('click', function () {
    var type = $(this).data('type');
    var rows = [];

    $('.lesson-table[data-type="' + type + '"] tbody tr').each(function () {
        var row = {};
        var $tr = $(this);
        if ($tr.data('id')) row.id = $tr.data('id');
        $tr.find('.cell').each(function () {
            var key = $(this).data('key');
            var v   = $(this).val();
            if (v === '__add__') v = '';
            row[key] = v;
        });
        rows.push(row);
    });

    $.ajax({
        url: '{{ route('admin.lessons.save') }}',
        method: 'POST',
        data: { user_id: STUDENT_ID, lesson_type: type, rows: rows },
        beforeSend: function(){ Swal.fire({title:'Saving...', didOpen:()=>Swal.showLoading(), allowOutsideClick:false}); },
        success: function (res) { Swal.fire('Saved', res.message, 'success'); },
        error: function (xhr) {
            var msg = (xhr.responseJSON && xhr.responseJSON.error) ? xhr.responseJSON.error : 'Could not save.';
            Swal.fire('Error', msg, 'error');
        }
    });
});
</script>
@stop
