@extends('adminlte::page')

@section('title', 'Lessons')

{{-- @section('content_header')
    <h1 class="lessons-page-title">
        <i class="fa fa-graduation-cap"></i> Lessons
        <small class="text-muted">— {{ $student->name }}</small>
    </h1>
@stop --}}
@section('content_header')
    <div class="lessons-head-row">
        <h1 class="lessons-page-title">
            <i class="fa fa-graduation-cap"></i> Lessons
            <small class="text-muted">— {{ $student->name }}</small>
        </h1>
        <div class="lessons-scholar">
            <i class="fa fa-user-circle"></i>
            <span class="ls-label">Scholar:</span>
            <span class="ls-name">{{ $scholarName ?? 'Not assigned' }}</span>
        </div>
    </div>
@stop

@section('content')

@php
    $config = [];
    foreach ($tables as $type => $t) {
        $opts = [];
        foreach ($t['options'] as $fieldKey => $list) {
            $opts[$fieldKey] = $list->map(function ($o) {
                return ['id' => $o->id, 'label' => $o->label];
            })->values();
        }
        $config[$type] = [
            'columns'   => $t['columns'],
            'options'   => $opts,
            'records'   => $t['records'],
            'canWrite'  => $t['can_write'],
            'canDelete' => $t['can_write'] && optional(auth()->user())->type !== 'student',
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
<div class="box lesson-box" data-type="{{ $type }}">

    {{-- Modern header --}}
    <div class="lesson-head">
        <div class="lesson-title">
            <span class="lesson-icon"><i class="fa fa-book"></i></span>
            <span class="lesson-title-text">{{ $typeLabels[$type] ?? ucfirst($type) }}</span>
        </div>
        @if($t['can_write'])
            <div class="lesson-actions">
                <button class="btn btn-ghost add-row-btn" data-type="{{ $type }}">
                    <i class="fa fa-plus"></i> Add Row
                </button>
                <button class="btn btn-save save-btn" data-type="{{ $type }}">
                    <i class="fa fa-save"></i> Save
                </button>
            </div>
        @else
            <span class="label label-default">Read only</span>
        @endif
    </div>

    <div class="box-body no-pad">
      <div class="table-responsive lesson-table-wrap">
        <table class="table table-bordered lesson-table" data-type="{{ $type }}">
            <thead>
                <tr>
                    @foreach($t['columns'] as $col)
                        <th>{{ $col['label'] }}</th>
                    @endforeach
                    @if($t['can_write'] && optional(auth()->user())->type !== 'student')<th class="col-del">Del</th>@endif
                </tr>
            </thead>
            <tbody></tbody>
        </table>
      </div>

      {{-- Pagination --}}
      <div class="lesson-pager" data-type="{{ $type }}"></div>
    </div>
</div>
@endforeach
@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<style>
    .lessons-page-title { font-weight: 700; font-size: 20px; margin: 0; }
    .lessons-page-title i { font-size: 18px; }
    .lessons-page-title small { font-size: 14px; }

    .content-wrapper { overflow-x: hidden; }

    /* ---------- Card ---------- */
    .lesson-box {
        border: 1px solid #e4e8ee;
        border-radius: 10px;
        box-shadow: 0 4px 14px rgba(33,49,71,.07);
        overflow: hidden;
        margin-bottom: 22px;
        max-width: 100%;
    }

    /* ---------- Header ---------- */
    .lesson-head {
        display:flex; align-items:center; justify-content:space-between;
        padding:5px 10px; background:#fff; border-bottom:1px solid #eef1f5;
    }
    .lessons-head-row {
        display:flex; align-items:center; justify-content:space-between;
        flex-wrap:wrap; gap:5px;
    }
    .lessons-scholar {
        display:inline-flex; align-items:center; gap:7px;
        background:#eef5fb; border:1px solid #cfe0ee; color:#2c6f9b;
        padding:7px 14px; border-radius:8px; font-size:14px; font-weight:600;
    }
    .lessons-scholar i { font-size:16px; }
    .lessons-scholar .ls-label { color:#6b7785; font-weight:500; }
    .lessons-scholar .ls-name { color:#243240; font-weight:700; }
    .lesson-title { display:flex; align-items:center; }
    .lesson-icon {
        width:36px; height:36px; margin-right:12px; border-radius:9px;
        display:inline-flex; align-items:center; justify-content:center;
        color:#fff; font-size:16px;
        background:linear-gradient(135deg,#3c8dbc 0%,#2c6f9b 100%);
        box-shadow:0 3px 8px rgba(44,111,155,.35);
    }
    .lesson-title-text { font-size:18px; font-weight:800; color:#243240; letter-spacing:.2px; }
    .lesson-actions { display:flex; align-items:center; }
    .lesson-actions .btn { margin-left:8px; font-weight:600; border-radius:7px; padding:7px 14px; }
    .btn-ghost { background:#fff; color:#3c8dbc; border:1px solid #cfe0ee; }
    .btn-ghost:hover { background:#f2f8fd; color:#2c6f9b; }
    .btn-save { color:#fff; border:none; background:linear-gradient(135deg,#3c8dbc 0%,#2c6f9b 100%); box-shadow:0 3px 9px rgba(44,111,155,.30); }
    .btn-save:hover { color:#fff; filter:brightness(1.05); }

    .box-body.no-pad { padding:0; }

    /* ---------- Scroll: sirf horizontal (vertical scroll nahi) ---------- */
    .lesson-table-wrap {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        max-width: 100%;
    }

    /* ---------- Table ---------- */
    .lesson-table { margin-bottom:0; background:#fff; width:100%; min-width:980px; }
    .lesson-table thead th {
        background:#2c3b41; color:#fff;
        font-weight:700; font-size:12.5px; letter-spacing:.4px;
        text-transform:uppercase; white-space:nowrap;
        padding:11px 10px; border-color:#22303a !important; vertical-align:middle;
    }
    .lesson-table thead th.col-del { text-align:center; width:56px; }

    /* Floating sticky header (JS-controlled) */
    .sticky-head-bar {
        position: fixed; z-index: 1020; overflow: hidden;
        pointer-events: none; background:#2c3b41;
        box-shadow: 0 4px 10px rgba(0,0,0,.18);
    }
    .sticky-head-bar table { margin:0; }
    .sticky-head-bar thead th { white-space:nowrap; }

    .lesson-table tbody td { padding:7px 8px; vertical-align:middle; border-color:#edf0f4; font-size:15px; }
    .lesson-table tbody tr:nth-child(even) { background:#f7f9fc; }
    .lesson-table tbody tr:hover { background:#eef5fb; }
    .lesson-table td .cell { min-width:80px; font-size:14px; }
    .lesson-table td input.date-cell { min-width:132px; font-weight:500; }
    .day-label { font-size:11px; color:#8a949e; display:block; margin-top:3px; }
    .col-del-cell { text-align:center; }

    /* ---------- Pagination ---------- */
    .lesson-pager {
        display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap;
        gap:10px; padding:12px 16px; border-top:1px solid #eef1f5; background:#fff;
    }
    .lesson-pager:empty { display:none; }
    .pager-info { color:#6b7785; font-size:13px; }
    .pager-right { display:flex; align-items:center; gap:10px; }
    .pager-list { list-style:none; margin:0; padding:0; display:flex; gap:4px; flex-wrap:wrap; }
    .pg-btn {
        min-width:32px; height:32px; padding:0 8px;
        border:1px solid #d8dee6; background:#fff; color:#3c4a59;
        border-radius:6px; font-size:13px; cursor:pointer;
    }
    .pg-btn:hover:not(:disabled):not(.dots) { background:#f2f8fd; border-color:#cfe0ee; color:#2c6f9b; }
    .pg-btn.active { background:#3c8dbc; border-color:#3c8dbc; color:#fff; font-weight:700; }
    .pg-btn:disabled, .pg-btn.dots { opacity:.5; cursor:default; }
    .pg-btn.dots { border:none; background:transparent; }
    .pager-size { border:1px solid #d8dee6; border-radius:6px; height:32px; padding:0 6px; font-size:13px; }

    /* ---------- Select2 ---------- */
    .select2-container { min-width:80px; }
    .select2-results__options { max-height:180px; overflow-y:auto; }
    .select2-container--default .select2-selection--single { height:32px; border-color:#d2d6de; border-radius:4px; }
    .select2-container--default .select2-selection--single .select2-selection__rendered { line-height:30px; font-size:15px; padding-left:8px; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { height:30px; }
    .select2-results__option { font-size:15px; padding:6px 10px; }
    .select2-container--open .select2-dropdown { border-color:#3c8dbc; }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

function todayISO() {
    var d = new Date();
    var m = ('0' + (d.getMonth() + 1)).slice(-2);
    var day = ('0' + d.getDate()).slice(-2);
    return d.getFullYear() + '-' + m + '-' + day;
}

// DB se aayi date ko <input type=date> ke liye YYYY-MM-DD
function toDateInput(v) {
    if (!v) return '';
    var m = String(v).match(/^(\d{4}-\d{2}-\d{2})/);
    return m ? m[1] : '';
}

function initSelect2(scope) {
    var $els = scope ? $(scope).find('.drop-cell') : $('.drop-cell');
    $els.each(function () {
        if ($(this).hasClass('select2-hidden-accessible')) return;
        $(this).select2({ width: '100%', placeholder: '--' });
    });
}

function buildCell(type, col, record) {
    var val = record ? (record[col.key] != null ? record[col.key] : '') : '';
    var canWrite = LESSON_CONFIG[type].canWrite;
    var disabled = canWrite ? '' : 'disabled';

    if (col.type === 'date') {
        var dval = toDateInput(val);
        if (!dval && !record) dval = todayISO();          // sirf naye row par today
        var dayVal = (record && record.day) ? record.day : dayFromDate(dval);
        return '<td>' +
                 '<input type="date" class="form-control input-sm cell date-cell" data-key="' + col.key + '" value="' + esc(dval) + '" ' + disabled + '>' +
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
        if (val && !found) html += '<option value="' + esc(val) + '" selected>' + esc(val) + '</option>';
        if (canWrite) html += '<option value="__add__">+ Add new...</option>';
        html += '</select></td>';
        return html;
    }

    return '<td><input type="text" class="form-control input-sm cell" data-key="' + col.key + '" value="' + esc(val) + '" ' + disabled + '></td>';
}

function buildRow(type, record) {
    var cols = LESSON_CONFIG[type].columns;
    var tr = '<tr>';
    if (record && record.id) tr = '<tr data-id="' + record.id + '">';
    cols.forEach(function (col) { tr += buildCell(type, col, record); });
    if (LESSON_CONFIG[type].canDelete) {
        tr += '<td class="col-del-cell"><button class="btn btn-danger btn-xs del-row"><i class="fa fa-trash"></i></button></td>';
    }
    tr += '</tr>';
    return tr;
}

/* ----------------- PAGINATION ----------------- */
// page/size refresh ke baad bhi yaad rahein
var PG_KEY = 'lessons_pg_' + STUDENT_ID;
function loadPG() { try { return JSON.parse(localStorage.getItem(PG_KEY)) || {}; } catch (e) { return {}; } }
function savePG() { try { localStorage.setItem(PG_KEY, JSON.stringify(PAGE_STATE)); } catch (e) {} }

var PAGE_STATE = loadPG();   // type -> { page, size }

function getState(type) {
    if (!PAGE_STATE[type]) PAGE_STATE[type] = { page: 1, size: 15 };
    return PAGE_STATE[type];
}

function pageNumbers(cur, pages) {
    var out = [];
    if (pages <= 7) { for (var i = 1; i <= pages; i++) out.push(i); return out; }
    out.push(1);
    var s = Math.max(2, cur - 1), e = Math.min(pages - 1, cur + 1);
    if (s > 2) out.push('...');
    for (var i = s; i <= e; i++) out.push(i);
    if (e < pages - 1) out.push('...');
    out.push(pages);
    return out;
}

function paginate(type) {
    var st    = getState(type);
    var $rows = $('.lesson-table[data-type="' + type + '"] tbody tr');
    var total = $rows.length;
    var size  = (st.size === 'all') ? (total || 1) : st.size;
    var pages = Math.max(1, Math.ceil(total / size));
    if (st.page > pages) st.page = pages;
    if (st.page < 1) st.page = 1;

    var start = (st.page - 1) * size;
    $rows.hide().slice(start, start + size).show();

    renderPager(type, st.page, pages, total, start, size, st.size);
    if (window.updateSticky) updateSticky();
}

function renderPager(type, cur, pages, total, start, size, sizeVal) {
    var $pager = $('.lesson-pager[data-type="' + type + '"]');
    if (total === 0) { $pager.empty(); return; }

    var from = start + 1;
    var to   = Math.min(start + size, total);

    var html = '<div class="pager-info">Showing ' + from + '–' + to + ' of ' + total + '</div>';
    html += '<div class="pager-right">';
    html += '<ul class="pager-list">';
    html += '<li><button class="pg-btn" data-type="' + type + '" data-page="' + (cur - 1) + '" ' + (cur === 1 ? 'disabled' : '') + '>&laquo;</button></li>';
    pageNumbers(cur, pages).forEach(function (p) {
        if (p === '...') { html += '<li><button class="pg-btn dots" disabled>…</button></li>'; }
        else html += '<li><button class="pg-btn ' + (p === cur ? 'active' : '') + '" data-type="' + type + '" data-page="' + p + '">' + p + '</button></li>';
    });
    html += '<li><button class="pg-btn" data-type="' + type + '" data-page="' + (cur + 1) + '" ' + (cur === pages ? 'disabled' : '') + '>&raquo;</button></li>';
    html += '</ul>';
    html += '<select class="pager-size" data-type="' + type + '">';
    ['10','15','25','50','all'].forEach(function (v) {
        var label = v === 'all' ? 'All' : v + ' / page';
        html += '<option value="' + v + '" ' + (String(sizeVal) === v ? 'selected' : '') + '>' + label + '</option>';
    });
    html += '</select>';
    html += '</div>';

    $pager.html(html);
}

$(document).on('click', '.pg-btn', function () {
    if ($(this).is(':disabled')) return;
    var type = $(this).data('type');
    var page = parseInt($(this).data('page'), 10);
    if (isNaN(page)) return;
    getState(type).page = page;
    savePG();
    paginate(type);
    // scroll table top into view
    var box = $('.lesson-box[data-type="' + type + '"]')[0];
    if (box) box.scrollIntoView({ behavior: 'smooth', block: 'start' });
});

$(document).on('change', '.pager-size', function () {
    var type = $(this).data('type');
    var v = $(this).val();
    var st = getState(type);
    st.size = (v === 'all') ? 'all' : parseInt(v, 10);
    st.page = 1;
    savePG();
    paginate(type);
});

Object.keys(LESSON_CONFIG).forEach(function (type) {
    var tbody = $('.lesson-table[data-type="' + type + '"] tbody');
    var records = LESSON_CONFIG[type].records || [];
    records.forEach(function (rec) { tbody.append(buildRow(type, rec)); });
    if (records.length === 0 && LESSON_CONFIG[type].canWrite) {
        tbody.append(buildRow(type, null));
    }
});
initSelect2();
Object.keys(LESSON_CONFIG).forEach(function (type) { paginate(type); });

function navOffset() {
    var h = document.querySelector('.main-header');
    if (h) { var cs = getComputedStyle(h); if (cs.position === 'fixed') return h.getBoundingClientRect().height; }
    return 0;
}

function buildStickyHeaders() {
    $('.lesson-box').each(function () {
        var type = $(this).attr('data-type');
        if ($('.sticky-head-bar[data-type="' + type + '"]').length) return;
        var $thead = $(this).find('.lesson-table thead').first();
        var $bar = $('<div class="sticky-head-bar" data-type="' + type + '" style="display:none"></div>');
        var $ct  = $('<table class="table table-bordered lesson-table sticky-clone" style="table-layout:fixed"></table>');
        $ct.append($thead.clone());
        $bar.append($ct);
        $('body').append($bar);
    });
}

var _stickyRAF = false;
function updateSticky() {
    if (_stickyRAF) return;
    _stickyRAF = true;
    requestAnimationFrame(function () {
        _stickyRAF = false;
        var off = navOffset();
        $('.lesson-box').each(function () {
            var type   = $(this).attr('data-type');
            var $wrap  = $(this).find('.lesson-table-wrap').first();
            var $table = $(this).find('.lesson-table').first();
            var $thead = $table.find('thead').first();
            var $bar   = $('.sticky-head-bar[data-type="' + type + '"]');
            if (!$wrap.length || !$bar.length) return;

            var wrapEl = $wrap[0];
            var rect   = wrapEl.getBoundingClientRect();
            var headH  = $thead[0].getBoundingClientRect().height;
            var show   = rect.top < off && rect.bottom > (off + headH);

            if (!show) { $bar.hide(); return; }

            $bar.css({ top: off + 'px', left: rect.left + 'px', width: wrapEl.clientWidth + 'px', height: headH + 'px', display: 'block' });

            var $ct = $bar.find('table.sticky-clone');
            $ct.css('width', $table[0].getBoundingClientRect().width + 'px');

            var realThs  = $thead[0].getElementsByTagName('th');
            var cloneThs = $ct[0].getElementsByTagName('th');
            for (var i = 0; i < realThs.length; i++) {
                if (!cloneThs[i]) continue;
                var w = realThs[i].getBoundingClientRect().width + 'px';
                cloneThs[i].style.width = w; cloneThs[i].style.minWidth = w; cloneThs[i].style.maxWidth = w;
            }
            $ct.css('transform', 'translateX(' + (-wrapEl.scrollLeft) + 'px)');
        });
    });
}

buildStickyHeaders();
updateSticky();
$(window).on('scroll resize', updateSticky);
$('.lesson-table-wrap').on('scroll', updateSticky);   
setTimeout(updateSticky, 300);

$('.add-row-btn').on('click', function () {
    var type = $(this).data('type');
    var $row = $(buildRow(type, null));
    $('.lesson-table[data-type="' + type + '"] tbody').prepend($row);
    initSelect2($row);
    getState(type).page = 1;
    paginate(type);
});

$(document).on('click', '.del-row', function () {
    var $tr  = $(this).closest('tr');
    var id   = $tr.data('id');
    var type = $tr.closest('.lesson-table').data('type');

    if (!id) { $tr.remove(); paginate(type); return; }

    Swal.fire({
        title: 'Delete this row?',
        text: 'This record will be permanently deleted.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        confirmButtonColor: '#d33'
    }).then(function (r) {
        if (!r.isConfirmed) return;
        $.post('{{ route('admin.lessons.record.delete') }}', { id: id }, function () {
            $tr.remove();
            paginate(type);
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Deleted', timer: 1500, showConfirmButton: false });
        }).fail(function (xhr) {
            var msg = (xhr.responseJSON && xhr.responseJSON.error) ? xhr.responseJSON.error : 'Could not delete.';
            Swal.fire('Error', msg, 'error');
        });
    });
});

$(document).on('change', '.date-cell', function () {
    var day = dayFromDate($(this).val());
    var td = $(this).closest('td');
    td.find('.day-label').text(day);
    td.find('.day-hidden').val(day);
});

$(document).on('change', '.drop-cell', function () {
    var $sel  = $(this);
    if ($sel.val() !== '__add__') return;

    var type  = $sel.closest('.lesson-table').data('type');
    var field = $sel.data('field');
    $sel.val('').trigger('change.select2');

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
            LESSON_CONFIG[type].options[field] = LESSON_CONFIG[type].options[field] || [];
            LESSON_CONFIG[type].options[field].push({ id: res.option.id, label: res.option.label });

            $('.lesson-table[data-type="' + type + '"] select[data-field="' + field + '"]').each(function () {
                var addOpt = $(this).find('option[value="__add__"]');
                var newOpt = $('<option>').val(res.option.label).text(res.option.label);
                if (addOpt.length) addOpt.before(newOpt); else $(this).append(newOpt);
            });
            $sel.val(res.option.label).trigger('change.select2');
        }).fail(function () {
            Swal.fire('Error', 'Could not add item.', 'error');
        });
    });
});

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

        if (!row.id) {
            var hasData = Object.keys(row).some(function (k) {
                if (k === 'id' || k === 'lesson_date' || k === 'day') return false;
                return row[k] && String(row[k]).trim() !== '';
            });
            if (!hasData) return;   
        }

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