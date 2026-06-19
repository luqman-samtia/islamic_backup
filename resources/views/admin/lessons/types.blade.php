@extends('adminlte::page')

@section('title', 'Lesson Types')

@section('content_header')
    <h1>Lesson Types</h1>
@stop

@section('content')

{{-- ===== Existing types ===== --}}
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">All Lesson Types</h3>
    </div>
    <div class="box-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr class="bg-gray">
                    <th style="width:50px">#</th>
                    <th>Name</th>
                    <th>Key</th>
                    <th>Columns</th>
                    <th style="width:90px">Active</th>
                    <th style="width:140px">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($types as $i => $t)
                <tr data-id="{{ $t->id }}">
                    <td>{{ $i + 1 }}</td>
                    <td><b>{{ $t->label }}</b></td>
                    <td><code>{{ $t->key }}</code></td>
                    <td><small>{{ collect($t->columns)->pluck('label')->implode(', ') }}</small></td>
                    <td>
                        <input type="checkbox" class="toggle-active" data-id="{{ $t->id }}"
                               {{ $t->is_active ? 'checked' : '' }}>
                    </td>
                    <td>
                        <button class="btn btn-info btn-xs edit-type"
                                data-id="{{ $t->id }}"
                                data-label="{{ $t->label }}"
                                data-columns='@json($t->columns)'>
                            <i class="fa fa-pencil"></i> Edit
                        </button>
                        <button class="btn btn-danger btn-xs del-type" data-id="{{ $t->id }}">
                            <i class="fa fa-times"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted">No lesson types yet. Add one below.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ===== Add / Edit form ===== --}}
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title" id="formTitle">Add New Lesson Type</h3>
    </div>
    <div class="box-body">
        <input type="hidden" id="typeId" value="">

        <div class="form-group">
            <label>Type Name</label>
            <input type="text" id="typeLabel" class="form-control"
                   placeholder="e.g. Hadith / Nazra / Tajweed" style="max-width:400px">
            <small class="text-muted">A unique key is generated automatically from the name.</small>
        </div>

        <label>Columns (tick the ones this type should show)</label>
        <table class="table table-bordered" style="max-width:700px">
            <thead>
                <tr class="bg-gray">
                    <th style="width:60px">Use</th>
                    <th>Field</th>
                    <th>Display Label</th>
                    <th style="width:140px">Input Type</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pool as $key => $meta)
                <tr>
                    <td class="text-center">
                        <input type="checkbox" class="col-enable" data-key="{{ $key }}">
                    </td>
                    <td><code>{{ $key }}</code></td>
                    <td>
                        <input type="text" class="form-control input-sm col-label"
                               data-key="{{ $key }}" value="{{ $meta[0] }}">
                    </td>
                    <td>
                        <select class="form-control input-sm col-type" data-key="{{ $key }}">
                            <option value="text"     {{ $meta[1] === 'text' ? 'selected' : '' }}>Text</option>
                            <option value="number"   {{ $meta[1] === 'number' ? 'selected' : '' }}>Number</option>
                            <option value="dropdown" {{ $meta[1] === 'dropdown' ? 'selected' : '' }}>Dropdown</option>
                        </select>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <small class="text-muted">
            <b>Dropdown</b> = admin-managed "Add Item" list (Lesson Options page).
            <b>Text</b> = free typing. <b>Number</b> = numeric input only.
            A "Day &amp; Date" column is always added automatically.
        </small>

        {{-- ===== Custom / New Fields ===== --}}
        <label style="margin-top:20px">Custom Fields (apne naye column banayein)</label>
        <table class="table table-bordered" style="max-width:700px" id="customColsTable">
            <thead>
                <tr class="bg-gray">
                    <th>Display Label</th>
                    <th style="width:140px">Input Type</th>
                    <th style="width:60px"></th>
                </tr>
            </thead>
            <tbody id="customColsBody"></tbody>
        </table>
        <button type="button" class="btn btn-default btn-sm" id="addCustomCol">
            <i class="fa fa-plus"></i> Add Custom Field
        </button>
        <small class="text-muted" style="display:block;margin-top:6px">
            Key label se khud ban jati hai. Dropdown custom field ke options baad mein
            Lesson Options page se add ho sakte hain.
        </small>
    </div>
    <div class="box-footer">
        <button class="btn btn-primary" id="saveType"><i class="fa fa-save"></i> Save Type</button>
        <button class="btn btn-default" id="resetForm">New / Clear</button>
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

function clearForm() {
    $('#typeId').val('');
    $('#typeLabel').val('');
    $('#formTitle').text('Add New Lesson Type');
    $('.col-enable').prop('checked', false);
    $('#customColsBody').empty();
}

