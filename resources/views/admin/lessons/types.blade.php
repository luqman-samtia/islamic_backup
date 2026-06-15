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
                            <option value="dropdown" {{ $meta[1] === 'dropdown' ? 'selected' : '' }}>Dropdown</option>
                        </select>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <small class="text-muted">
            <b>Dropdown</b> = admin-managed "Add Item" list (Lesson Options page).
            <b>Text</b> = free typing. A "Day &amp; Date" column is always added automatically.
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
}

// Collect ticked columns into the columns[key][...] structure
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

// Save (create or update)
$('#saveType').on('click', function () {
    var id    = $('#typeId').val();
    var label = $('#typeLabel').val().trim();
    if (!label) { Swal.fire('Wait', 'Enter a type name.', 'warning'); return; }

    var cols = collectColumns();
    if ($.isEmptyObject(cols)) { Swal.fire('Wait', 'Tick at least one column.', 'warning'); return; }

    var url  = id ? '{{ route('admin.lessons.types.update') }}' : '{{ route('admin.lessons.types.store') }}';
    var data = { label: label, columns: cols };
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

    columns.forEach(function (c) {
        $('.col-enable[data-key="' + c.key + '"]').prop('checked', true);
        $('.col-label[data-key="' + c.key + '"]').val(c.label);
        $('.col-type[data-key="' + c.key + '"]').val(c.type);
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