// Collect ticked pool columns into the columns[key][...] structure
function collectColumns() {
    var cols = {};
    $('.col-enable:checked').each(function () {
        var key = $(this).data('key');
        cols[key] = {
            enabled: 1,
            label: $('.col-label[data-key="' + key + '"]').val(),
            type:  $('.col-type[data-key="' + key + '"]').val()
        };
    });
    return cols;
}

// Collect admin's custom fields into the custom_columns[] structure
function collectCustomColumns() {
    var custom = [];
    $('#customColsBody tr').each(function () {
        var label = $(this).find('.custom-label').val().trim();
        if (!label) return;
        custom.push({
            label: label,
            type:  $(this).find('.custom-type').val()
        });
    });
    return custom;
}

// Add a custom field row
function addCustomRow(label, type) {
    label = label || '';
    type  = type  || 'text';
    var row =
        '<tr>' +
            '<td><input type="text" class="form-control input-sm custom-label" placeholder="e.g. Marks" value="' + label + '"></td>' +
            '<td>' +
                '<select class="form-control input-sm custom-type">' +
                    '<option value="text">Text</option>' +
                    '<option value="number">Number</option>' +
                    '<option value="dropdown">Dropdown</option>' +
                '</select>' +
            '</td>' +
            '<td class="text-center"><button type="button" class="btn btn-danger btn-xs del-custom"><i class="fa fa-times"></i></button></td>' +
        '</tr>';
    var $row = $(row);
    $row.find('.custom-type').val(type);
    $('#customColsBody').append($row);
}

$('#addCustomCol').on('click', function () { addCustomRow(); });

$(document).on('click', '.del-custom', function () {
    $(this).closest('tr').remove();
});

// Save (create or update)
$('#saveType').on('click', function () {
    var id    = $('#typeId').val();
    var label = $('#typeLabel').val().trim();
    if (!label) { Swal.fire('Wait', 'Enter a type name.', 'warning'); return; }

    var cols   = collectColumns();
    var custom = collectCustomColumns();
    if ($.isEmptyObject(cols) && custom.length === 0) {
        Swal.fire('Wait', 'Tick at least one column or add a custom field.', 'warning');
        return;
    }

    var url  = id ? '{{ route('admin.lessons.types.update') }}' : '{{ route('admin.lessons.types.store') }}';
    var data = { label: label, columns: cols, custom_columns: custom };
    if (id) { data.id = id; data.is_active = 1; }

    $.post(url, data)
        .done(function (res) {
            Swal.fire('Saved', res.message, 'success').then(function () { location.reload(); });
        })
        .fail(function (xhr) {
            var msg = (xhr.responseJSON && (xhr.responseJSON.error || xhr.responseJSON.message)) || 'Could not save.';
            Swal.fire('Error', msg, 'error');
        });
});

$('#resetForm').on('click', clearForm);

// Edit -> load into the form
$(document).on('click', '.edit-type', function () {
    var id      = $(this).data('id');
    var label   = $(this).data('label');
    var columns = $(this).data('columns') || [];

    clearForm();
    $('#typeId').val(id);
    $('#typeLabel').val(label);
    $('#formTitle').text('Edit Lesson Type: ' + label);

    var poolKeys = [];
    $('.col-enable').each(function () { poolKeys.push(String($(this).data('key'))); });

    columns.forEach(function (c) {
        if (poolKeys.indexOf(String(c.key)) !== -1) {
            // known pool column
            $('.col-enable[data-key="' + c.key + '"]').prop('checked', true);
            $('.col-label[data-key="' + c.key + '"]').val(c.label);
            $('.col-type[data-key="' + c.key + '"]').val(c.type);
        } else if (c.key !== 'day' && c.key !== 'lesson_date') {
            // custom column saved earlier -> show as editable custom row
            addCustomRow(c.label, c.type);
        }
    });

    $('html, body').animate({ scrollTop: $('#formTitle').offset().top - 80 }, 300);
});

// Toggle active
$(document).on('change', '.toggle-active', function () {
    var id     = $(this).data('id');
    var active = $(this).is(':checked') ? 1 : 0;
    $.post('{{ route('admin.lessons.types.update') }}', { id: id, is_active: active })
        .fail(function () { Swal.fire('Error', 'Could not update.', 'error'); });
});

// Delete
$(document).on('click', '.del-type', function () {
    var id = $(this).data('id');
    Swal.fire({
        title: 'Delete this type?',
        text: 'This cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        confirmButtonColor: '#d33'
    }).then(function (r) {
        if (!r.isConfirmed) return;
        $.post('{{ route('admin.lessons.types.delete') }}', { id: id })
            .done(function (res) {
                Swal.fire('Deleted', res.message, 'success').then(function () { location.reload(); });
            })
            .fail(function (xhr) {
                var msg = (xhr.responseJSON && xhr.responseJSON.error) || 'Could not delete.';
                Swal.fire('Error', msg, 'error');
            });
    });
});
</script>
@stop